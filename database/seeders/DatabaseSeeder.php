<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash; // Jangan lupa ini buat enkripsi password

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Bikin Akun Admin
        User::create([
            'name' => 'Syahri',
            'email' => 'admin@wasaka.com',
            'password' => Hash::make('password123'),
            'role' => 'admin',
        ]);

        // Bikin Akun Petugas
        User::create([
            'name' => 'Rifqi',
            'email' => 'petugas@wasaka.com',
            'password' => Hash::make('password123'),
            'role' => 'petugas',
        ]);

        // Suntik Data Kategori Koleksi Museum Wasaka (REVISI FINAL)
        \App\Models\KategoriKoleksi::insert([
            ['nama_kategori' => 'Senjata & Perlengkapan Perjuangan', 'created_at' => now(), 'updated_at' => now()],
            ['nama_kategori' => 'Perabotan & Barang Pribadi (Benda Historis)', 'created_at' => now(), 'updated_at' => now()],
            ['nama_kategori' => 'Pakaian & Tekstil Bersejarah', 'created_at' => now(), 'updated_at' => now()],
            ['nama_kategori' => 'Arsip & Dokumen Sejarah', 'created_at' => now(), 'updated_at' => now()],
            ['nama_kategori' => 'Karya Seni & Visual', 'created_at' => now(), 'updated_at' => now()],
            ['nama_kategori' => 'Sejarah & Profil Daerah', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}