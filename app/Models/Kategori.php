<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kategori extends Model
{
    use HasFactory;
    protected $table = "kategori";
    protected $guarded = [];

    protected function subkategori()
    {
        return $this->hasMany(Kategori::class, 'parent_id', 'id');
    }

    protected function parentkategori()
    {
        return $this->belongsTo(Kategori::class, 'parent_id', 'id');
    }

    protected function produk()
    {
        return $this->hasMany(Produk::class, 'kategori_id', 'id');
    }
}
