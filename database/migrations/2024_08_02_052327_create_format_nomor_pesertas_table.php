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
        Schema::create('format_nomor_peserta', function (Blueprint $table) {
            $table->id();
            $table->text('kode_jenjang')->default('0');
            $table->text('kode_tahun')->default('0');
            $table->text('kode_provinsi')->default('0');
            $table->text('kode_kota')->default('0');
            $table->text('kode_sekolah')->default('0');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('format_nomor_peserta');
    }
};
