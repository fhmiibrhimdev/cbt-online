<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KopKartu extends Model
{
    use HasFactory;
    protected $table = "kop_kartu";
    protected $guarded = [];

    public $timestamps = false;
}
