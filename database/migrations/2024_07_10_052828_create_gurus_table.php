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
        Schema::create('guru', function (Blueprint $table) {
            $table->id();
            $table->text('id_tp')->default('');
            $table->text('id_smt')->default('');
            $table->text('id_user')->default('');
            $table->text('nip')->default('');
            $table->text('nama_guru')->default('');
            $table->text('email')->default('');
            $table->text('kode_guru')->default('');
            $table->text('no_ktp')->default('');
            $table->text('tempat_lahir')->default('');
            $table->text('tgl_lahir')->default('');
            $table->text('jk')->default('');
            $table->enum('agama', ['', 'Islam', 'Kristen', 'Katolik', 'Kristen Protestan', 'Hindu', 'Budha', 'Konghucu', 'Lainnya'])->default('');
            $table->text('no_hp')->default('');
            $table->text('alamat')->default('');
            $table->text('rt')->default('');
            $table->text('rw')->default('');
            $table->text('kelurahan_desa')->default('');
            $table->text('kecamatan')->default('');
            $table->text('kabupaten_kota')->default('');
            $table->text('kode_pos')->default('');
            $table->text('kewarganegaraan')->default('');
            $table->text('nuptk')->default('');
            $table->text('jenis_ptk')->default('');
            $table->text('tgs_tambahan')->default('');
            $table->text('status_pegawai')->default('');
            $table->text('status_aktif')->default('');
            $table->text('status_nikah')->default('');
            $table->text('tmt')->default('');
            $table->text('keahlian_isyarat')->default('');
            $table->text('npwp')->default('');
            $table->text('foto')->default('');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('guru');
    }
};
