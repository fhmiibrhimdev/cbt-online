<?php

namespace Database\Seeders;

use App\Models\Ruang;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RuangSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'nama_ruang'    => 'Ruang 1',
                'kode_ruang'    => 'LAB-KOM',
            ],
            [
                'nama_ruang'    => 'Ruang 2',
                'kode_ruang'    => 'R2',
            ],
            [
                'nama_ruang'    => 'Ruang 3',
                'kode_ruang'    => 'R3',
            ],
            [
                'nama_ruang'    => 'Ruang 4',
                'kode_ruang'    => 'R4',
            ],
            [
                'nama_ruang'    => 'Ruang 5',
                'kode_ruang'    => 'R5',
            ],
        ];

        Ruang::insert($data);
    }
}
