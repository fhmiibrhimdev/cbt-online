<?php

namespace App\Livewire\Pengaturan;

use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Title;
use App\Models\RaportAdminSetting;

class Raport extends Component
{
    use WithPagination;
    #[Title('Raport Admin Settings')]

    public $kkm_tunggal = '0', $tgl_raport_pts, $tgl_raport_akhir, $tgl_raport_kelas_akhir, $nip_kepsek = '0', $nip_walikelas = '0';
    public $kkm         = '0', $bobot_ph = '0', $bobot_pts = '0', $bobot_pas = '0';

    public function mount()
    {
        $data                         = RaportAdminSetting::first();
        $this->kkm_tunggal            = $data->kkm_tunggal;
        $this->tgl_raport_pts         = $data->tgl_raport_pts;
        $this->tgl_raport_akhir       = $data->tgl_raport_akhir;
        $this->tgl_raport_kelas_akhir = $data->tgl_raport_kelas_akhir;
        $this->nip_kepsek             = $data->nip_kepsek;
        $this->nip_walikelas          = $data->nip_walikelas;
        $this->kkm                    = $data->kkm;
        $this->bobot_ph               = $data->bobot_ph;
        $this->bobot_pts              = $data->bobot_pts;
        $this->bobot_pas              = $data->bobot_pas;
    }

    public function render()
    {
        return view('livewire.pengaturan.raport');
    }

    private function dispatchAlert($type, $message, $text)
    {
        $this->dispatch('swal:modal', [
            'type'      => $type,
            'message'   => $message,
            'text'      => $text
        ]);
    }

    public function update()
    {
        RaportAdminSetting::first()->update([
            'kkm_tunggal'            => $this->kkm_tunggal,
            'tgl_raport_pts'         => $this->tgl_raport_pts,
            'tgl_raport_akhir'       => $this->tgl_raport_akhir,
            'tgl_raport_kelas_akhir' => $this->tgl_raport_kelas_akhir,
            'nip_kepsek'             => $this->nip_kepsek,
            'nip_walikelas'          => $this->nip_walikelas,
            'kkm'                    => $this->kkm,
            'bobot_ph'               => $this->bobot_ph,
            'bobot_pts'              => $this->bobot_pts,
            'bobot_pas'              => $this->bobot_pas,
        ]);

        $this->dispatchAlert('success', 'Success!', 'Data updated successfully.');
    }
}
