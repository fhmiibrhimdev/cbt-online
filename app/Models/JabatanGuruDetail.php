<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JabatanGuruDetail extends Model
{
    use HasFactory;
    protected $table = "jabatan_guru_detail";
    protected $guarded = [];
    
    public $timestamps = false;
}
