<?php

namespace Database\Seeders;

use App\Models\Sesi;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SesiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'nama_sesi'     => 'Sesi 1',
                'kode_sesi'     => 'S1',
                'waktu_mulai'   => '07:30',
                'waktu_akhir'   => '09:00',
                'active'        => '1',
            ],
            [
                'nama_sesi'     => 'Sesi 2',
                'kode_sesi'     => 'S2',
                'waktu_mulai'   => '09:00',
                'waktu_akhir'   => '10:30',
                'active'        => '1',
            ],
            [
                'nama_sesi'     => 'Sesi 3',
                'kode_sesi'     => 'S3',
                'waktu_mulai'   => '10:30',
                'waktu_akhir'   => '12:00',
                'active'        => '1',
            ],
            [
                'nama_sesi'     => 'Sesi 4',
                'kode_sesi'     => 'S4',
                'waktu_mulai'   => '00:00',
                'waktu_akhir'   => '23:59',
                'active'        => '1',
            ],
        ];

        Sesi::insert($data);
    }
}
