<?php

namespace Database\Seeders;

use App\Models\ProfileSekolah;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProfileSekolahSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            'nama_aplikasi' => '',
            'nama_sekolah' => '',
            'nss_nsm' => '',
            'npsn' => '',
            'jenjang' => '',
            'satuan_pendidikan' => '',
            'alamat' => '',
            'desa_kelurahan' => '',
            'kecamatan' => '',
            'kabupaten_kota' => '',
            'kodepos' => '',
            'provinsi' => '',
            'faksimili' => '',
            'website' => '',
            'email' => '',
            'nomor_telepon' => '',
            'kepala_sekolah' => '',
            'nip' => '',
            'ttd' => '',
            'logo_aplikasi' => '',
            'logo_sekolah' => '',
        ];

        ProfileSekolah::insert($data);
    }
}
