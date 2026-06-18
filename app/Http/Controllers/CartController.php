<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\ProductVariant;

class CartController extends Controller
{
    // 1. Menampilkan Halaman Keranjang Belanja
    public function index()
    {
        $cart = session()->get('cart', []);
        
        $total = 0;
        foreach ($cart as $id => $details) {
            $total += $details['price'] * $details['quantity'];
        }

        return view('cart.index', compact('cart', 'total'));
    }

    // 2. Memasukkan Produk & Varian ke Keranjang Belanja
    public function add(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'variant_id' => 'nullable|exists:product_variants,id',
            'quantity'   => 'nullable|integer|min:1',
        ]);

        $quantity = $request->input('quantity', 1);

        $product = Product::findOrFail($request->product_id);

        // Ambil varian jika ada, kalau tidak pakai default
        $variantId   = null;
        $variantName = 'Default';

        if ($request->filled('variant_id')) {
            $variant     = ProductVariant::findOrFail($request->variant_id);
            $variantId   = $variant->id;
            $variantName = $variant->nama_varian;
        } elseif ($product->variants()->count() > 0) {
            // Jika produk punya varian tapi tidak dipilih, ambil varian pertama
            $variant     = $product->variants()->first();
            $variantId   = $variant->id;
            $variantName = $variant->nama_varian;
        }

        $cart   = session()->get('cart', []);
        $cartId = $product->id . '-' . ($variantId ?? '0');

        if (isset($cart[$cartId])) {
            $cart[$cartId]['quantity'] += $quantity;
        } else {
            $cart[$cartId] = [
                "product_id"   => $product->id,
                "variant_id"   => $variantId,
                "name"         => $product->name,
                "brand"        => $product->brand,
                "variant_name" => $variantName,
                "quantity"     => $quantity,
                "price"        => $product->base_price,
                "image"        => $product->image,
                "slug"         => $product->slug,
            ];
        }

        session()->put('cart', $cart);

        return redirect()->route('cart.index')->with('success', 'Produk berhasil dimasukkan ke keranjang!');
    }

    // Mengubah Jumlah Produk di Keranjang Belanja
    public function update(Request $request)
    {
        $request->validate([
            'id' => 'required|string',
            'quantity' => 'required|integer|min:1',
        ]);

        $cart = session()->get('cart', []);

        if(isset($cart[$request->id])) {
            // Cek stok varian
            if (!empty($cart[$request->id]['variant_id'])) {
                $variant = \App\Models\ProductVariant::find($cart[$request->id]['variant_id']);
                if ($variant && $variant->stok < $request->quantity) {
                    return redirect()->route('cart.index')->with('error', "Gagal! Sisa stok {$cart[$request->id]['name']} hanya {$variant->stok} pcs.");
                }
            }
            
            $cart[$request->id]['quantity'] = $request->quantity;
            session()->put('cart', $cart);
        }

        return redirect()->route('cart.index')->with('success', 'Jumlah produk berhasil diupdate!');
    }

    // 3. Mengeluarkan Item dari Keranjang Belanja
    public function remove($id)
    {
        $cart = session()->get('cart', []);
        
        if(isset($cart[$id])) {
            unset($cart[$id]);
            session()->put('cart', $cart);
        }
        
        return redirect()->route('cart.index')->with('success', 'Item berhasil dihapus dari keranjang!');
    }
}