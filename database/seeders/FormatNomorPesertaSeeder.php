<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class FormatNomorPesertaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'kode_jenjang' => '0',
                'kode_tahun' => substr(Carbon::now()->year, -2),
                'kode_provinsi' => '0',
                'kode_kota' => '0',
                'kode_sekolah' => '0',
            ],
        ];

        DB::table('format_nomor_peserta')->insert($data);
    }
}
