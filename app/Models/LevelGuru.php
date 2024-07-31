<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LevelGuru extends Model
{
    use HasFactory;
    protected $table = "level_guru";
    protected $guarded = [];
    
    public $timestamps = false;
}
