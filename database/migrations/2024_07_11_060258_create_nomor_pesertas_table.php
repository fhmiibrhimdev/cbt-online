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
        Schema::create('nomor_peserta', function (Blueprint $table) {
            $table->id();
            $table->text('id_siswa');
            $table->text('id_tp');
            $table->text('id_smt');
            $table->text('nomor_peserta');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('nomor_peserta');
    }
};
