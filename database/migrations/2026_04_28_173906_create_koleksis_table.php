<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('koleksis', function (Blueprint $table) {
            $table->id();
            
            // RELASI KE TABEL KATEGORI
            $table->foreignId('kategori_id')->constrained('kategori_koleksis')->onDelete('cascade');
            
            $table->string('nama_koleksi'); 
            $table->text('deskripsi'); 
            $table->string('foto')->nullable(); 
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('koleksis');
    }
};