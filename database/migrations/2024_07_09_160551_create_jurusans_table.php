<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJurusansTable extends Migration
{
    public function up()
    {
        Schema::create('jurusan', function (Blueprint $table) {
            $table->id();
            $table->text('nama_jurusan');
            $table->text('kode_jurusan');
            $table->text('mapel_peminatan');
            $table->enum('status', ['0', '1'])->default('1');
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('jurusan');
    }
}
