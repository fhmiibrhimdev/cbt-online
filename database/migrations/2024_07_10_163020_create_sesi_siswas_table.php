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
        Schema::create('sesi_siswa', function (Blueprint $table) {
            $table->id();
            $table->text('id_kelas');
            $table->text('id_siswa');
            $table->text('id_ruang');
            $table->text('id_sesi');
            $table->text('id_tp');
            $table->text('id_smt');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sesi_siswa');
    }
};
