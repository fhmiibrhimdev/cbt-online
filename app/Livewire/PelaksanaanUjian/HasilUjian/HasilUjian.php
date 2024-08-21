<?php

namespace App\Livewire\PelaksanaanUjian\HasilUjian;

use App\Models\Kelas;
use App\Models\Jadwal;
use Livewire\Component;
use App\Models\BankSoal;
use App\Models\SoalSiswa;
use App\Helpers\GlobalHelper;
use App\Models\NilaiSoalSiswa;
use Exception;
use Livewire\Attributes\Title;
use Illuminate\Support\Facades\DB;

class HasilUjian extends Component
{
    #[Title('Hasil Ujian')]

    public $id_kelas = "0", $id_jadwal = "0";
    public $jadwals = "", $nama_kelas = "";
    public $kelases, $jadwales = [], $hasil_ujian = [], $nilais = [], $inputan = [];
    public $id_tp, $id_smt;

    public function mount()
    {
        $this->id_tp    = GlobalHelper::getActiveTahunPelajaranId();
        $this->id_smt   = GlobalHelper::getActiveSemesterId();

        $this->kelases = DB::table('jadwal')->select('kelas.id', 'siswa.id_kelas', 'kelas.kode_kelas', 'level.level')
            ->join('durasi_siswa', 'durasi_siswa.id_jadwal', 'jadwal.id')
            ->join('siswa', 'siswa.id', 'durasi_siswa.id_siswa')
            ->join('kelas', 'kelas.id', 'siswa.id_kelas')
            ->join('level', 'level.id', 'kelas.id_level')
            ->where('kelas.id_tp', $this->id_tp)
            ->distinct()
            ->get()
            ->groupBy('level');

        // dd($this->kelases);

        // $this->initSelect2();
    }

    public function render()
    {
        $this->initSelect2();

        return view('livewire.pelaksanaan-ujian.hasil-ujian.hasil-ujian');
    }

    public function refresh()
    {
        $this->updatedIdJadwal();
    }

    public function updatedIdKelas()
    {
        $this->id_jadwal = '0';
        $this->jadwals = '';
        $this->nama_kelas = '';
        $this->hasil_ujian = [];

        $this->jadwales = DB::table('bank_soal')->select('jadwal.id', 'kode_bank')
            ->join('jadwal', 'jadwal.id_bank', 'bank_soal.id')
            ->whereRaw("FIND_IN_SET(?, id_kelas) > 0", [$this->id_kelas])
            ->get();

        // $this->initSelect2();
    }

    public function inputNilai()
    {
        $this->nilais = NilaiSoalSiswa::select(
            'siswa.id',
            'nomor_peserta',
            'nama_siswa',
            'nilai_pg',
            'nilai_pk',
            'nilai_jo',
            'nilai_is',
            'nilai_es',
        )
            ->leftJoin('siswa', 'siswa.id', 'nilai_soal_siswa.id_siswa')
            ->leftJoin('nomor_peserta', 'nomor_peserta.id_siswa', 'nilai_soal_siswa.id_siswa')
            ->where('id_jadwal', $this->id_jadwal)
            ->get()
            ->map(function ($nilai) {
                // Initialize inputan for each student
                $this->inputan[$nilai->id] = [
                    'nilai_pk' => $nilai->nilai_pk,
                    'nilai_jo' => $nilai->nilai_jo,
                    'nilai_is' => $nilai->nilai_is,
                    'nilai_es' => $nilai->nilai_es,
                ];
                return $nilai;
            });

        // dd($this->nilais);
    }

    public function validateInputValues()
    {
        // Ambil nilai bobot dari tabel bank_soal
        $bobot = DB::table('bank_soal')->select('bobot_pg', 'bobot_kompleks', 'bobot_jodohkan', 'bobot_isian', 'bobot_esai')->first();

        foreach ($this->inputan as $siswaId => $nilaiData) {
            if ($nilaiData['nilai_pk'] > $bobot->bobot_kompleks) {
                $this->dispatchAlert('warning', 'Peringatan!', "Nilai Kompleks untuk ID siswa {$siswaId} melebihi batas maksimum.");
                $this->inputan = [];
                return false;
            }
            if ($nilaiData['nilai_jo'] > $bobot->bobot_jodohkan) {
                $this->dispatchAlert('warning', 'Peringatan!', "Nilai Jodohkan untuk ID siswa {$siswaId} melebihi batas maksimum.");
                $this->inputan = [];
                return false;
            }
            if ($nilaiData['nilai_is'] > $bobot->bobot_isian) {
                $this->dispatchAlert('warning', 'Peringatan!', "Nilai Isian untuk ID siswa {$siswaId} melebihi batas maksimum.");
                $this->inputan = [];
                return false;
            }
            if ($nilaiData['nilai_es'] > $bobot->bobot_esai) {
                $this->dispatchAlert('warning', 'Peringatan!', "Nilai Esai untuk ID siswa {$siswaId} melebihi batas maksimum.");
                $this->inputan = [];
                return false;
            }
        }

        return true; // Kembalikan true jika validasi lolos
    }

