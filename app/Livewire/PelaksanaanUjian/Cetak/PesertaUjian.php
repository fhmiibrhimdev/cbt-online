<?php

namespace App\Livewire\PelaksanaanUjian\Cetak;

use App\Models\Sesi;
use Livewire\Component;
use App\Models\SesiSiswa;
use App\Models\JenisUjian;
use App\Models\KopAbsensi;
use App\Helpers\GlobalHelper;
use App\Models\TahunPelajaran;
use Livewire\Attributes\Title;

class PesertaUjian extends Component
{
    #[Title('Peserta Ujian')]
    public $header_1, $header_2, $header_3, $header_4, $tahun_pelajaran;
    public $ujians, $sesis, $data;
    public $jenis_ujian, $byes = 'ruang';
    public $id_jenises = '1', $id_jenis, $by;
    public $id_tp, $id_smt;

    public function mount($id_jenis_ujian = "", $by = "")
    {
        $this->id_tp    = GlobalHelper::getActiveTahunPelajaranId();
        $this->id_smt   = GlobalHelper::getActiveSemesterId();

        $data = KopAbsensi::findOrFail('1');
        $this->header_1 = $data->header_1;
        $this->header_2 = $data->header_2;
        $this->header_3 = $data->header_3;
        $this->header_4 = $data->header_4;

        $this->tahun_pelajaran = TahunPelajaran::select('tahun')->where('active', '1')->first()->tahun;

        $this->id_jenis = $id_jenis_ujian;
        $this->by       = $by;

        if ($id_jenis_ujian == "" && $by == "") {
            $this->ujians = JenisUjian::get();

            $this->updatedIdJenises($this->id_jenises);
            $this->initSelect2();
        } else {
            $this->updatedIdJenises($id_jenis_ujian);
        }
        $this->sesis = Sesi::get();
        $this->initialData();
    }

    public function render()
    {
        if ($this->id_jenis == "" && $this->by == "") {
            return view('livewire.pelaksanaan-ujian.cetak.peserta-ujian');
        } else {
            return view('livewire.pelaksanaan-ujian.cetak.print.peserta-ujian')->layout('components.layouts.print');
        }
    }

    private function initialData()
    {
        $this->data = SesiSiswa::select(
            'nomor_peserta.nomor_peserta',
            'ruang.nama_ruang',
            'sesi.nama_sesi',
            'sesi.waktu_mulai',
            'sesi.waktu_akhir',
            'kelas.nama_kelas',
            'siswa.nama_siswa'
        )
            ->join('ruang', 'ruang.id', '=', 'sesi_siswa.id_ruang')
            ->join('sesi', 'sesi.id', '=', 'sesi_siswa.id_sesi')
            ->join('siswa', 'siswa.id', '=', 'sesi_siswa.id_siswa')
            ->join('kelas', 'kelas.id', '=', 'sesi_siswa.id_kelas')
            ->join('nomor_peserta', 'nomor_peserta.id_siswa', '=', 'siswa.id')
            ->where('sesi_siswa.id_tp', $this->id_tp)
            ->orderBy('nama_ruang', 'ASC')
            ->orderBy('nama_sesi', 'ASC')
            ->orderBy('nomor_peserta', 'ASC')
            ->get();
    }

    private function initSelect2()
    {
        $this->dispatch('initSelect2');
    }

    public function updated()
    {
        $this->initialData();
        $this->dispatch('initSelect2');
    }

    public function updatedIdJenises($value)
    {
        $jenis             = JenisUjian::find($value);
        $nama_jenis        = $jenis ? $jenis->nama_jenis : null;
        $kode_jenis        = $jenis ? $jenis->kode_jenis : null;
        $this->jenis_ujian = $nama_jenis . " ($kode_jenis)";
    }

    public function byMode($by)
    {
        $this->byes = $by;
        $this->updated();
    }
}
