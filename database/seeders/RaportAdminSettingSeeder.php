<?php

namespace Database\Seeders;

use App\Models\Semester;
use App\Models\TahunPelajaran;
use Illuminate\Database\Seeder;
use App\Livewire\Pengaturan\Raport;
use App\Models\RaportAdminSetting;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class RaportAdminSettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $id_tp      = TahunPelajaran::where('active', '1')->first()->id;
        $id_smt     = Semester::where('active', '1')->first()->id;

        $data = [
            [
                'id_tp' => $id_tp,
                'id_smt' => $id_smt,
                'kkm_tunggal' => '0',
                'kkm' => '0',
                'bobot_ph' => '0',
                'bobot_pts' => '0',
                'bobot_pas' => '0',
                'bobot_absen' => '',
                'tgl_raport_akhir' => date('Y-m-d'),
                'tgl_raport_kelas_akhir' => date('Y-m-d'),
                'tgl_raport_pts' => date('Y-m-d'),
                'nip_kepsek' => '0',
                'nip_walikelas' => '0',
            ]
        ];

        RaportAdminSetting::insert($data);
    }
}
