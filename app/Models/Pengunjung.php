<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pengunjung extends Model
{
    use HasFactory;

    // Menentukan kolom mana saja yang boleh diisi (mass assignment)
    protected $fillable = [
        'nama',
        'no_hp',            // Tambahan kolom baru
        'asal_instansi',
        'kategori',
        'jumlah_rombongan',
        'sesi_kunjungan',   // Tambahan kolom baru
        'tujuan_kunjungan'
    ];
}