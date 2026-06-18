<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = ['name', 'slug', 'brand', 'description', 'base_price', 'image'];

public function variants()
{
    return $this->hasMany(ProductVariant::class);
}
}
