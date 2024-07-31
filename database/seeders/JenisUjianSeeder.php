<?php

namespace Database\Seeders;

use App\Models\JenisUjian;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class JenisUjianSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'nama_jenis'    => 'Penilaian Harian',
                'kode_jenis'    => 'PH',
            ],
            [
                'nama_jenis'    => 'Penilaian Tengah Semester',
                'kode_jenis'    => 'PTS',
            ],
            [
                'nama_jenis'    => 'Penilaian Akhir Semester',
                'kode_jenis'    => 'PAS',
            ],
            [
                'nama_jenis'    => 'Penilaian Akhir Tahun',
                'kode_jenis'    => 'PAT',
            ],
            [
                'nama_jenis'    => 'Ujian Madrasah Berbasis Komputer',
                'kode_jenis'    => 'UMBK',
            ],
            [
                'nama_jenis'    => 'Try Out',
                'kode_jenis'    => 'TO',
            ],
            [
                'nama_jenis'    => 'Simulasi',
                'kode_jenis'    => 'SIML',
            ],
        ];

        JenisUjian::insert($data);
    }
}
