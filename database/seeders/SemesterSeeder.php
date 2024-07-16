<?php

namespace Database\Seeders;

use App\Models\Semester;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class SemesterSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'semester'            => 'Ganjil',
                'nama_semester'       => 'I (satu)',
                'active'              => '1',
            ],

            [
                'semester'            => 'Genap',
                'nama_semester'       => 'II (dua)',
                'active'              => '0',
            ],
        ];

        Semester::insert($data);
    }
}