<?php

namespace Database\Seeders;

use App\Models\KelompokMapel;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class KelompokMapelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'kategori'      => 'WAJIB',
                'kode_kelompok' => 'A',
                'nama_kelompok' => 'Kelompok A (Wajib)',
                'id_parent'     => '0',
            ],
            [
                'kategori'      => 'WAJIB',
                'kode_kelompok' => 'B',
                'nama_kelompok' => 'Kelompok B',
                'id_parent'     => '0',
            ],
            [
                'kategori'      => 'PEMINATAN',
                'kode_kelompok' => 'C',
                'nama_kelompok' => 'Kelompok C',
                'id_parent'     => '0',
            ],
            [
                'kategori'      => 'MULOK',
                'kode_kelompok' => 'MULOK',
                'nama_kelompok' => 'Muatan Lokal',
                'id_parent'     => '0',
            ],
            [
                'kategori'      => 'PAI (Kemenag)',
                'kode_kelompok' => 'PAI',
                'nama_kelompok' => 'PAI',
                'id_parent'     => '0',
            ],
            [
                'kategori'      => 'PEMINATAN',
                'kode_kelompok' => 'C1',
                'nama_kelompok' => 'Kelompok C1',
                'id_parent'     => '3',
            ],
        ];

        KelompokMapel::insert($data);
    }
}
