<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;   // Memanggil model Product
use App\Models\Order;     // Memanggil model Order
use App\Models\OrderItem; // WAJIB DIPANGGIL AGAR TIDAK EROR CLASS NOT FOUND

class AdminController extends Controller
{
    /**
     * HALAMAN UTAMA: Dashboard Statistik Admin
     */
    public function index()
    {
        // 1. Hitung total omset HANYA dari pesanan yang sudah 'selesai'
        $totalOmset = Order::where('status', 'selesai')->sum('total_harga');

        // 2. Hitung total barang terjual HANYA dari pesanan yang sudah 'selesai'
        $totalTerjual = OrderItem::whereHas('order', function($query) {
            $query->where('status', 'selesai');
        })->sum('quantity');

        // 3. Hitung total katalog aktif dari tabel products
        $totalProduk = Product::count();
        
        // Hitung total barang diretur
        $totalRetur = OrderItem::whereHas('order', function($query) {
            $query->where('status', 'retur');
        })->sum('quantity');
        
        $totalPesanan = Order::count();

        // 4. Aktivitas Terkini (5 pesanan terbaru berdasarkan update)
        $recentActivities = Order::latest('updated_at')->take(5)->get();

        // 5. Tren Penjualan 7 Hari Terakhir (Hanya yang selesai)
        $salesChart = [];
        $maxSales = 1; // Prevent division by zero
        for ($i = 6; $i >= 0; $i--) {
            $date = \Carbon\Carbon::now()->subDays($i)->format('Y-m-d');
            $dailySales = Order::where('status', 'selesai')
                               ->whereDate('updated_at', $date)
                               ->sum('total_harga');
            $salesChart[] = [
                'date' => \Carbon\Carbon::now()->subDays($i)->translatedFormat('d M'),
                'total' => $dailySales
            ];
            if ($dailySales > $maxSales) {
                $maxSales = $dailySales;
            }
        }

        return view('admin.dashboard', compact('totalOmset', 'totalTerjual', 'totalRetur', 'totalProduk', 'totalPesanan', 'recentActivities', 'salesChart', 'maxSales'));
    }

    /**
     * Menampilkan Halaman Barang Terjual (Riwayat Item Selesai)
     */
    public function barangTerjual()
    {
        // Ambil item yang status orderannya sudah 'selesai' saja
        $itemsTerjual = OrderItem::whereHas('order', function($query) {
            $query->where('status', 'selesai');
        })->with('order')->latest()->get();

        return view('admin.terjual.index', compact('itemsTerjual'));
    }

    /**
     * Menampilkan Halaman Barang Retur
     */
    public function barangRetur()
    {
        // Ambil item yang status orderannya sudah 'retur' saja
        $itemsRetur = OrderItem::whereHas('order', function($query) {
            $query->where('status', 'retur');
        })->with('order')->latest()->get();

        return view('admin.retur.index', compact('itemsRetur'));
    }

    /**
     * HALAMAN KELOLA PRODUK
     */
    public function produkIndex()
    {
        $products = Product::with('variants')->latest()->get();
        return view('products.index', compact('products'));
    }

    /**
     * Menampilkan semua pesanan masuk untuk dikelola Admin (Diproses, Dikirim, Selesai)
     */
    public function kelolaPesanan()
    {
        // Ambil data order yang masih aktif (diproses / dikirim)
        $orders = Order::with('items')
            ->whereIn('status', ['diproses', 'dikirim'])
            ->latest()
            ->get();
        return view('admin.pesanan.index', compact('orders'));
    }

    // 5. Mengubah Status Pesanan menjadi Dikirim
    public function kirimPesanan($id)
    {
        $order = Order::findOrFail($id);
        if ($order->status == 'diproses') {
            $order->status = 'dikirim';
            $order->save();
            return redirect()->back()->with('success', 'Pesanan berhasil diubah statusnya menjadi Dikirim.');
        }
        return redirect()->back()->with('error', 'Status pesanan tidak valid untuk dikirim.');
    }

    // 6. Mengubah Status Pesanan menjadi Batal dan Mengembalikan Stok
    public function batalPesanan($id)
    {
        $order = Order::with('items')->findOrFail($id);
        if ($order->status == 'diproses') {
            $order->status = 'batal';
            $order->save();

            // Kembalikan stok
            foreach ($order->items as $item) {
                $variant = \App\Models\ProductVariant::where('nama_varian', $item->variant_name)->first();
                if ($variant) {
                    $variant->stok += $item->quantity;
                    $variant->save();
                }
            }

            return redirect()->back()->with('success', 'Pesanan dibatalkan dan stok telah dikembalikan.');
        }
        return redirect()->back()->with('error', 'Pesanan ini tidak dapat dibatalkan.');
    }

    // 7. Mengubah Status Pesanan menjadi Retur dan Mengembalikan Stok
    public function returPesanan($id)
    {
        $order = Order::with('items')->findOrFail($id);
        if ($order->status == 'selesai' || $order->status == 'dikirim') {
            $order->status = 'retur';
            $order->save();

            // Kembalikan stok
            foreach ($order->items as $item) {
                $variant = \App\Models\ProductVariant::where('nama_varian', $item->variant_name)->first();
                if ($variant) {
                    $variant->stok += $item->quantity;
                    $variant->save();
                }
            }

            return redirect()->back()->with('success', 'Pesanan diretur dan stok telah dikembalikan.');
        }
        return redirect()->back()->with('error', 'Pesanan ini tidak dapat diretur.');
    }
}