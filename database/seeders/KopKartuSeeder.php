<?php

namespace Database\Seeders;

use App\Models\KopKartu;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class KopKartuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'header_1' => 'KARTU PESERTA UBK',
                'header_2' => 'UJIAN TENGAH SEMESTER BERBASIS KOMPUTER',
                'header_3' => 'SMKN 5 JAKARTA',
                'header_4' => '',
                'tanggal' => '20 Juli 2024',
                'nomor_peserta' => '1',
                'nama_peserta' => '1',
                'nis_nisn' => '1',
                'ruang_sesi' => '1',
                'username' => '1',
                'password' => '1',
                'ukuran_ttd' => '3.5',
            ],
        ];

        KopKartu::insert($data);
    }
}
