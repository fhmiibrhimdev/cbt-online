<?php

namespace App\Livewire\Siswa;

use App\Models\Siswa;
use App\Models\Jadwal;
use App\Models\Token;
use Livewire\Component;
use Livewire\Attributes\Title;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;

class Ujian extends Component
{
    #[Title('Ujian')]
    public $jadwals = [];
    public $siswa, $id_siswa;

    public function mount()
    {
        $this->id_siswa = Siswa::where('id_user', Auth::user()->id)->first()->id;

        $this->siswa = Siswa::select('nomor_peserta', 'nama_ruang', 'nama_sesi', 'waktu_mulai', 'waktu_akhir')
            ->leftJoin('sesi_siswa', 'sesi_siswa.id_siswa', 'siswa.id')
            ->leftJoin('ruang', 'ruang.id', 'sesi_siswa.id_ruang')
            ->leftJoin('sesi', 'sesi.id', 'sesi_siswa.id_sesi')
            ->leftJoin('nomor_peserta', 'nomor_peserta.id_siswa', 'siswa.id')
            ->where('id_user', Auth::user()->id)->first();

        $this->jadwals = Jadwal::select(
            'jadwal.id',
            'tgl_mulai',
            'tgl_selesai',
            'durasi_ujian',
            'jadwal.status',
            'nama_mapel',
            'nama_jenis',
            'nilai_soal_siswa.status as status_ujian',
            DB::raw("(bank_soal.jml_pg + bank_soal.jml_esai + bank_soal.jml_kompleks + bank_soal.jml_jodohkan + bank_soal.jml_isian) as total_soal"),
        )
            ->leftJoin('bank_soal', 'bank_soal.id', 'jadwal.id_bank')
            ->leftJoin('mata_pelajaran', 'mata_pelajaran.id', 'bank_soal.id_mapel')
            ->leftJoin('jenis_ujian', 'jenis_ujian.id', 'jadwal.id_jenis_ujian')
            ->leftJoin('nilai_soal_siswa', function ($join) {
                $join->on('nilai_soal_siswa.id_jadwal', '=', 'jadwal.id')
                    ->where('nilai_soal_siswa.id_siswa', '=', $this->id_siswa);
            })
            ->leftJoin('kelas', DB::raw('FIND_IN_SET(kelas.id, bank_soal.id_kelas)'), '>', DB::raw('0'))
            ->leftJoin('siswa', 'siswa.id_kelas', 'kelas.id')
            ->where([
                ['siswa.id_user', Auth::user()->id],
                ['jadwal.status', '1'],
            ])
            ->get();

        // dd($this->jadwals);
    }

    public function render()
    {
        return view('livewire.siswa.ujian');
    }
}
