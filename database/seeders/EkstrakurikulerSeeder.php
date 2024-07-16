<?php

namespace Database\Seeders;

use App\Models\Ekstrakurikuler;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class EkstrakurikulerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'nama_ekstra'   => 'Pramuka',
                'kode_ekstra'   => 'PRAM',
            ],
            [
                'nama_ekstra'   => 'Baca Tulis Al Quran',
                'kode_ekstra'   => 'BTQ',
            ],
            [
                'nama_ekstra'   => 'Tahfidz',
                'kode_ekstra'   => 'TFZ',
            ],
        ];

        Ekstrakurikuler::insert($data);
    }
}
