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
        Schema::create('kop_kartu', function (Blueprint $table) {
            $table->id();
            $table->text('header_1');
            $table->text('header_2');
            $table->text('header_3');
            $table->text('header_4');
            $table->text('tanggal');
            $table->text('nomor_peserta')->default('0');
            $table->text('nama_peserta')->default('0');
            $table->text('nis_nisn')->default('0');
            $table->text('ruang_sesi')->default('0');
            $table->text('username')->default('0');
            $table->text('password')->default('0');
            $table->text('ukuran_ttd')->default('3.5');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kop_kartu');
    }
};
