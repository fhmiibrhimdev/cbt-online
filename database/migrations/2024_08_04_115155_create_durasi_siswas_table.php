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
        Schema::create('durasi_siswa', function (Blueprint $table) {
            $table->id();
            $table->text('id_siswa');
            $table->text('id_jadwal');
            $table->text('id_ruang');
            $table->text('id_sesi');
            $table->enum('status', ['0', '1', '2'])->default('0');
            $table->text('lama_ujian');
            $table->text('mulai');
            $table->text('selesai');
            $table->enum('reset', ['0', '1', '2'])->default('0');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('durasi_siswa');
    }
};
