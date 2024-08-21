<?php

namespace App\Livewire\PelaksanaanUjian;

use Carbon\Carbon;
use App\Models\Jadwal;
use Livewire\Component;
use App\Models\BankSoal;
use App\Models\SoalSiswa;
use Livewire\WithPagination;
use App\Models\NilaiSoalSiswa;
use Livewire\Attributes\Title;
use Illuminate\Support\Facades\DB;

class RekapNilai extends Component
{
    use WithPagination;
    #[Title('Rekap Nilai')]

    protected $listeners = [
        'delete'
    ];

    public $lengthData = 25;
    public $searchTerm;
    public $previousSearchTerm = '';
    public $isEditing = false;

    public $dataId, $title;

    public function updatingLengthData()
    {
        $this->resetPage();
    }

    private function searchResetPage()
    {
        if ($this->searchTerm !== $this->previousSearchTerm) {
            $this->resetPage();
        }

        $this->previousSearchTerm = $this->searchTerm;
    }

    public function render()
    {
        Carbon::setLocale('id');

        $this->searchResetPage();
        $search = '%' . $this->searchTerm . '%';

        $data = BankSoal::select(
            'jadwal.id',
            'jadwal.tgl_mulai',
            'jadwal.tgl_selesai',
            'bank_soal.id_kelas',
            'bank_soal.kode_bank',
            'jenis_ujian.kode_jenis',
            'mata_pelajaran.kode_mapel',
            DB::raw('(CASE WHEN MIN(nilai_soal_siswa.status) = 0 THEN 0 ELSE 1 END) as status_final')
        )
            ->join('jadwal', 'jadwal.id_bank', 'bank_soal.id')
            ->join('jenis_ujian', 'jenis_ujian.id', 'jadwal.id_jenis_ujian')
            ->join('mata_pelajaran', 'mata_pelajaran.id', 'bank_soal.id_mapel')
            ->join('nilai_soal_siswa', 'nilai_soal_siswa.id_jadwal', 'jadwal.id')
            ->where(function ($query) use ($search) {
                $query->where('tgl_mulai', 'LIKE', $search);
            })
            ->paginate($this->lengthData);

        // dd($data);

        return view('livewire.pelaksanaan-ujian.rekap-nilai', compact('data'));
    }

    private function dispatchAlert($type, $message, $text)
    {
        $this->dispatch('swal:modal', [
            'type'      => $type,
            'message'   => $message,
            'text'      => $text
        ]);
    }

    public function rekapNilai($id_jadwal)
    {
        $nilai_soal_siswa_ids = NilaiSoalSiswa::where([
            ['id_jadwal', $id_jadwal],
            ['status', '0'],
        ])->pluck('id')->toArray();

        if (empty($nilai_soal_siswa_ids)) {
            return;
        }

        DB::transaction(function () use ($nilai_soal_siswa_ids) {
            foreach ($nilai_soal_siswa_ids as $id_nilai_soal_siswa) {
                $nilai_soal_siswa = NilaiSoalSiswa::find($id_nilai_soal_siswa);

                if (!$nilai_soal_siswa) {
                    continue;
                }

                $total_nilai = SoalSiswa::where('id_nilai_soal', $id_nilai_soal_siswa)
                    ->whereColumn('jawaban_alias', 'jawaban_siswa')
                    ->sum('point_soal');

                $nilai_soal_siswa->total_nilai = $total_nilai;
                $nilai_soal_siswa->status = '1';
                $nilai_soal_siswa->save();
            }

            $this->dispatchAlert('success', 'Berhasil!', 'Berhasil merekap nilai ujian!');
        });
    }

    public function detail($id_jadwal) {}
}
