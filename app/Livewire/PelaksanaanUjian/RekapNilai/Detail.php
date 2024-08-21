<?php

namespace App\Livewire\PelaksanaanUjian\RekapNilai;

use Carbon\Carbon;
use App\Models\Kelas;
use Livewire\Component;
use App\Models\BankSoal;
use App\Helpers\GlobalHelper;
use App\Models\NilaiSoalSiswa;
use App\Models\SoalSiswa;
use Livewire\Attributes\Title;
use Illuminate\Support\Facades\DB;

class Detail extends Component
{
    #[Title('Rekap Nilai Detail')]

    public $id_kelas, $data, $kelas, $nama_kelas, $detail, $tampilkan = '1';
    public $id_tp, $id_smt;
    public $id_jadwal;

    public function mount($id_jadwal)
    {
        $this->detail = collect();

        $this->id_tp    = GlobalHelper::getActiveTahunPelajaranId();
        $this->id_smt   = GlobalHelper::getActiveSemesterId();

        $this->id_jadwal = $id_jadwal;
        $this->id_kelas = "";

        $this->data = DB::table('bank_soal')->select(
            'jadwal.id',
            'jadwal.tgl_mulai',
            'jadwal.tgl_selesai',
            'bank_soal.id_kelas',
            'bank_soal.kode_bank',
            'jenis_ujian.kode_jenis',
            'mata_pelajaran.nama_mapel',
            'guru.nama_guru',
            'tahun_pelajaran.tahun',
            'semester.semester',
            'semester.nama_semester',
            DB::raw('(CASE WHEN MIN(nilai_soal_siswa.status) = 0 THEN 0 ELSE 1 END) as status_final')
        )
            ->join('jadwal', 'jadwal.id_bank', 'bank_soal.id')
            ->join('jenis_ujian', 'jenis_ujian.id', 'jadwal.id_jenis_ujian')
            ->join('mata_pelajaran', 'mata_pelajaran.id', 'bank_soal.id_mapel')
            ->join('nilai_soal_siswa', 'nilai_soal_siswa.id_jadwal', 'jadwal.id')
            ->join('guru', 'guru.id', 'bank_soal.id_guru')
            ->join('tahun_pelajaran', 'tahun_pelajaran.id', 'jadwal.id_tp')
            ->join('semester', 'semester.id', 'jadwal.id_smt')
            ->where('jadwal.id', $id_jadwal)->first();

        $idKelasArray = explode(',', $this->data->id_kelas);

        $this->kelas  = DB::table('kelas')
            ->select('kelas.id', 'kode_kelas', 'level')
            ->leftJoin('level', 'level.id', 'kelas.id_level')
            ->whereIn('kelas.id', $idKelasArray)
            ->where([
                ['id_tp', $this->id_tp],
            ])
            ->get()
            ->groupBy('level');

        $this->initSelect2();
    }

    public function initSelect2()
    {
        Carbon::setLocale('id');
        $this->dispatch('initSelect2');
    }

    public function render()
    {
        return view('livewire.pelaksanaan-ujian.rekap-nilai.detail');
    }

    public function updatedIdKelas()
    {
        $data            = Kelas::find($this->id_kelas);
        $this->nama_kelas = $data ? $data->nama_kelas : null;

        $this->detail = Kelas::select(
            'bank_soal.jml_pg',
            'kelas_detail.id_siswa',
            'nomor_peserta',
            'nama_siswa',
            'soal_siswa.jenis_soal',
            'soal_siswa.no_soal_alias',
            DB::raw('CASE WHEN soal_siswa.jenis_soal = 1 THEN soal_siswa.jawaban_siswa ELSE NULL END as jawaban_siswa'),
            DB::raw('CASE WHEN soal_siswa.jenis_soal = 1 THEN soal_siswa.jawaban_alias ELSE NULL END as jawaban_alias'),
            'soal_siswa.point_soal',

        )
            ->leftJoin('kelas_detail', 'kelas_detail.id_kelas', 'kelas.id')
            ->leftJoin('nilai_soal_siswa', 'nilai_soal_siswa.id_siswa', 'kelas_detail.id_siswa')
            ->leftJoin('bank_soal', 'bank_soal.id', 'nilai_soal_siswa.id_bank')
            ->leftJoin('soal_siswa', 'soal_siswa.id_nilai_soal', 'nilai_soal_siswa.id')
            ->leftJoin('siswa', 'siswa.id', 'kelas_detail.id_siswa')
            ->leftJoin('nomor_peserta', 'nomor_peserta.id_siswa', 'siswa.id')
            ->where('kelas.id', $this->id_kelas)
            // ->toSql();
            ->get()
            ->toArray();

        // dd($this->detail);

        $this->initSelect2();
    }

    public function tampil($status)
    {
        $this->tampilkan = $status;

        $this->initSelect2();
    }
}
