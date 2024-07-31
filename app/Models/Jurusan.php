<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Jurusan extends Model
{
    use HasFactory;
    protected $table = "jurusan";
    protected $guarded = [];
    
    public $timestamps = false;

    public function getMataPelajaran()
    {
        $mapelIds = explode(',', $this->mapel_peminatan);
        return MataPelajaran::whereIn('id', $mapelIds)->get();
    }
}
