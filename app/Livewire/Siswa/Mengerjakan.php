<?php

namespace App\Livewire\Siswa;

use Carbon\Carbon;
use App\Models\Siswa;
use App\Models\Jadwal;
use Livewire\Component;
use App\Models\SoalSiswa;
use App\Models\DurasiSiswa;
use App\Models\NilaiSoalSiswa;
use Livewire\Attributes\Title;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;

class Mengerjakan extends Component
{
    #[Title('Mengerjakan')]

    protected $listeners = [
        'finishUjian'
    ];

    public $opsi, $ragu;
    public $size, $currentQuestionIndex = 0;
    public $ids, $id_user, $id_siswa;
    public $soals;
    public $jadwal, $siswa, $isian_singkat, $essai, $pg_kompleks = [], $jawaban_jodohkan = [];

    public function mount($id_jadwal = '')
    {
        try {
            $this->ids = Crypt::decryptString($id_jadwal);
            $this->id_user = Auth::user()->id;
            $this->id_siswa = Siswa::where('id_user', Auth::user()->id)->first()->id;

            $this->currentQuestionIndex = session('current_question_index', 0);
        } catch (\Throwable $th) {
            $this->ids = '';
            return redirect('/siswa/ujian');
        }

        $this->siswa = DB::table('siswa')->select('waktu_akhir')
            ->leftJoin('sesi_siswa', 'sesi_siswa.id_siswa', 'siswa.id')
            ->leftJoin('sesi', 'sesi.id', 'sesi_siswa.id_sesi')
            ->where('siswa.id_user', $this->id_user)->first();

        if (date("H:i") > $this->siswa->waktu_akhir) {
            $this->redirect('/siswa/ujian');
        }

        $this->jadwal = DB::table('jadwal')
            ->select('acak_soal')
            ->where('id', $this->ids)
            ->first();

        $this->loadSoals();
    }

    public function render()
    {
        if (date("H:i") > $this->siswa->waktu_akhir) {
            $this->redirect('/siswa/ujian');
        }

        return view('livewire.siswa.mengerjakan', [
            'soals' => $this->soals,
        ]);
    }

    public function loadSoals()
    {
        $paginator = SoalSiswa::select([
            'soal_siswa.id_soal',
            'soal_siswa.id_nilai_soal',
            'nilai_soal_siswa.id_siswa',
            'nilai_soal_siswa.status as status_ujian',
            'soal_siswa.jenis_soal',
            'soal.soal',
            'soal_siswa.opsi_alias_a',
            'soal_siswa.opsi_alias_b',
            'soal_siswa.opsi_alias_c',
            'soal_siswa.opsi_alias_d',
            'soal_siswa.opsi_alias_e',
            'soal_siswa.jawaban_siswa',
            'soal_siswa.ragu',
            'soal.opsi_a',
            'soal.opsi_b',
            'soal.opsi_c',
            'soal.opsi_d',
            'soal.opsi_e'
        ])
            ->leftJoin('soal', 'soal_siswa.id_soal', 'soal.id')
            ->leftJoin('nilai_soal_siswa', 'nilai_soal_siswa.id', 'soal_siswa.id_nilai_soal')
            ->where([
                ['nilai_soal_siswa.id_jadwal', $this->ids],
                ['nilai_soal_siswa.id_siswa', $this->id_siswa]
            ])
            ->when($this->jadwal->acak_soal == 1, function ($query) {
                return $query->inRandomOrder();
            })
            ->paginate(50);

        $this->soals = $paginator->toArray();

        if ($this->soals['data'][$this->currentQuestionIndex]['status_ujian']) {
            $this->redirect('/siswa/ujian');
        }

        foreach ($this->soals['data'] as &$item) {
            $optionsMap = [
                'A' => $item['opsi_a'],
                'B' => $item['opsi_b'],
                'C' => $item['opsi_c'],
                'D' => $item['opsi_d'],
                'E' => $item['opsi_e'],
            ];

            $item['opsi_alias_a'] = $optionsMap[$item['opsi_alias_a']] ?? null;
            $item['opsi_alias_b'] = $optionsMap[$item['opsi_alias_b']] ?? null;
            $item['opsi_alias_c'] = $optionsMap[$item['opsi_alias_c']] ?? null;
            $item['opsi_alias_d'] = $optionsMap[$item['opsi_alias_d']] ?? null;
            $item['opsi_alias_e'] = $optionsMap[$item['opsi_alias_e']] ?? null;

            $item['jawaban_siswa'] = SoalSiswa::select('jawaban_siswa')->leftJoin('nilai_soal_siswa', 'nilai_soal_siswa.id', 'soal_siswa.id_nilai_soal')
                ->where([
                    ['id_soal', $item['id_soal']],
                    ['nilai_soal_siswa.id_siswa', $this->id_siswa]
                ])
                ->value('jawaban_siswa');
        }

        $currentQuestion = $this->soals['data'][$this->currentQuestionIndex];

        switch ($currentQuestion['jenis_soal']) {
            case "1":
                $this->opsi = $currentQuestion['jawaban_siswa'];
                break;
            case "2":
                $jawabanSiswa = $currentQuestion['jawaban_siswa'];
                $this->pg_kompleks = json_decode($jawabanSiswa, true);
                break;
            case "3":
                $this->jawaban_jodohkan = json_decode($currentQuestion['jawaban_siswa']);
                $this->dispatch('initSummernoteJDH');
                break;
            case "4":
                $this->isian_singkat = $currentQuestion['jawaban_siswa'];
                break;
            case "5":
                $this->essai = $currentQuestion['jawaban_siswa'];
                $this->dispatch('initSummernote');
                break;
        }
    }

