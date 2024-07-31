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
        Schema::create('kop_absensi', function (Blueprint $table) {
            $table->id();
            $table->text('header_1');
            $table->text('header_2');
            $table->text('header_3');
            $table->text('header_4');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kop_absensi');
    }
};
