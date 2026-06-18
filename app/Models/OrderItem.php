<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Order; // Dipanggil agar relasi mengenali model Order

class OrderItem extends Model
{
    // Mengizinkan kolom diisi oleh sistem
    protected $fillable = [
        'order_id',
        'product_id',
        'product_name',
        'variant_name',
        'quantity',
        'price'
    ];

    /**
     * Relasi Balik: Setiap item pesanan ini termasuk dalam satu Order utama
     */
    public function order()
    {
        // Menghubungkan kembali order_items ke model Order lewat order_id
        return $this->belongsTo(Order::class, 'order_id', 'id');
    }
}