    public function selectOption($option)
    {
        // Update jawaban siswa di database
        SoalSiswa::where([
            ['id_nilai_soal', $this->soals['data'][$this->currentQuestionIndex]['id_nilai_soal']],
            ['id_soal', $this->soals['data'][$this->currentQuestionIndex]['id_soal']],
        ])
            ->update(['jawaban_siswa' => $option]);

        $this->soals['data'][$this->currentQuestionIndex]['jawaban_siswa'] = $option;

        $this->opsi = $option;
    }

    public function updatedPgKompleks()
    {
        SoalSiswa::where([
            ['id_nilai_soal', $this->soals['data'][$this->currentQuestionIndex]['id_nilai_soal']],
            ['id_soal', $this->soals['data'][$this->currentQuestionIndex]['id_soal']],
        ])
            ->update(['jawaban_siswa' => $this->pg_kompleks]);

        $this->soals['data'][$this->currentQuestionIndex]['jawaban_siswa'] = $this->pg_kompleks;

        $this->pg_kompleks = $this->pg_kompleks;
    }

    public function updatedJawabanJodohkan()
    {
        SoalSiswa::where([
            ['id_nilai_soal', $this->soals['data'][$this->currentQuestionIndex]['id_nilai_soal']],
            ['id_soal', $this->soals['data'][$this->currentQuestionIndex]['id_soal']],
        ])
            ->update(['jawaban_siswa' => json_encode($this->jawaban_jodohkan, JSON_UNESCAPED_SLASHES)]);

        $this->soals['data'][$this->currentQuestionIndex]['jawaban_siswa'] = json_encode($this->jawaban_jodohkan, JSON_UNESCAPED_SLASHES);

        $this->jawaban_jodohkan = $this->jawaban_jodohkan;
    }

    public function updatedIsianSingkat($value)
    {
        SoalSiswa::where([
            ['id_nilai_soal', $this->soals['data'][$this->currentQuestionIndex]['id_nilai_soal']],
            ['id_soal', $this->soals['data'][$this->currentQuestionIndex]['id_soal']],
        ])
            ->update(['jawaban_siswa' => $value]);

        $this->soals['data'][$this->currentQuestionIndex]['jawaban_siswa'] = $value;

        $this->isian_singkat = $value;
    }

    public function updatedEssai($value)
    {
        SoalSiswa::where([
            ['id_nilai_soal', $this->soals['data'][$this->currentQuestionIndex]['id_nilai_soal']],
            ['id_soal', $this->soals['data'][$this->currentQuestionIndex]['id_soal']],
        ])
            ->update(['jawaban_siswa' => $value]);

        $this->soals['data'][$this->currentQuestionIndex]['jawaban_siswa'] = $value;

        $this->essai = $value;
    }

