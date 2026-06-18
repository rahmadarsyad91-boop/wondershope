<?php

define('LARAVEL_START', microtime(true));
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);
$app->boot();

echo "=== Pengujian Semua Halaman Wonder Shope ===" . PHP_EOL . PHP_EOL;

// Test AdminController
try {
    $ctrl = new App\Http\Controllers\AdminController();
    $r = $ctrl->index();
    echo "[OK]  Admin Dashboard (/ admin)" . PHP_EOL;
} catch (Exception $e) {
    echo "[ERR] Admin Dashboard: " . $e->getMessage() . PHP_EOL;
}

try {
    $ctrl = new App\Http\Controllers\AdminController();
    $r = $ctrl->kelolaPesanan();
    echo "[OK]  Admin Pesanan Masuk (/admin/kelola-pesanan)" . PHP_EOL;
} catch (Exception $e) {
    echo "[ERR] Admin Pesanan: " . $e->getMessage() . PHP_EOL;
}

try {
    $ctrl = new App\Http\Controllers\AdminController();
    $r = $ctrl->barangTerjual();
    echo "[OK]  Admin Barang Terjual (/admin/barang-terjual)" . PHP_EOL;
} catch (Exception $e) {
    echo "[ERR] Barang Terjual: " . $e->getMessage() . PHP_EOL;
}

try {
    $ctrl = new App\Http\Controllers\AdminController();
    $r = $ctrl->barangRetur();
    echo "[OK]  Admin Barang Retur (/admin/barang-retur)" . PHP_EOL;
} catch (Exception $e) {
    echo "[ERR] Barang Retur: " . $e->getMessage() . PHP_EOL;
}

try {
    $ctrl = new App\Http\Controllers\AdminController();
    $r = $ctrl->produkIndex();
    echo "[OK]  Admin Kelola Produk (/admin/products)" . PHP_EOL;
} catch (Exception $e) {
    echo "[ERR] Produk Index: " . $e->getMessage() . PHP_EOL;
}

// Test ProductController
try {
    $ctrl = new App\Http\Controllers\ProductController();
    $r = $ctrl->index();
    echo "[OK]  Home / Katalog (/)" . PHP_EOL;
} catch (Exception $e) {
    echo "[ERR] Home: " . $e->getMessage() . PHP_EOL;
}

try {
    $p = App\Models\Product::first();
    $ctrl = new App\Http\Controllers\ProductController();
    $r = $ctrl->show($p->slug);
    echo "[OK]  Detail Produk (/product/" . $p->slug . ")" . PHP_EOL;
} catch (Exception $e) {
    echo "[ERR] Product Show: " . $e->getMessage() . PHP_EOL;
}

try {
    $ctrl = new App\Http\Controllers\ProductController();
    $r = $ctrl->create();
    echo "[OK]  Tambah Produk (/admin/product/create)" . PHP_EOL;
} catch (Exception $e) {
    echo "[ERR] Tambah Produk: " . $e->getMessage() . PHP_EOL;
}

try {
    $p = App\Models\Product::first();
    $ctrl = new App\Http\Controllers\ProductController();
    $r = $ctrl->edit($p->id);
    echo "[OK]  Edit Produk (/admin/product/{id}/edit)" . PHP_EOL;
} catch (Exception $e) {
    echo "[ERR] Edit Produk: " . $e->getMessage() . PHP_EOL;
}

// Test CartController
try {
    $ctrl = new App\Http\Controllers\CartController();
    $r = $ctrl->index();
    echo "[OK]  Keranjang (/cart)" . PHP_EOL;
} catch (Exception $e) {
    echo "[ERR] Cart: " . $e->getMessage() . PHP_EOL;
}

// Test CheckoutController
try {
    // Set cart session to avoid empty cart redirect
    session()->put('cart', [
        '1-1' => [
            'product_id' => 1, 'variant_id' => 1,
            'name' => 'Test', 'brand' => 'Test', 'variant_name' => 'Default',
            'quantity' => 1, 'price' => 100000, 'image' => null, 'slug' => 'test',
        ]
    ]);
    $ctrl = new App\Http\Controllers\CheckoutController();
    $r = $ctrl->index();
    echo "[OK]  Checkout (/checkout)" . PHP_EOL;
} catch (Exception $e) {
    echo "[ERR] Checkout: " . $e->getMessage() . PHP_EOL;
}

echo PHP_EOL . "=== Pengujian Selesai ===" . PHP_EOL;
