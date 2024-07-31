<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SesiSiswa extends Model
{
    use HasFactory;
    protected $table = "sesi_siswa";
    protected $guarded = [];

    public $timestamps = false;
}