    public function updateNilai()
    {
        try {
            if ($this->validateInputValues()) {
                foreach ($this->inputan as $siswaId => $nilaiData) {
                    NilaiSoalSiswa::updateOrCreate(
                        ['id_siswa' => $siswaId, 'id_jadwal' => $this->id_jadwal],
                        $nilaiData
                    );
                }
                $this->updatedIdJadwal();
                $this->dispatchAlert('success', 'Success!', 'Data berhasil diubah!.');
                $this->inputan = [];
            }
        } catch (Exception $e) {
            $this->dispatchAlert('warning', 'Alert!', 'Ada Kesalahan: ' . $e->getMessage());
            $this->inputan = [];
        }
    }

    public function tandaiSemua()
    {
        try {
            NilaiSoalSiswa::where('id_jadwal', $this->id_jadwal)->update(["dikoreksi" => "1"]);
            $this->updatedIdJadwal();
            $this->dispatchAlert('success', 'Success!', 'Semua siswa sudah dikoreksi.');
        } catch (Exception $e) {
            $this->dispatchAlert('warning', 'Alert!', 'Ada Kesalahan: ' . $e->getMessage());
        }
    }

    private function dispatchAlert($type, $message, $text)
    {
        $this->dispatch('swal:modal', [
            'type'      => $type,
            'message'   => $message,
            'text'      => $text
        ]);
    }

    public function updatedIdJadwal()
    {
        $kelas = Kelas::find($this->id_kelas);
        $this->nama_kelas = $kelas ? $kelas->nama_kelas : null;

        $this->jadwals = DB::table('jadwal')->select(
            'mata_pelajaran.nama_mapel',
            'guru.nama_guru',
            'bank_soal.kode_bank',
            DB::raw("(bank_soal.jml_pg + bank_soal.jml_esai + bank_soal.jml_kompleks + bank_soal.jml_jodohkan + bank_soal.jml_isian) as total_soal")
        )
            ->join('bank_soal', 'bank_soal.id', 'jadwal.id_bank')
            ->join('mata_pelajaran', 'mata_pelajaran.id', 'bank_soal.id_mapel')
            ->join('guru', 'guru.id', 'bank_soal.id_guru')
            ->where('jadwal.id', $this->id_jadwal)
            ->first();

        $this->hasil_ujian = DB::table('bank_soal')->select(
            'siswa.id as id_siswa',
            'nomor_peserta.nomor_peserta',
            'siswa.nama_siswa',
            'level.level',
            'kelas.nama_kelas',
            'ruang.kode_ruang',
            'sesi.kode_sesi',
            DB::raw("TIME_FORMAT(ds2.mulai, '%H:%i') as mulai"),
            'ds2.lama_ujian',
            'ds2.status',
            'nss2.pg_benar',
            'nss2.pg_salah',
            'nss2.nilai_pg',
            'nss2.nilai_pk',
            'nss2.nilai_jo',
            'nss2.nilai_is',
            'nss2.nilai_es',
            'nss2.dikoreksi',
        )
            ->leftJoin('jadwal', 'jadwal.id_bank', 'bank_soal.id')
            ->leftJoin('kelas', DB::raw('FIND_IN_SET(kelas.id, bank_soal.id_kelas)'), '>', DB::raw('0'))
            ->leftJoin('level', 'level.id', 'kelas.id_level')
            ->leftJoin('siswa', 'siswa.id_kelas', 'kelas.id')
            ->leftJoin('nomor_peserta', 'nomor_peserta.id_siswa', 'siswa.id')
            ->leftJoin('durasi_siswa as ds1', 'ds1.id_jadwal', 'jadwal.id')
            ->leftJoin('durasi_siswa as ds2', 'ds2.id_siswa', 'siswa.id')
            ->leftJoin('ruang', 'ruang.id', 'ds2.id_ruang')
            ->leftJoin('sesi', 'sesi.id', 'ds2.id_sesi')
            ->leftJoin('nilai_soal_siswa as nss1', 'nss1.id_jadwal', 'ds2.id_jadwal')
            ->leftJoin('nilai_soal_siswa as nss2', 'nss2.id_siswa', 'ds2.id_siswa')
            ->where([
                ['kelas.id', $this->id_kelas],
                ['ds2.id_jadwal', $this->id_jadwal],
            ])
            ->distinct()
            ->get()
            ->map(function ($item) {
                $item->lama_ujian = $item->lama_ujian ? $this->formatDuration($item->lama_ujian) : '';
                return $item;
            });

        // $this->initSelect2();
    }

    public function formatDuration($duration)
    {
        // Split duration into hours, minutes, and seconds
        list($hours, $minutes, $seconds) = explode(':', $duration);

        // Convert to integer
        $hours = (int) $hours;
        $minutes = (int) $minutes;
        $seconds = (int) $seconds;

        // Format the duration
        $result = [];
        if ($hours > 0) {
            $result[] = "{$hours} j";
        }
        if ($minutes >= 0) {
            $result[] = "{$minutes} mnt";
        }

        return implode(' ', $result);
    }

    private function initSelect2()
    {
        $this->dispatch('initSelect2');
    }
}
