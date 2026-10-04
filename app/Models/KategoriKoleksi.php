<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KategoriKoleksi extends Model
{
    use HasFactory;

    protected $fillable = ['nama_kategori'];

    // Relasi: Satu Kategori punya Banyak Koleksi (One to Many)
    public function koleksi()
    {
        return $this->hasMany(Koleksi::class, 'kategori_id');
    }
}