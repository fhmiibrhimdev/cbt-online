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
        Schema::create('soal_siswa', function (Blueprint $table) {
            $table->id();
            // $table->text('id_bank')->default('');
            // $table->text('id_jadwal')->default('');
            $table->text('id_nilai_soal')->default('');
            $table->text('id_soal')->default('');
            // $table->text('id_siswa')->default('');
            $table->text('jenis_soal')->default('');
            $table->text('no_soal_alias')->default('');
            $table->text('opsi_alias_a')->default('');
            $table->text('opsi_alias_b')->default('');
            $table->text('opsi_alias_c')->default('');
            $table->text('opsi_alias_d')->default('');
            $table->text('opsi_alias_e')->default('');
            $table->text('jawaban_alias')->default('');
            $table->text('jawaban_siswa')->default('');
            $table->enum('ragu', ['0', '1'])->default('0');
            $table->text('jawaban_benar')->default('');
            $table->text('point_essai')->default('0');
            $table->text('soal_end')->default('0');
            $table->text('point_soal')->default('0');
            $table->text('nilai_koreksi')->default('0');
            $table->text('nilai_otomatis')->default('0');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('soal_siswa');
    }
};
