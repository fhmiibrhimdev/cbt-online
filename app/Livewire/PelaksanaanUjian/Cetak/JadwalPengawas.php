<?php

namespace App\Livewire\PelaksanaanUjian\Cetak;

use Carbon\Carbon;
use App\Models\Jadwal;
use Livewire\Component;
use App\Models\JenisUjian;
use App\Models\KopAbsensi;
use App\Helpers\GlobalHelper;
use App\Models\TahunPelajaran;
use Livewire\Attributes\Title;
use Illuminate\Support\Facades\DB;

class JadwalPengawas extends Component
{
    #[Title('Jadwal Pengawas')]

    public $header_1, $header_2, $header_3, $header_4, $tanggal, $start_date, $end_date, $ttd;
    public $ujians;
    public $id_jenises;
    public $id_jenis_ujian, $tgl_mulai, $tgl_akhir, $ttds;
    public $tahun_pelajaran, $nama_jenis, $data;
    public $id_tp, $id_smt;

    public function mount($id_jenis_ujian = "0", $tgl_mulai = "0", $tgl_akhir = "0", $ttds = "0")
    {
        $this->id_tp    = GlobalHelper::getActiveTahunPelajaranId();
        $this->id_smt   = GlobalHelper::getActiveSemesterId();

        $data = KopAbsensi::findOrFail('1');
        $this->header_1       = $data->header_1;
        $this->header_2       = $data->header_2;
        $this->header_3       = $data->header_3;
        $this->header_4       = $data->header_4;

        $this->id_jenis_ujian = $id_jenis_ujian;
        $this->tgl_mulai      = $tgl_mulai;
        $this->tgl_akhir      = $tgl_akhir;
        $this->ttds           = $ttds;

        $this->tahun_pelajaran = TahunPelajaran::select('tahun')->where('active', '1')->first()->tahun;

        if ($id_jenis_ujian == "0" && $tgl_mulai == "0" && $tgl_akhir == "0" && $ttds == "0") {
            $this->data = collect();
            $this->ujians = Jadwal::select('jenis_ujian.id', 'jenis_ujian.nama_jenis')
                ->join('jenis_ujian', 'jenis_ujian.id', 'jadwal.id_jenis_ujian')
                ->where('id_tp', $this->id_tp)
                ->distinct()
                ->get();

            $this->start_date = Carbon::now()->startOfMonth()->format('Y-m-d');
            $this->end_date = Carbon::now()->endOfMonth()->format('Y-m-d');
        } else {
            $this->initialData($this->id_jenis_ujian, $this->tgl_mulai, $this->tgl_akhir);
            $this->updatedIdJenises($this->id_jenis_ujian);
        }

        $this->initSelect2();
    }

    private function initSelect2()
    {
        $this->dispatch('initSelect2');
    }

    public function render()
    {
        \Carbon\Carbon::setLocale('id');

        if ($this->id_jenis_ujian == "0" && $this->tgl_mulai == "0" && $this->tgl_akhir == "0" && $this->ttds == "0") {
            return view('livewire.pelaksanaan-ujian.cetak.jadwal-pengawas');
        } else {
            return view('livewire.pelaksanaan-ujian.cetak.print.jadwal-pengawas')->layout('components.layouts.print');
        }
    }

    public function updated()
    {
        $this->ujians = Jadwal::select('jenis_ujian.id', 'jenis_ujian.nama_jenis')
            ->join('jenis_ujian', 'jenis_ujian.id', 'jadwal.id_jenis_ujian')
            ->where('id_tp', $this->id_tp)
            ->distinct()
            ->get();

        $this->initialData($this->id_jenises, $this->start_date, $this->end_date);
        $this->initSelect2();
    }

    public function updatedIdJenises($value)
    {
        $jenis            = JenisUjian::find($value);
        $this->nama_jenis = $jenis ? $jenis->nama_jenis : null;
    }

    private function initialData($id_jenis_ujian, $start_date, $end_date)
    {
        $this->data = Jadwal::select(
            'ruang.id as ruang_id',
            'jadwal.tgl_mulai',
            'ruang.nama_ruang',
            'sesi.nama_sesi',
            'mata_pelajaran.nama_mapel',
            'guru.nama_guru'
        )
            ->leftJoin('pengawas', 'pengawas.id_jadwal', '=', 'jadwal.id')
            ->leftJoin('bank_soal', 'bank_soal.id', '=', 'jadwal.id_bank')
            ->leftJoin('mata_pelajaran', 'mata_pelajaran.id', '=', 'bank_soal.id_mapel')
            ->leftJoin('ruang', 'ruang.id', '=', 'pengawas.id_ruang')
            ->leftJoin('sesi', 'sesi.id', '=', 'pengawas.id_sesi')
            ->leftJoin('guru', DB::raw('FIND_IN_SET(guru.id, pengawas.id_guru)'), '>', DB::raw('0'))
            ->when($start_date && $end_date, function ($query) use ($start_date, $end_date) {
                return $query->whereBetween('jadwal.tgl_mulai', [$start_date, $end_date]);
            })
            ->where([
                ['jadwal.id_jenis_ujian', $id_jenis_ujian],
                ['jadwal.id_tp', $this->id_tp],
            ])
            ->orderBy('bank_soal.id', 'asc')
            ->get();
    }
}
