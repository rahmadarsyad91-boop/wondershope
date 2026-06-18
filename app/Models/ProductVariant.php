<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductVariant extends Model
{
    protected $fillable = ['product_id', 'nama_varian', 'stok'];

    /**
     * Relasi balik ke model Product
     */
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
