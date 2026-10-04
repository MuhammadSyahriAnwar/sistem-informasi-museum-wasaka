<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
 public function up()
{
    Schema::create('laporans', function (Blueprint $table) {
        $table->id();
        
        // Diubah menjadi nullable karena Pengunjung tidak punya akun/login
        $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('cascade'); 
        
        // Identifikasi pembeda asal laporan
        $table->enum('jenis_pelapor', ['Petugas', 'Pengunjung'])->default('Petugas');
        $table->string('nama_pelapor')->nullable(); // Nama untuk pengunjung
        $table->string('no_hp')->nullable(); // Kontak WA/HP untuk pengunjung
        
        $table->string('kategori'); // Nanti di frontend kita tambah opsi 'Lainnya'
        $table->string('judul_laporan');
        $table->text('deskripsi');
        $table->enum('status', ['Menunggu', 'Diproses', 'Selesai'])->default('Menunggu');
        $table->string('foto')->nullable(); 
        $table->timestamps();
    });
}
};
