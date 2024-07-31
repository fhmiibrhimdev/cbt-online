<?php

namespace Database\Seeders;

use App\Models\Jurusan;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class JurusanSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'kode_jurusan'      => 'TEDK',
                'nama_jurusan'      => 'Teknik Elektronika Daya dan Komunikasi',
                'mapel_peminatan'   => '',
                'status'            => '1',
            ],
            [
                'kode_jurusan'      => 'TAV',
                'nama_jurusan'      => 'Teknik Audio Video',
                'mapel_peminatan'   => '',
                'status'            => '1',
            ],
            [
                'kode_jurusan'      => 'TKR',
                'nama_jurusan'      => 'Teknik Kendaraan Ringan',
                'mapel_peminatan'   => '',
                'status'            => '1',
            ],
            [
                'kode_jurusan'      => 'TMPO',
                'nama_jurusan'      => 'Teknik Manajemen Perawatan Otomotif',
                'mapel_peminatan'   => '',
                'status'            => '1',
            ],
        ];

        Jurusan::insert($data);
    }
}