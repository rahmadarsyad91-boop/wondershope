<?php

use App\Http\Controllers\ProductController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\AdminController; 
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\ProfileController; // Di-import agar tidak eror Class ProfileController does not exist
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes - Wonder Shope
|--------------------------------------------------------------------------
*/

// 1. Katalog Toko Utama (Home)
Route::get('/', [ProductController::class, 'index'])->name('home');

// 2. Detail Produk
Route::get('/product/{slug}', [ProductController::class, 'show'])->name('products.show');

// 3. Jalur Khusus Admin Dashboard (Prefix: admin)
Route::middleware(['auth', 'admin'])->prefix('admin')->group(function () {
    
    // Halaman Utama Dashboard Admin
    Route::get('/', [AdminController::class, 'index'])->name('admin.dashboard');
    
    // Kelola Katalog Produk
    Route::get('/products', [AdminController::class, 'produkIndex'])->name('admin.products.index');
    
    // Barang Terjual & Retur
    Route::get('/barang-terjual', [AdminController::class, 'barangTerjual'])->name('admin.terjual.index');
    Route::get('/barang-retur', [AdminController::class, 'barangRetur'])->name('admin.retur.index');
    
    // Kelola Status Transaksi Alur Pesanan
    Route::get('/kelola-pesanan', [AdminController::class, 'kelolaPesanan'])->name('admin.pesanan.index');
    Route::post('/pesanan/{id}/kirim', [AdminController::class, 'kirimPesanan'])->name('admin.pesanan.kirim');
    Route::post('/pesanan/{id}/batal', [AdminController::class, 'batalPesanan'])->name('admin.pesanan.batal');
    Route::post('/pesanan/{id}/retur', [AdminController::class, 'returPesanan'])->name('admin.pesanan.retur');
    
    // Fitur Aksi CRUD Produk (Tambah, Edit, Delete)
    Route::get('/product/create', [ProductController::class, 'create'])->name('products.create');
    Route::post('/product/store', [ProductController::class, 'store'])->name('products.store');
    Route::get('/product/{id}/edit', [ProductController::class, 'edit'])->name('products.edit');
    Route::put('/product/{id}', [ProductController::class, 'update'])->name('products.update');
    Route::delete('/product/{id}', [ProductController::class, 'destroy'])->name('products.destroy');
});

// 4. Keranjang Belanja
Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::post('/cart/add', [CartController::class, 'add'])->name('cart.add');
Route::patch('/cart/update', [CartController::class, 'update'])->name('cart.update');
Route::delete('/cart/remove/{id}', [CartController::class, 'remove'])->name('cart.remove');

// 5. Fitur Checkout Pembayaran
Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
Route::post('/checkout/process', [CheckoutController::class, 'process'])->name('checkout.process');

// 6. Jalur Riwayat Pesanan Member (Hanya untuk User Login)
Route::middleware('auth')->group(function () {
    Route::get('/riwayat-pesanan', [ProfileController::class, 'riwayatPesanan'])->name('member.pesanan');
    Route::get('/riwayat-pesanan/{id}', [ProfileController::class, 'showPesanan'])->name('member.pesanan.show');
    Route::post('/pesanan/{id}/diterima', [ProfileController::class, 'konfirmasiDiterima'])->name('member.pesanan.diterima');
});

// 7. Autentikasi Breeze
require __DIR__.'/auth.php';