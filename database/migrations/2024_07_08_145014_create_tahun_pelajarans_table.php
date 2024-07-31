<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTahunPelajaransTable extends Migration
{
    public function up()
    {
        Schema::create('tahun_pelajaran', function (Blueprint $table) {
            $table->id();
            $table->text('tahun');
            $table->enum('active', ['0', '1'])->default('0');
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('tahun_pelajaran');
    }
}
