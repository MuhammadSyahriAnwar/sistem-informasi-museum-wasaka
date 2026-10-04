<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Laporan extends Model
{
    use HasFactory;

    // Tambahkan jenis_pelapor, nama_pelapor, dan no_hp
    protected $fillable = [
        'user_id', 
        'jenis_pelapor', 
        'nama_pelapor', 
        'no_hp', 
        'kategori', 
        'judul_laporan', 
        'deskripsi', 
        'status', 
        'foto'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}