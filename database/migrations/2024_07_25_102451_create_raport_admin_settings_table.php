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
        Schema::create('raport_admin_setting', function (Blueprint $table) {
            $table->id();
            $table->text('id_tp')->default('');
            $table->text('id_smt')->default('');
            $table->text('kkm_tunggal')->default('0');
            $table->text('kkm')->default('');
            $table->text('bobot_ph')->default('');
            $table->text('bobot_pts')->default('');
            $table->text('bobot_pas')->default('');
            $table->text('bobot_absen')->default('');
            $table->text('tgl_raport_akhir')->default('');
            $table->text('tgl_raport_kelas_akhir')->default('');
            $table->text('tgl_raport_pts')->default('');
            $table->text('nip_kepsek')->default('0');
            $table->text('nip_walikelas')->default('0');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('raport_admin_setting');
    }
};
