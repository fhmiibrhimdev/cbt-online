<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KelasDetail extends Model
{
    use HasFactory;
    protected $table = "kelas_detail";
    protected $guarded = [];
    
    public $timestamps = false;
}