    public function nextQuestion()
    {
        if ($this->currentQuestionIndex < count($this->soals['data']) - 1) {
            $this->currentQuestionIndex++;

            session(['current_question_index' => $this->currentQuestionIndex]);

            if ($this->soals['data'][$this->currentQuestionIndex]['jenis_soal'] == "1") {
                $this->opsi = $this->soals['data'][$this->currentQuestionIndex]['jawaban_siswa'];
            } elseif ($this->soals['data'][$this->currentQuestionIndex]['jenis_soal'] == "2") {
                $jawabanSiswa = $this->soals['data'][$this->currentQuestionIndex]['jawaban_siswa'];
                if (is_string($jawabanSiswa)) {
                    $this->pg_kompleks = json_decode($jawabanSiswa, true);
                } else {
                    $this->pg_kompleks = $jawabanSiswa;
                }
            } elseif ($this->soals['data'][$this->currentQuestionIndex]['jenis_soal'] == "3") {
                $this->jawaban_jodohkan = json_decode($this->soals['data'][$this->currentQuestionIndex]['jawaban_siswa']);
                $this->dispatch('initSummernoteJDH');
            } elseif ($this->soals['data'][$this->currentQuestionIndex]['jenis_soal'] == "4") {
                $this->isian_singkat = $this->soals['data'][$this->currentQuestionIndex]['jawaban_siswa'];
            } elseif ($this->soals['data'][$this->currentQuestionIndex]['jenis_soal'] == "5") {
                $this->essai = $this->soals['data'][$this->currentQuestionIndex]['jawaban_siswa'];
                $this->dispatch('initSummernote');
            }
        }
    }

    public function previousQuestion()
    {
        if ($this->currentQuestionIndex > 0) {
            $this->currentQuestionIndex--;

            session(['current_question_index' => $this->currentQuestionIndex]);

            if ($this->soals['data'][$this->currentQuestionIndex]['jenis_soal'] == "1") {
                $this->opsi = $this->soals['data'][$this->currentQuestionIndex]['jawaban_siswa'];
            } elseif ($this->soals['data'][$this->currentQuestionIndex]['jenis_soal'] == "2") {
                $jawabanSiswa = $this->soals['data'][$this->currentQuestionIndex]['jawaban_siswa'];
                if (is_string($jawabanSiswa)) {
                    $this->pg_kompleks = json_decode($jawabanSiswa, true);
                } else {
                    $this->pg_kompleks = $jawabanSiswa;
                }
            } elseif ($this->soals['data'][$this->currentQuestionIndex]['jenis_soal'] == "3") {
                $this->jawaban_jodohkan = json_decode($this->soals['data'][$this->currentQuestionIndex]['jawaban_siswa']);
                $this->dispatch('initSummernoteJDH');
            } elseif ($this->soals['data'][$this->currentQuestionIndex]['jenis_soal'] == "4") {
                $this->isian_singkat = $this->soals['data'][$this->currentQuestionIndex]['jawaban_siswa'];
            } elseif ($this->soals['data'][$this->currentQuestionIndex]['jenis_soal'] == "5") {
                $this->essai = $this->soals['data'][$this->currentQuestionIndex]['jawaban_siswa'];
                $this->dispatch('initSummernote');
            }
        }
    }

