<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SoalSiswa extends Model
{
    use HasFactory;
    protected $table = "soal_siswa";
    protected $guarded = [];

    protected $hidden = ['jawaban_alias', 'jawaban_benar', 'jawaban_siswa'];
}
