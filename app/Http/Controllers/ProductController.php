<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductVariant;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    // 1. Menampilkan Katalog Utama (Home)
    public function index(Request $request)
    {
        $query = Product::query();

        if ($request->has('search') && $request->search != '') {
            $query->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('description', 'like', '%' . $request->search . '%');
        }

        if ($request->has('brand') && $request->brand != '') {
            $query->where('brand', $request->brand);
        }

        $products = $query->get();
        return view('home', compact('products'));
    }

    // 2. Menampilkan Detail Produk
    public function show($slug)
    {
        $product = Product::with('variants')->where('slug', $slug)->firstOrFail();
        return view('products.show', compact('product'));
    }

    // 3. Menampilkan Form Tambah Produk
    public function create()
    {
        return view('products.create');
    }

    // 4. Memproses Penyimpanan Data Produk Baru & Varian
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'brand' => 'required',
            'base_price' => 'required|numeric',
            'description' => 'required',
            'image' => 'required|image|mimes:jpeg,png,jpg,webp|max:2048',
            'variants' => 'required|array|min:1',
            'variants.*.nama_varian' => 'required|string',
            'variants.*.stok' => 'required|integer|min:0',
        ]);

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $file->storeAs('products', $fileName, 'public');
        }

        $slug = Str::slug($request->name);

        $product = Product::create([
            'name' => $request->name,
            'slug' => $slug,
            'brand' => $request->brand,
            'base_price' => $request->base_price,
            'description' => $request->description,
            'image' => $fileName,
        ]);

        foreach ($request->variants as $variantData) {
            $product->variants()->create([
                'nama_varian' => $variantData['nama_varian'],
                'stok' => $variantData['stok'],
            ]);
        }

        return redirect()->route('admin.products.index')->with('success', 'Produk dan Varian berhasil ditambahkan!');
    }

    // 5. Menampilkan Tabel Kelola Produk (Admin) - FIXED & CROSSCHECKED
   public function adminIndex()
{
    // Mengambil semua produk beserta variannya dan mengarahkan ke folder admin
    $products = Product::with('variants')->latest()->get();
    return view('admin.products.index', compact('products'));
}

    // 6. Menampilkan Form Edit Produk & Varian
    public function edit($id)
    {
        $product = Product::with('variants')->findOrFail($id);
        return view('products.edit', compact('product'));
    }

    // 7. Memproses Perubahan Data Produk, Varian Lama, & Varian Baru (Dinamis)
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
            'brand' => 'required',
            'base_price' => 'required|numeric',
            'description' => 'required',
            'image' => 'sometimes|image|mimes:jpeg,png,jpg,webp|max:2048',
            'variants' => 'sometimes|array',
            'new_variants' => 'sometimes|array',
        ]);

        $product = Product::findOrFail($id);
        $fileName = $product->image;

        if ($request->hasFile('image')) {
            if ($product->image && Storage::disk('public')->exists('products/' . $product->image)) {
                Storage::disk('public')->delete('products/' . $product->image);
            }
            $file = $request->file('image');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $file->storeAs('products', $fileName, 'public');
        }

        // Update data produk utama
        $product->update([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'brand' => $request->brand,
            'base_price' => $request->base_price,
            'description' => $request->description,
            'image' => $fileName,
        ]);

        // Jalur A: Update varian lama yang diubah nilainya
        if ($request->has('variants')) {
            foreach ($request->variants as $variantData) {
                $product->variants()->where('id', $variantData['id'])->update([
                    'nama_varian' => $variantData['nama_varian'],
                    'stok' => $variantData['stok'],
                ]);
            }
        }

        // Jalur B: Menyimpan varian-varian tambahan baru hasil klik tombol JS
        if ($request->has('new_variants')) {
            foreach ($request->new_variants as $newVariantData) {
                $product->variants()->create([
                    'nama_varian' => $newVariantData['nama_varian'],
                    'stok' => $newVariantData['stok'],
                ]);
            }
        }

        return redirect()->route('admin.products.index')->with('success', 'Produk dan Varian berhasil diperbarui!');
    }

    // 8. Menghapus Produk beserta seluruh variannya
    public function destroy($id)
    {
        $product = Product::findOrFail($id);

        // Hapus foto dari storage jika ada
        if ($product->image && Storage::disk('public')->exists('products/' . $product->image)) {
            Storage::disk('public')->delete('products/' . $product->image);
        }

        // Hapus semua varian terkait, lalu hapus produknya
        $product->variants()->delete();
        $product->delete();

        return redirect()->route('admin.products.index')->with('success', 'Produk berhasil dihapus dari katalog!');
    }
}