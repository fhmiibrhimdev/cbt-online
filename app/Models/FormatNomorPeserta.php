<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FormatNomorPeserta extends Model
{
    use HasFactory;
    protected $table = "format_nomor_peserta";
    protected $guarded = [];

    public $timestamps = false;
}
