<?php

namespace Database\Seeders;

use App\Models\TahunPelajaran;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class TahunPelajaranSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'tahun'               => '2021/2022',
                'active'              => '0',
            ],

            [
                'tahun'               => '2022/2023',
                'active'              => '0',
            ],

            [
                'tahun'               => '2023/2024',
                'active'              => '1',
            ],

            [
                'tahun'               => '2024/2025',
                'active'              => '0',
            ],
        ];

        TahunPelajaran::insert($data);
    }
}