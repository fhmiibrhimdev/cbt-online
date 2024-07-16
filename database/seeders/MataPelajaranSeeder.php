<?php

namespace Database\Seeders;

use App\Models\MataPelajaran;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class MataPelajaranSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'id_kelompok'   => '1',
                'nama_mapel'    => 'Pendidikan Pancasila dan Kewarganegaraan',
                'kode_mapel'    => 'PPKn',
                'status'        => '1',
                'no_urut'       => '1',
            ],
            [
                'id_kelompok'   => '1',
                'nama_mapel'    => 'Pendidikan Agama dan Budi Pekerti',
                'kode_mapel'    => 'PABP',
                'status'        => '1',
                'no_urut'       => '2',
            ],
            [
                'id_kelompok'   => '1',
                'nama_mapel'    => 'Bahasa Indonesia',
                'kode_mapel'    => 'BIND',
                'status'        => '1',
                'no_urut'       => '3',
            ],
            [
                'id_kelompok'   => '1',
                'nama_mapel'    => 'Bahasa Arab',
                'kode_mapel'    => 'BAR',
                'status'        => '1',
                'no_urut'       => '4',
            ],
            [
                'id_kelompok'   => '1',
                'nama_mapel'    => 'Matematika',
                'kode_mapel'    => 'MTK',
                'status'        => '1',
                'no_urut'       => '5',
            ],
            [
                'id_kelompok'   => '1',
                'nama_mapel'    => 'Sejarah Indonesia',
                'kode_mapel'    => 'SJI',
                'status'        => '1',
                'no_urut'       => '6',
            ],
            [
                'id_kelompok'   => '1',
                'nama_mapel'    => 'Ilmu Pengetahuan Alam',
                'kode_mapel'    => 'IPA',
                'status'        => '1',
                'no_urut'       => '7',
            ],
            [
                'id_kelompok'   => '1',
                'nama_mapel'    => 'Ilmu Pengetahuan Sosial',
                'kode_mapel'    => 'IPS',
                'status'        => '1',
                'no_urut'       => '8',
            ],
            [
                'id_kelompok'   => '1',
                'nama_mapel'    => 'Bahasa Inggris',
                'kode_mapel'    => 'BING',
                'status'        => '1',
                'no_urut'       => '9',
            ],

            [
                'id_kelompok'   => '2',
                'nama_mapel'    => 'Seni Budaya',
                'kode_mapel'    => 'SB',
                'status'        => '1',
                'no_urut'       => '1',
            ],
            [
                'id_kelompok'   => '2',
                'nama_mapel'    => 'SBdP',
                'kode_mapel'    => 'SBDP',
                'status'        => '0',
                'no_urut'       => '1',
            ],
            [
                'id_kelompok'   => '2',
                'nama_mapel'    => 'Pendidikan Jasmani Olah Raga dan Kesehatan',
                'kode_mapel'    => 'PJOK',
                'status'        => '1',
                'no_urut'       => '2',
            ],
            [
                'id_kelompok'   => '2',
                'nama_mapel'    => 'Prakarya dan Kewirausahaan',
                'kode_mapel'    => 'PK',
                'status'        => '0',
                'no_urut'       => '3',
            ],
            [
                'id_kelompok'   => '2',
                'nama_mapel'    => 'Prakarya',
                'kode_mapel'    => 'PRA',
                'status'        => '1',
                'no_urut'       => '3',
            ],

            [
                'id_kelompok'   => '3',
                'nama_mapel'    => 'Matematika (Peminatan)',
                'kode_mapel'    => 'MTK-P',
                'status'        => '1',
                'no_urut'       => '1',
            ],
            [
                'id_kelompok'   => '3',
                'nama_mapel'    => 'Biologi',
                'kode_mapel'    => 'BIO',
                'status'        => '1',
                'no_urut'       => '2',
            ],
            [
                'id_kelompok'   => '3',
                'nama_mapel'    => 'Bahasa Arab (Peminatan)',
                'kode_mapel'    => 'BAR-P',
                'status'        => '1',
                'no_urut'       => '3',
            ],
            [
                'id_kelompok'   => '3',
                'nama_mapel'    => 'Fikih (Peminatan)',
                'kode_mapel'    => 'FQH-P',
                'status'        => '1',
                'no_urut'       => '4',
            ],
            [
                'id_kelompok'   => '3',
                'nama_mapel'    => 'Fikih - Ushul Fikih',
                'kode_mapel'    => 'UFQH',
                'status'        => '1',
                'no_urut'       => '5',
            ],
            [
                'id_kelompok'   => '3',
                'nama_mapel'    => 'Hadis - Ilmu Hadis',
                'kode_mapel'    => 'HA',
                'status'        => '1',
                'no_urut'       => '6',
            ],
            [
                'id_kelompok'   => '3',
                'nama_mapel'    => 'Ilmu Kalam',
                'kode_mapel'    => 'IK',
                'status'        => '1',
                'no_urut'       => '7',
            ],
            [
                'id_kelompok'   => '3',
                'nama_mapel'    => 'Sejarah',
                'kode_mapel'    => 'SEJ',
                'status'        => '1',
                'no_urut'       => '8',
            ],
            [
                'id_kelompok'   => '3',
                'nama_mapel'    => 'Sosiologi',
                'kode_mapel'    => 'SOS',
                'status'        => '1',
                'no_urut'       => '9',
            ],
            [
                'id_kelompok'   => '3',
                'nama_mapel'    => 'Geografi',
                'kode_mapel'    => 'GEO',
                'status'        => '1',
                'no_urut'       => '10',
            ],
            [
                'id_kelompok'   => '3',
                'nama_mapel'    => 'Ekonomi',
                'kode_mapel'    => 'EKN',
                'status'        => '1',
                'no_urut'       => '11',
            ],
            [
                'id_kelompok'   => '3',
                'nama_mapel'    => 'Bahasa Jerman',
                'kode_mapel'    => 'JRM',
                'status'        => '1',
                'no_urut'       => '12',
            ],
            [
                'id_kelompok'   => '3',
                'nama_mapel'    => 'Informatika',
                'kode_mapel'    => 'INF',
                'status'        => '0',
                'no_urut'       => '13',
            ],
            [
                'id_kelompok'   => '3',
                'nama_mapel'    => 'Bahasa dan Sastra Inggris',
                'kode_mapel'    => 'BSING',
                'status'        => '1',
                'no_urut'       => '14',
            ],
            [
                'id_kelompok'   => '3',
                'nama_mapel'    => 'Bahasa dan Sastra Indonesia',
                'kode_mapel'    => 'BSIN',
                'status'        => '1',
                'no_urut'       => '15',
            ],
            [
                'id_kelompok'   => '3',
                'nama_mapel'    => 'Bahasa dan Sastra Asing Lainnya',
                'kode_mapel'    => 'BSAL',
                'status'        => '1',
                'no_urut'       => '16',
            ],
            [
                'id_kelompok'   => '3',
                'nama_mapel'    => 'Keterampilan',
                'kode_mapel'    => 'KTR',
                'status'        => '0',
                'no_urut'       => '17',
            ],
            [
                'id_kelompok'   => '3',
                'nama_mapel'    => 'Bahasa Jepang',
                'kode_mapel'    => 'JPN',
                'status'        => '1',
                'no_urut'       => '18',
            ],
            [
                'id_kelompok'   => '3',
                'nama_mapel'    => 'Akhlak',
                'kode_mapel'    => 'AK',
                'status'        => '0',
                'no_urut'       => '19',
            ],
            
            [
                'id_kelompok'   => '4',
                'nama_mapel'    => 'Bahasa Sunda',
                'kode_mapel'    => 'BSUND',
                'status'        => '1',
                'no_urut'       => '1',
            ],

            [
                'id_kelompok'   => '5',
                'nama_mapel'    => 'Al Quran-Hadis',
                'kode_mapel'    => 'QH',
                'status'        => '1',
                'no_urut'       => '1',
            ],
            [
                'id_kelompok'   => '5',
                'nama_mapel'    => 'Akidah Akhlak',
                'kode_mapel'    => 'AA',
                'status'        => '1',
                'no_urut'       => '2',
            ],
            [
                'id_kelompok'   => '5',
                'nama_mapel'    => 'Fiqih',
                'kode_mapel'    => 'FQH',
                'status'        => '1',
                'no_urut'       => '3',
            ],
            [
                'id_kelompok'   => '5',
                'nama_mapel'    => 'Sejarah Kebudayaan Islam',
                'kode_mapel'    => 'SKI',
                'status'        => '1',
                'no_urut'       => '4',
            ],

            [
                'id_kelompok'   => '6',
                'nama_mapel'    => 'Tafsir - Ilmu Tafsir',
                'kode_mapel'    => 'TT',
                'status'        => '1',
                'no_urut'       => '1',
            ],
            [
                'id_kelompok'   => '6',
                'nama_mapel'    => 'Kimia',
                'kode_mapel'    => 'KIM',
                'status'        => '1',
                'no_urut'       => '2',
            ],
            [
                'id_kelompok'   => '6',
                'nama_mapel'    => 'Fisika',
                'kode_mapel'    => 'FIS',
                'status'        => '1',
                'no_urut'       => '3',
            ],
            [
                'id_kelompok'   => '6',
                'nama_mapel'    => 'Antropologi',
                'kode_mapel'    => 'ANT',
                'status'        => '1',
                'no_urut'       => '4',
            ],
        ];

        MataPelajaran::insert($data);
    }
}
