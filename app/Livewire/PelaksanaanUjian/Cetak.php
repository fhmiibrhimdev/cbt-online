<?php

namespace App\Livewire\PelaksanaanUjian;

use App\Models\Kelas;
use App\Models\KopKartu;
use App\Models\Siswa;
use Livewire\Attributes\Title;
use Livewire\Component;

class Cetak extends Component
{
    #[Title('Cetak')]

    public function render()
    {
        return view('livewire.pelaksanaan-ujian.cetak.cetak');
    }
}
