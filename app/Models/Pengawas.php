<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pengawas extends Model
{
    use HasFactory;

    protected $table = "pengawas";
    protected $guarded = [];

    public $timestamps = false;
}
