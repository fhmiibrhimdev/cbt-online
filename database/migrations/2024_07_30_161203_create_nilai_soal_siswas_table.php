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
        Schema::create('nilai_soal_siswa', function (Blueprint $table) {
            $table->id();
            $table->text('tanggal');
            $table->text('id_bank')->default('0');
            $table->text('id_jadwal')->default('0');
            $table->text('id_siswa')->default('0');
            $table->text('total_nilai')->default('0');
            $table->enum('status_ujian', ['0', '1'])->default('0');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('nilai_soal_siswa');
    }
};
