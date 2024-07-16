<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JabatanGuru extends Model
{
    use HasFactory;
    protected $table = "jabatan_guru";
    protected $guarded = [];
    
    public $timestamps = false;
}
