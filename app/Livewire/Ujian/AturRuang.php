<?php

namespace App\Livewire\Ujian;

use App\Models\Sesi;
use App\Models\Kelas;
use App\Models\Ruang;
use Livewire\Component;
use App\Models\Semester;
use App\Models\SesiSiswa;
use App\Models\TahunPelajaran;
use Livewire\Attributes\Title;

class AturRuang extends Component
{
    #[Title('Atur Ruang')]

    public $data     = [];
    public $id_kelas;
    public $id_ruang = '0';
    public $id_sesi  = '0';
    public $siswas, $ruangs, $sesis;

    public function mount($id_kelas = "")
    {
        $this->id_kelas = $id_kelas;
        $this->ruangs   = Ruang::select('id', 'kode_ruang')->get();
        $this->sesis    = Sesi::select('id', 'nama_sesi')->get();

        if ($id_kelas == "") {
            $this->siswas = [];
        } else {
            $this->siswas = Kelas::select('siswa.id', 'kelas.kode_kelas', 'siswa.nama_siswa', 'sesi_siswa.id_ruang', 'sesi_siswa.id_sesi', 'level')
                ->join('kelas_detail', 'kelas_detail.id_kelas', 'kelas.id')
                ->leftJoin('siswa', 'siswa.id', 'kelas_detail.id_siswa')
                ->leftJoin('sesi_siswa', 'sesi_siswa.id_siswa', 'siswa.id')
                ->leftJoin('level', 'level.id', 'kelas.id_level')
                ->where('kelas.id', $this->id_kelas)
                ->distinct()
                ->get();

            foreach ($this->siswas as $siswa) {
                $this->data[$siswa->id] = [
                    'id_ruang' => $siswa->id_ruang ?: '0',
                    'id_sesi'  => $siswa->id_sesi ?: '0',
                ];
            }

            // dd($this->siswas);
        }
        $this->dispatch('initSelect2');
    }

    public function updatedData()
    {
        if ($this->id_kelas == "") {
            $this->siswas = [];
        } else {
            $this->siswas = Kelas::select('siswa.id', 'kelas.kode_kelas', 'siswa.nama_siswa', 'sesi_siswa.id_ruang', 'sesi_siswa.id_sesi', 'level')
                ->join('kelas_detail', 'kelas_detail.id_kelas', 'kelas.id')
                ->leftJoin('siswa', 'siswa.id', 'kelas_detail.id_siswa')
                ->leftJoin('sesi_siswa', 'sesi_siswa.id_siswa', 'siswa.id')
                ->leftJoin('level', 'level.id', 'kelas.id_level')
                ->where('kelas.id', $this->id_kelas)
                ->distinct()
                ->get();
        }

        // dd($this->siswas);

        $this->dispatch('initSelect2');
    }

    public function updatedIdRuang()
    {
        foreach ($this->data as $key => $value) {
            $this->data[$key]['id_ruang'] = $this->id_ruang;
        }

        $this->updatedData();
    }

    public function updatedIdSesi()
    {
        foreach ($this->data as $key => $value) {
            $this->data[$key]['id_sesi'] = $this->id_sesi;
        }
        $this->updatedData();
    }

    public function render()
    {
        $kelass  = Kelas::select('kelas.id', 'kode_kelas', 'level')->leftJoin('level', 'level.id', 'kelas.id_level')->get();

        return view('livewire.ujian.atur-ruang', compact('kelass'));
    }

    public function store()
    {
        $this->updatedData();

        $id_tp  = TahunPelajaran::where('active', '1')->first()->id;
        $id_smt = Semester::where('active', '1')->first()->id;

        SesiSiswa::where('id_kelas', $this->id_kelas)->delete();

        $siswas = [];

        foreach ($this->siswas as $siswa) {
            $siswas[] = $siswa->id;
            SesiSiswa::create([
                'id_kelas' => $this->id_kelas,
                'id_siswa' => $siswa->id,
                'id_ruang' => $this->data[$siswa->id]['id_ruang'],
                'id_sesi'  => $this->data[$siswa->id]['id_sesi'],
                'id_tp'    => $id_tp,
                'id_smt'   => $id_smt,
            ]);
        }
        // dd($siswas);

        $this->dispatchAlert('success', 'Success!', 'Data updated successfully.');
    }

    private function dispatchAlert($type, $message, $text)
    {
        $this->dispatch('swal:modal', [
            'type'    => $type,
            'message' => $message,
            'text'    => $text
        ]);

        $this->updatedData();
    }
}
