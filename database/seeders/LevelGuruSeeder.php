<?php

namespace Database\Seeders;

use App\Models\LevelGuru;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LevelGuruSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            ['level' => 'Kepala Sekolah'],
            ['level' => 'Wakil Kepala Sekolah'],
            ['level' => 'Bimbingan Konseling'],
            ['level' => 'Walikelas'],
            ['level' => 'Guru'],
        ];

        LevelGuru::insert($data);
    }
}
