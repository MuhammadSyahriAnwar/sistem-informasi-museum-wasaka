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
    Schema::table('koleksis', function (Blueprint $table) {
        // Menambahkan kolom file_audio setelah kolom deskripsi
        $table->string('file_audio')->nullable()->after('deskripsi');
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('koleksis', function (Blueprint $table) {
            //
        });
    }
};
