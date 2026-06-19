<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;     // WAJIB DIPANGGIL untuk menyimpan data order
use App\Models\OrderItem; // WAJIB DIPANGGIL untuk menyimpan rincian item order

class CheckoutController extends Controller
{
    // 1. Menampilkan Halaman Checkout (Ringkasan & Form Alamat)
    public function index()
    {
        // Ambil data keranjang dari session belanja
        $cart = session()->get('cart', []);
        
        // Jika keranjang kosong, kembalikan ke halaman keranjang dengan pesan peringatan
        if (empty($cart)) {
            return redirect()->route('cart.index')->with('success', 'Keranjang kamu kosong, silakan pilih produk dulu!');
        }

        // Hitung total belanjaan secara presisi
        $total = 0;
        foreach ($cart as $id => $details) {
            $total += $details['price'] * $details['quantity'];
        }

        // Ambil data user yang sedang login (jika ada) untuk autofill
        $user = auth()->user();

        // Kirim data ke file view checkout/index.blade.php
        return view('checkout.index', compact('cart', 'total', 'user'));
    }

    // 2. Memproses Data Form Pengiriman & Menyelesaikan Pesanan
   // 2. Memproses Data Form Pengiriman & Menyelesaikan Pesanan
    // 2. Memproses Data Form Pengiriman & Menyelesaikan Pesanan
    public function process(Request $request)
    {
        // Validasi input data pengiriman dari pembeli
        $request->validate([
            'nama_penerima' => 'required|string|max:255',
            'telepon'       => 'required|string|max:20',
            'alamat_lengkap'=> 'required|string',
            'metode_bayar'  => 'required|string',
        ]);

        // Ambil data keranjang dari session
        $cart = session()->get('cart', []);

        if (empty($cart)) {
            return redirect()->route('cart.index')->with('success', 'Transaksi gagal karena keranjang kosong.');
        }

        // Hitung total harga keseluruhan dari isi keranjang belanja
        $totalHarga = 0;
        foreach ($cart as $id => $details) {
            $hargaItem = $details['price'] ?? 0;
            $totalHarga += $hargaItem * $details['quantity'];
        }

        // Gunakan Database Transaction agar aman
        \DB::beginTransaction();

        try {
            // Cek ketersediaan stok terlebih dahulu
            foreach ($cart as $id => $details) {
                if (!empty($details['variant_id'])) {
                    $variant = \App\Models\ProductVariant::lockForUpdate()->find($details['variant_id']);
                    if (!$variant || $variant->stok < $details['quantity']) {
                        throw new \Exception("Stok untuk produk {$details['name']} ({$details['variant_name']}) tidak mencukupi.");
                    }
                }
            }
            // PROSES 1: Simpan data utama transaksi ke tabel 'orders'
            $order = new Order();
            if (auth()->check()) {
                $order->user_id = auth()->id();
            }
            $order->nama_penerima = $request->nama_penerima;
            $order->telepon       = $request->telepon;
            $order->alamat_lengkap= $request->alamat_lengkap;
            $order->metode_bayar  = $request->metode_bayar;
            $order->total_harga   = (int) $totalHarga;
            $order->status        = 'diproses'; 
            $order->save();

            // PROSES 2: Pindahkan setiap item produk dari session keranjang ke tabel 'order_items'
            foreach ($cart as $id => $details) {
                $orderItem = new OrderItem();
                $orderItem->order_id     = $order->id;
                
                $orderItem->product_name = $details['name'] ?? 'Produk Tanpa Nama';
                
                // SINKRONISASI MUTLAK: Mengambil key 'variant_name' sesuai isi CartController kamu
                $orderItem->variant_name = $details['variant_name'] ?? ($details['variant'] ?? 'Standard');
                
                $orderItem->quantity     = $details['quantity'] ?? 1;
                $orderItem->price        = (int) ($details['price'] ?? 0);
                $orderItem->save();

                // Kurangi stok di database
                if (!empty($details['variant_id'])) {
                    $variant = \App\Models\ProductVariant::find($details['variant_id']);
                    if ($variant) {
                        $variant->stok -= $details['quantity'];
                        $variant->save();
                    }
                }
            }

            // Jika semua proses simpan ke DB berhasil, commit datanya
            \DB::commit();

            // Hapus session keranjang setelah data PASTI aman di database
            session()->forget('cart');

            return redirect()->route('home')->with('success', 'Pesanan kamu berhasil diproses! Terima kasih sudah berbelanja di Wonder Shope.');

        } catch (\Exception $e) {
            // Jika ada error internal, batalkan transaksi
            \DB::rollBack();
            return redirect()->back()->withInput()->with('error', 'Terjadi kesalahan sistem: ' . $e->getMessage());
        }
    }
}