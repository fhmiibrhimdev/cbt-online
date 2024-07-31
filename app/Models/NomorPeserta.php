<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NomorPeserta extends Model
{
    use HasFactory;

    protected $table = "nomor_peserta";
    protected $guarded = [];

    public $timestamps = false;
}
