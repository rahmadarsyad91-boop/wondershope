<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\OrderItem;
class Order extends Model
{
    // Daftarkan kolom-kolom tabel yang boleh diisi oleh sistem
    protected $fillable = [
        'user_id',
        'nama_penerima',
        'telepon',
        'alamat_lengkap',
        'metode_bayar',
        'total_harga',
        'status'
    ];

    /**
     * Relasi ke tabel order_items (Satu order memiliki banyak item produk)
     */
    public function items()
    {
        return $this->hasMany(OrderItem::class, 'order_id', 'id');
    }

    /**
     * Relasi ke tabel users (Satu order dimiliki oleh satu user)
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}