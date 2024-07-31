<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Jadwal extends Model
{
    use HasFactory;

    protected $table = "jadwal";
    protected $guarded = [];

    public function getKelas()
    {
        $kelasIds = explode(',', $this->id_kelas);
        return Kelas::select('kode_kelas', 'level')->leftJoin('level', 'level.id', 'kelas.id_level')->whereIn('kelas.id', $kelasIds)->get();
    }
}
