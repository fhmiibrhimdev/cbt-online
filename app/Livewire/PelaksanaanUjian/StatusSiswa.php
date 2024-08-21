<?php

namespace App\Livewire\PelaksanaanUjian;

use Carbon\Carbon;
use App\Models\Siswa;
use App\Models\Token;
use App\Models\Jadwal;
use Livewire\Component;
use App\Models\BankSoal;
use App\Models\SesiSiswa;
use App\Models\SoalSiswa;
use App\Models\DurasiSiswa;
use App\Models\NilaiSoalSiswa;
use Livewire\Attributes\Title;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class StatusSiswa extends Component
{
    #[Title('Status Siswa')]

    protected $listeners = ['terapkanAksi'];

    public $id_jadwal = '0', $id_ruang = '0', $id_sesi = '0', $id_kelas;
    public $token;
    public $jadwals = [], $ruangs = [], $sesis = [], $data = [];
    public $reset_izin = [], $paksa_selesai = [], $ulang = [];

    public function mount()
    {
        $this->token = Token::first()->token ?? "";

        $this->jadwals = DB::table('jadwal')->select('jadwal.id', 'kode_bank')
            ->join('bank_soal', 'bank_soal.id', 'jadwal.id_bank')
            ->get();

        $this->initSelect2();
    }

    public function updated($id, $value)
    {
        if ($id == "id_jadwal") {
            $this->id_ruang = '0';
            $this->id_sesi = '0';
            $this->ruangs = [];
            $this->sesis = [];
            $this->getRuang();
        } elseif ($id == "id_ruang") {
            $this->sesis = [];
            $this->id_sesi = '0';
            $this->getSesi();
        } elseif ($id == "id_sesi") {
            $this->loadData();
        }

        $this->initSelect2();
    }

    private function getRuang()
    {
        $id_kelas = DB::table('jadwal')->select('id_kelas')
            ->join('bank_soal', 'bank_soal.id', 'jadwal.id_bank')
            ->where([
                ['jadwal.id', $this->id_jadwal],
            ])->first()->id_kelas ?? "";

        $this->id_kelas = explode(',', $id_kelas);

        $this->ruangs = DB::table('sesi_siswa')->select('ruang.id', 'ruang.nama_ruang')
            ->join('ruang', 'ruang.id', 'sesi_siswa.id_ruang')
            ->whereIn('id_kelas', $this->id_kelas)
            ->distinct()
            ->get();

        // dd($this->ruangs);
    }

    private function getSesi()
    {
        $this->sesis = DB::table('sesi_siswa')->select('sesi.id', 'sesi.nama_sesi')
            ->join('ruang', 'ruang.id', 'sesi_siswa.id_ruang')
            ->join('sesi', 'sesi.id', 'sesi_siswa.id_sesi')
            ->whereIn('id_kelas', $this->id_kelas)
            ->where('sesi_siswa.id_ruang', $this->id_ruang)
            ->distinct()
            ->get();

        // dd($this->sesis);
    }

    private function initSelect2()
    {
        $this->dispatch('initSelect2');
    }

    public function loadData()
    {
        $this->data = DB::table('bank_soal')->select(
            'siswa.id as id_siswa',
            'nomor_peserta',
            'nama_siswa',
            'level',
            'nama_kelas',
            'kode_ruang',
            'kode_sesi',
            DB::raw("TIME_FORMAT(ds2.mulai, '%H:%i') as mulai"),
            'ds2.lama_ujian',
            'ds2.status',
            'sessions.user_id',
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
            ->leftJoin('sessions', 'sessions.user_id', 'siswa.id_user')
            ->when($this->id_jadwal, function ($query) {
                return $query->where('ds2.id_jadwal', $this->id_jadwal);
            })
            ->when($this->id_ruang, function ($query) {
                return $query->where('ds2.id_ruang', $this->id_ruang);
            })
            ->when($this->id_sesi, function ($query) {
                return $query->where('ds2.id_sesi', $this->id_sesi);
            })
            ->distinct()
            ->get()
            ->map(function ($item) {
                $item->lama_ujian = $item->lama_ujian ? $this->formatDuration($item->lama_ujian) : '';
                return $item;
            });
    }

    public function render()
    {
        $this->initSelect2();
        $this->loadData();

        return view('livewire.pelaksanaan-ujian.status-siswa');
    }

    public function terapkanAksiConfirm()
    {
        $this->dispatch('swal:confirm', [
            'type'      => 'warning',
            'message'   => 'Perhatian!',
            'text'      => 'Apakah anda yakin ingin menerapkan aksi?'
        ]);
    }

    public function terapkanAksi()
    {
        try {
            DB::transaction(function () {
                if (!empty($this->paksa_selesai)) {
                    $this->paksaSelesai();
                }

                if (!empty($this->reset_izin)) {
                    $this->resetIzin($this->reset_izin);
                }

                if (!empty($this->ulang)) {
                    $this->ulang();
                }
            });

            $this->dispatchAlert('success', 'Berhasil!', 'Aksi berhasil diterapkan.');
        } catch (\Exception $e) {
            $this->dispatchAlert('error', 'Gagal!', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    private function paksaSelesai()
    {
        // $nss_ids = NilaiSoalSiswa::whereIn('id_siswa', $this->paksa_selesai)
        //     ->where([
        //         ['id_jadwal', $this->id_jadwal],
        //         ['status', '0'],
        //     ])
        //     ->pluck('id')
        //     ->toArray();

        // if (!empty($nss_ids)) {
        //     $nss_data = [];

        //     foreach ($nss_ids as $id_nss) {
        //         $total_nilai = SoalSiswa::where('id_nilai_soal', $id_nss)
        //             ->whereColumn('jawaban_alias', 'jawaban_siswa')
        //             ->sum('point_soal');

        //         $nss_data[$id_nss] = $total_nilai;
        //     }

        //     $cases = [];
        //     $ids = [];

        //     foreach ($nss_data as $id => $total_nilai) {
        //         $cases[] = "WHEN id = $id THEN $total_nilai";
        //         $ids[] = $id;
        //     }

        //     $ids_list = implode(',', $ids);
        //     $cases_statement = implode(' ', $cases);

        //     DB::update("UPDATE nilai_soal_siswa SET total_nilai = CASE $cases_statement END, status = '1' WHERE id IN ($ids_list)");
        // }

        $nss_ids = NilaiSoalSiswa::whereIn('id_siswa', $this->paksa_selesai)
            ->where([
                ['id_jadwal', $this->id_jadwal],
                ['status', '0'],
            ])
            ->pluck('id')
            ->toArray();

        if (!empty($nss_ids)) {
            // Mulai transaksi database
            DB::transaction(function () use ($nss_ids) {
                foreach ($nss_ids as $idNilaiSoal) {
                    // Hitung total poin berdasarkan jenis soal
                    $totalPoinPerJenis = DB::table(DB::raw("(SELECT 1 AS jenis_soal UNION ALL SELECT 2 UNION ALL SELECT 3 UNION ALL SELECT 4 UNION ALL SELECT 5) AS all_jenis_soal"))
                        ->leftJoin(DB::raw("(SELECT jenis_soal, SUM(point_soal) AS total_point FROM soal_siswa WHERE id_nilai_soal = $idNilaiSoal AND jawaban_alias = jawaban_siswa GROUP BY jenis_soal) AS TotalPoin"), 'all_jenis_soal.jenis_soal', '=', 'TotalPoin.jenis_soal')
                        ->select('all_jenis_soal.jenis_soal', DB::raw('COALESCE(TotalPoin.total_point, 0) AS total_point'))
                        ->orderBy('all_jenis_soal.jenis_soal')
                        ->get()
                        ->mapWithKeys(function ($item) {
                            return [$item->jenis_soal => $item->total_point];
                        })
                        ->toArray();

                    $cekPg = DB::table('soal_siswa')
                        ->selectRaw('SUM(CASE WHEN jawaban_alias = jawaban_siswa THEN 1 ELSE 0 END) AS pg_benar, SUM(CASE WHEN jawaban_alias <> jawaban_siswa THEN 1 ELSE 0 END) AS pg_salah')
                        ->where('id_nilai_soal', $idNilaiSoal)
                        ->where('jenis_soal', 1)
                        ->first();

                    // Update nilai berdasarkan jenis soal
                    NilaiSoalSiswa::where('id', $idNilaiSoal)
                        ->update([
                            'pg_benar' => $cekPg->pg_benar, // Pilihan Ganda (PG)
                            'pg_salah' => $cekPg->pg_salah, // Pilihan Ganda (PG)
                            'nilai_pg' => $totalPoinPerJenis[1] ?? 0,
                            'nilai_pk' => $totalPoinPerJenis[2] ?? 0, // Pilihan Ganda Kompleks (PK)
                            'nilai_jo' => $totalPoinPerJenis[3] ?? 0, // Menjodohkan (JO)
                            'nilai_is' => $totalPoinPerJenis[4] ?? 0, // Isian Singkat (IS)
                            'nilai_es' => $totalPoinPerJenis[5] ?? 0, // Isian Essai (ES)
                            'status'    => '1',
                            'dikoreksi' => '0'
                        ]);
                }
            });
        }

        $durasi_siswa_ids = DurasiSiswa::whereIn('id_siswa', $this->paksa_selesai)
            ->where([
                ['id_jadwal', $this->id_jadwal],
            ])
            ->pluck('id')
            ->toArray();

        if (!empty($durasi_siswa_ids)) {
            $update_values = [];
            foreach ($durasi_siswa_ids as $id_durasi_siswa) {
                $durasi = DurasiSiswa::find($id_durasi_siswa);
                if ($durasi) {
                    $waktu_mulai = Carbon::parse($durasi->mulai);
                    $waktu_selesai = Carbon::now();
                    $lama_ujian = $waktu_selesai->diff($waktu_mulai)->format('%H:%I:%S');

                    $update_values[] = "WHEN id = $id_durasi_siswa THEN '$lama_ujian'";
                }
            }

            if (!empty($update_values)) {
                $update_values_statement = implode(' ', $update_values);
                $ids_list = implode(',', $durasi_siswa_ids);
                DB::update("UPDATE durasi_siswa SET lama_ujian = CASE $update_values_statement END, status = '2', selesai = NOW() WHERE id IN ($ids_list)");
            }
        }
    }

    private function resetIzin($data)
    {
        $user_reset = Siswa::whereIn('id', $data)->pluck('id_user')->toArray();
        DB::table('sessions')->whereIn('user_id', $user_reset)->delete();
    }

    private function ulang()
    {
        $this->resetIzin($this->ulang);

        DurasiSiswa::whereIn('id_siswa', $this->ulang)->update(['status' => '0', 'lama_ujian' => '00:00:00', 'mulai' => '', 'selesai' => '']);

        $nss = NilaiSoalSiswa::whereIn('id_siswa', $this->ulang);
        $id_nss = $nss->pluck('id')->toArray();

        SoalSiswa::whereIn('id_nilai_soal', $id_nss)->delete();
        $nss->delete();
    }

    public function refresh()
    {
        $this->reset_izin = [];
        $this->paksa_selesai = [];
        $this->ulang = [];
        $this->loadData();
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

    private function dispatchAlert($type, $message, $text)
    {
        $this->dispatch('swal:modal', [
            'type'      => $type,
            'message'   => $message,
            'text'      => $text
        ]);
    }
}
