<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KopAbsensi extends Model
{
    use HasFactory;
    protected $table = "kop_absensi";
    protected $guarded = [];

    public $timestamps = false;
}
