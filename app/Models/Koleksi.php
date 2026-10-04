<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Koleksi extends Model
{
    use HasFactory;

    protected $fillable = [
        'kategori_id', // WAJIB DITAMBAHKAN
        'nama_koleksi',
        'deskripsi',
        'foto'
    ];

    // Relasi: Setiap Koleksi dimiliki oleh Satu Kategori (Belongs To)
    public function kategori()
    {
        return $this->belongsTo(KategoriKoleksi::class, 'kategori_id');
    }
}