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
        Schema::create('kelas', function (Blueprint $table) {
            $table->id();
            $table->text('id_tp');
            $table->text('id_smt');
            $table->text('nama_kelas');
            $table->text('kode_kelas');
            $table->text('id_jurusan');
            $table->text('id_level');
            $table->text('id_guru');
            $table->text('jumlah_siswa');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kelas');
    }
};
