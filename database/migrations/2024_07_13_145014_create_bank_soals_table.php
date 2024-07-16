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
        Schema::create('bank_soal', function (Blueprint $table) {
            $table->id();
            $table->text('kode_bank');

            $table->text('id_level')->default('0');
            $table->text('id_kelas')->default('0');
            $table->text('id_mapel')->default('0');
            $table->text('id_jurusan')->default('0');
            $table->text('id_guru')->default('0');
            $table->text('id_tp');
            $table->text('id_smt');

            $table->text('jml_pg')->default('0');
            $table->text('jml_kompleks')->default('0');
            $table->text('jml_jodohkan')->default('0');
            $table->text('jml_isian')->default('0');
            $table->text('jml_esai')->default('0');

            $table->text('tampil_pg')->default('0');
            $table->text('tampil_kompleks')->default('0');
            $table->text('tampil_jodohkan')->default('0');
            $table->text('tampil_isian')->default('0');
            $table->text('tampil_esai')->default('0');
            
            $table->text('bobot_pg')->default('0');
            $table->text('bobot_kompleks')->default('0');
            $table->text('bobot_jodohkan')->default('0');
            $table->text('bobot_isian')->default('0');
            $table->text('bobot_esai')->default('0');
            
            $table->text('opsi')->default('0');
            $table->text('kkm')->default('0');
            $table->text('deskripsi')->default('');
            $table->enum('status_soal', ['1', '0'])->default('0');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bank_soal');
    }
};
