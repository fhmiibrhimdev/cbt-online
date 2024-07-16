<?php

namespace App\Livewire\Ujian;

use App\Models\Kelas;
use App\Models\Siswa;
use Livewire\Component;
use App\Models\Semester;
use App\Models\TahunPelajaran;
use Livewire\Attributes\Title;
use App\Models\NomorPeserta as ModelsNomorPeserta;

class NomorPeserta extends Component
{
    #[Title('Nomor Peserta')]
    
    public $id_kelas, $nomor_peserta = [];
    public $kelass, $siswas;

    public function mount()
    {
        $this->siswas = [];
        $this->kelass = Kelas::select('id', 'kode_kelas')->get();

        $this->dispatch('initSelect2');
    }
    
    public function updatedIdKelas()
    {
        $this->updateSiswa();
        
        $this->nomor_peserta = [];
        $this->dispatch('initSelect2');
    }

    public function updateSiswa()
    {
        $this->siswas = Siswa::select('siswa.id', 'nama_siswa', 'users.email', 'kelas.kode_kelas', 'nomor_peserta.nomor_peserta')
                        ->join('users', 'users.id', 'siswa.id_user')
                        ->join('kelas', 'kelas.id', 'siswa.id_kelas')
                        ->leftJoin('nomor_peserta', 'nomor_peserta.id_siswa', 'siswa.id')
                        ->whereIn('id_kelas', $this->id_kelas)
                        ->get();
    }
    
    public function generateNomorPeserta()
    {
        $this->updateSiswa();

        $tahun = now()->year;
        $prefix = "$tahun-10-";
        $counter = 1;

        foreach ($this->siswas as $siswa) {
            $nomor_peserta = $prefix . str_pad($counter++, 4, '0', STR_PAD_LEFT);
            $siswa->nomor_peserta = $nomor_peserta;
            $this->nomor_peserta[$siswa->id] = $nomor_peserta;
        }
    }

    public function hapusNomorPeserta()
    {
        $this->siswas = Siswa::select('siswa.id', 'nama_siswa', 'users.email', 'kelas.kode_kelas', 'nomor_peserta.nomor_peserta')
                            ->join('users', 'users.id', 'siswa.id_user')
                            ->join('kelas', 'kelas.id', 'siswa.id_kelas')
                            ->leftJoin('nomor_peserta', 'nomor_peserta.id_siswa', 'siswa.id')
                            ->whereIn('id_kelas', $this->id_kelas)
                            ->get();

        foreach ($this->siswas as $siswa) {
            $siswa->nomor_peserta = '';
        }

        $this->nomor_peserta = [];
    }

    public function render()
    {
        return view('livewire.ujian.nomor-peserta');
    }

    public function store()
    {
        $id_tp = TahunPelajaran::where('active', '1')->first()->id;
        $id_smt = Semester::where('active', '1')->first()->id;

        foreach ($this->nomor_peserta as $id_siswa => $nomorPeserta) {
            ModelsNomorPeserta::updateOrCreate(
                ['id_siswa' => $id_siswa],
                [
                    'id_tp' => $id_tp,
                    'id_smt' => $id_smt,
                    'nomor_peserta' => $nomorPeserta
                ]
            );
        }

        $this->dispatchAlert('success', 'Success!', 'Data created successfully.');
    }

    private function dispatchAlert($type, $message, $text)
    {
        $this->dispatch('swal:modal', [
            'type'      => $type,  
            'message'   => $message, 
            'text'      => $text
        ]);

        $this->updateSiswa();
    }
}
