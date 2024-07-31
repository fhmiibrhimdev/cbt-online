<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Siswa extends Model
{
    use HasFactory;

    protected $table = "siswa";
    protected $guarded = [];

    public function getCompletionPercentage()
    {
        $fields = [
            'nama_siswa', 'nis', 'nisn', 'jk', 'kelas', 'tahun_masuk', 'sekolah_asal', 'tempat_lahir', 'tgl_lahir', 'agama',
            'alamat', 'rt', 'rw', 'kelurahan_desa', 'kecamatan', 'kabupaten_kota', 'kode_pos', 'no_hp', 'status_keluarga', 'anak_ke', 'nama_ayah',
            'pekerjaan_ayah', 'alamat_ayah', 'nohp_ayah', 'nama_ibu', 'pekerjaan_ibu', 'alamat_ibu', 'nohp_ibu', 'nama_wali',
            'pekerjaan_wali', 'alamat_wali', 'nohp_wali'
        ];

        $filledFields = 0;
        foreach ($fields as $field) {
            if ($this->$field) {
                $filledFields++;
            }
        }

        $percentage = ($filledFields / count($fields)) * 100;

        return round($percentage, 1);
    }
}