    public function goToQuestion($index)
    {
        $this->currentQuestionIndex = $index;

        session(['current_question_index' => $this->currentQuestionIndex]);

        if ($this->soals['data'][$this->currentQuestionIndex]['jenis_soal'] == "1") {
            $this->opsi = $this->soals['data'][$index]['jawaban_siswa'];
        } elseif ($this->soals['data'][$this->currentQuestionIndex]['jenis_soal'] == "2") {
            $jawabanSiswa = $this->soals['data'][$this->currentQuestionIndex]['jawaban_siswa'];
            if (is_string($jawabanSiswa)) {
                $this->pg_kompleks = json_decode($jawabanSiswa, true);
            } else {
                $this->pg_kompleks = $jawabanSiswa;
            }
        } elseif ($this->soals['data'][$this->currentQuestionIndex]['jenis_soal'] == "3") {
            $this->jawaban_jodohkan = json_decode($this->soals['data'][$this->currentQuestionIndex]['jawaban_siswa']);
            $this->dispatch('initSummernoteJDH');
        } elseif ($this->soals['data'][$this->currentQuestionIndex]['jenis_soal'] == "4") {
            $this->isian_singkat = $this->soals['data'][$index]['jawaban_siswa'];
        } elseif ($this->soals['data'][$this->currentQuestionIndex]['jenis_soal'] == "5") {
            $this->essai = $this->soals['data'][$this->currentQuestionIndex]['jawaban_siswa'];
            $this->dispatch('initSummernote');
        }
    }

    public function selectRagu($value)
    {
        // dd($this->soals['data'][$this->currentQuestionIndex]['id_soal'], $this->id_user, $this->ids, (string)$value);
        // Update ragu di database
        DB::table('soal_siswa')
            ->where([
                ['id_nilai_soal', $this->soals['data'][$this->currentQuestionIndex]['id_nilai_soal']],
                ['id_soal', $this->soals['data'][$this->currentQuestionIndex]['id_soal']],
            ])
            ->update(['ragu' => (string)$value]);

        $this->soals['data'][$this->currentQuestionIndex]['ragu'] = $value;
    }

    public function confirmFinish()
    {
        $this->dispatch('confirm:ujian', [
            'type'      => 'warning',
            'message'   => 'Apakah Anda yakin?',
            'text'      => 'Pastikan semua jawaban sudah yakin dan tidak ada yang ragu-ragu.'
        ]);
    }

    public function finishUjian()
    {
        try {
            DB::transaction(function () {
                $raguQuestions = SoalSiswa::where([
                    ['id_nilai_soal', $this->soals['data'][$this->currentQuestionIndex]['id_nilai_soal']],
                    ['ragu', '1'],
                ])->exists();

                if ($raguQuestions) {
                    $this->dispatchAlert('error', 'Gagal!', ' Pastikan semua soal sudah terjawab dengan yakin dan tidak ada yang ditandai sebagai ragu.');
                } else {

                    // Ambil ID nilai soal yang sedang diproses
                    $idNilaiSoal = $this->soals['data'][$this->currentQuestionIndex]['id_nilai_soal'];

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

                    // $totalNilai = SoalSiswa::where('id_nilai_soal', $this->soals['data'][$this->currentQuestionIndex]['id_nilai_soal'])
                    //     ->whereColumn('jawaban_alias', 'jawaban_siswa')
                    //     ->sum('point_soal');

                    // NilaiSoalSiswa::where('id', $this->soals['data'][$this->currentQuestionIndex]['id_nilai_soal'])
                    //     ->update(['total_nilai' => $totalNilai, 'status' => '1']);

                    $durasi = DurasiSiswa::select('mulai')->where([['id_siswa', $this->id_siswa], ['id_jadwal', $this->ids]]);

                    if ($durasi) {
                        $waktu_mulai = Carbon::parse($durasi->first()->mulai);
                        $waktu_selesai = Carbon::now();
                        $lama_ujian = $waktu_selesai->diff($waktu_mulai)->format('%H:%I:%S');

                        $durasi->update(['status' => '2', 'lama_ujian' => $lama_ujian, 'selesai' => $waktu_selesai]);
                    }

                    $this->dispatchAlertFinish('success', 'Ujian Selesai', 'Anda telah menyelesaikan semua soal dengan yakin. Terima kasih!');
                }
            });
        } catch (\Exception $e) {
            $this->dispatchAlert('error', 'Gagal!', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function changeSize($size)
    {
        $this->size = $size;
    }

    private function dispatchAlertFinish($type, $message, $text)
    {
        $this->dispatch('swal:finish', [
            'type' => $type,
            'message' => $message,
            'text' => $text
        ]);
    }

    private function dispatchAlert($type, $message, $text)
    {
        $this->dispatch('swal:modal', [
            'type' => $type,
            'message' => $message,
            'text' => $text
        ]);
    }
}
