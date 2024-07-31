<?php

namespace Database\Seeders;

use App\Models\KopAbsensi;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class KopAbsensiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'header_1' => 'DAFTAR HADIR PESERTA',
                'header_2' => 'UJIAN TENGAH SEMESTER BERBASIS KOMPUTER',
                'header_3' => 'SMKN 5 JAKARTA',
                'header_4' => '',
            ],
        ];

        KopAbsensi::insert($data);
    }
}
