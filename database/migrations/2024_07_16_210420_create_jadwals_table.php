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
        Schema::create('jadwal', function (Blueprint $table) {
            $table->id();
            $table->text('id_tp');
            $table->text('id_smt');
            $table->text('id_bank');
            $table->text('id_jenis_ujian');
            $table->date('tgl_mulai')->default(date('Y-m-d'));
            $table->date('tgl_selesai')->default(date('Y-m-d'));
            $table->text('durasi_ujian')->default('0');
            $table->text('acak_soal')->default('0');
            $table->text('acak_opsi')->default('0');
            $table->text('hasil_tampil')->default('0');
            $table->text('token')->default('0');
            $table->text('status')->default('0');
            $table->text('ulang')->default('0');
            $table->text('reset_login')->default('0');
            $table->text('rekap')->default('0');
            $table->text('jam_ke')->default('0');
            $table->text('jarak')->default('0');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jadwal');
    }
};
