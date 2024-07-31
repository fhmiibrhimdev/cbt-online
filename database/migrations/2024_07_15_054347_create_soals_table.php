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
        Schema::create('soal', function (Blueprint $table) {
            $table->id();
            $table->text('id_bank');
            $table->enum('jenis', ['1', '2', '3', '4', '5'])->default('1');
            $table->text('nomor_soal')->default('');
            $table->text('soal')->default('');
            $table->text('opsi_a')->default('');
            $table->text('opsi_b')->default('');
            $table->text('opsi_c')->default('');
            $table->text('opsi_d')->default('');
            $table->text('opsi_e')->default('');
            $table->text('jawaban')->default('');
            $table->enum('tampilkan', ['1', '0'])->default('0');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('soal');
    }
};
