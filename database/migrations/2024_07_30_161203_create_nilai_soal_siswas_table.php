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
            $table->text('pg_benar')->default('0');
            $table->text('pg_salah')->default('0');
            $table->text('nilai_pg')->default('0');
            $table->text('nilai_pk')->default('0');
            $table->text('nilai_jo')->default('0');
            $table->text('nilai_is')->default('0');
            $table->text('nilai_es')->default('0');
            // $table->text('total_nilai')->default('0');
            $table->enum('status', ['0', '1'])->default('0');
            $table->enum('dikoreksi', ['0', '1'])->default('0');
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
