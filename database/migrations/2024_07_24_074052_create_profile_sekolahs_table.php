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
        Schema::create('profile_sekolah', function (Blueprint $table) {
            $table->id();
            $table->text('nama_aplikasi')->default('');
            $table->text('nama_sekolah')->default('');
            $table->text('nss_nsm')->default('');
            $table->text('npsn')->default('');
            $table->text('jenjang')->default('');
            $table->text('satuan_pendidikan')->default('');
            $table->text('alamat')->default('');
            $table->text('desa_kelurahan')->default('');
            $table->text('kecamatan')->default('');
            $table->text('kabupaten_kota')->default('');
            $table->text('kodepos')->default('');
            $table->text('provinsi')->default('');
            $table->text('faksimili')->default('');
            $table->text('website')->default('');
            $table->text('email')->default('');
            $table->text('nomor_telepon')->default('');
            $table->text('kepala_sekolah')->default('');
            $table->text('nip')->default('');
            $table->text('ttd')->default('');
            $table->text('logo_aplikasi')->default('');
            $table->text('logo_sekolah')->default('');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('profile_sekolah');
    }
};
