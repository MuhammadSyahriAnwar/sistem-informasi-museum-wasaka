<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('pengunjungs', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->string('no_hp')->nullable(); // Tambahan detail kontak pengunjung
            $table->string('asal_instansi')->nullable(); 
            $table->enum('kategori', ['Umum', 'Pelajar/Mahasiswa', 'Instansi']); 
            $table->integer('jumlah_rombongan')->default(1);
            $table->string('sesi_kunjungan'); // Tambahan sesi sesuai jadwal operasional museum
            $table->string('tujuan_kunjungan')->nullable();
            $table->timestamps(); 
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pengunjungs');
    }
};