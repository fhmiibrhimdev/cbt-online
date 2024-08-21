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
        Schema::create('siswa', function (Blueprint $table) {
            $table->id();
            $table->text('id_tp');
            $table->text('id_smt');
            $table->text('id_user');
            $table->text('nama_siswa')->default("");
            $table->text('nis')->default("");
            $table->text('nisn')->default("");
            $table->text('jk')->default("");
            $table->text('kelas')->default("");
            $table->text('tahun_masuk')->default("");
            $table->text('sekolah_asal')->default("");
            $table->enum('status', ['Aktif', 'Lulus', 'Pindah', 'Keluar'])->default("Aktif");
            $table->text('tempat_lahir')->default("");
            $table->text('tgl_lahir')->default("");
            $table->text('agama')->default("");
            $table->text('alamat')->default("");
            $table->text('rt')->default("");
            $table->text('rw')->default("");
            $table->text('kelurahan_desa')->default("");
            $table->text('kecamatan')->default("");
            $table->text('kabupaten_kota')->default("");
            $table->text('kode_pos')->default("");
            $table->text('no_hp')->default("");
            $table->enum('status_keluarga', ['Anak Kandung', 'Anak Tiri', 'Anak Angkat'])->default("Anak Kandung");
            $table->text('anak_ke')->default("");
            $table->text('nama_ayah')->default("");
            $table->text('pekerjaan_ayah')->default("");
            $table->text('alamat_ayah')->default("");
            $table->text('nohp_ayah')->default("");
            $table->text('nama_ibu')->default("");
            $table->text('pekerjaan_ibu')->default("");
            $table->text('alamat_ibu')->default("");
            $table->text('nohp_ibu')->default("");
            $table->text('nama_wali')->default("");
            $table->text('pekerjaan_wali')->default("");
            $table->text('alamat_wali')->default("");
            $table->text('nohp_wali')->default("");
            $table->enum('status_kelas', ['0', '1'])->default("0");
            $table->text('id_kelas')->default("0");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('siswa');
    }
};
