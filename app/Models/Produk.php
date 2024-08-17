<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Produk extends Model
{
    use HasFactory;
    protected $table = "produk";
    protected $guarded = [];

    protected function kategori()
    {
        return $this->belongsTo(Kategori::class, 'kategori_id', 'id');
    }

    protected function brand()
    {
        return $this->belongsTo(Brand::class, 'brand_id', 'id');
    }

    protected function warna()
    {
        return $this->hasMany(Warna::class, 'produk_id', 'id');
    }
}
