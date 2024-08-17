<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Brand extends Model
{
    use HasFactory;
    protected $table = "brand";
    protected $guarded = [];

    protected function produk()
    {
        return $this->hasMany(Produk::class, 'brand_id', 'id');
    }
}
