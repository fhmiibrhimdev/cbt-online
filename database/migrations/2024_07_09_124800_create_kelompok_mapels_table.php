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
        Schema::create('kelompok_mapel', function (Blueprint $table) {
            $table->id();
            $table->text('kategori');
            $table->text('kode_kelompok');
            $table->text('nama_kelompok');
            $table->text('id_parent');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kelompok_mapel');
    }
};
