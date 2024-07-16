<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class BankSoal extends Model
{
    use HasFactory;
    protected $table = "bank_soal";
    protected $guarded = [];

    public function getKelas()
    {
        $kelasIds = explode(',', $this->id_kelas);
        return Kelas::select('kode_kelas')->whereIn('id', $kelasIds)->get();
    }
}