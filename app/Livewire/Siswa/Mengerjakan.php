<?php

namespace App\Livewire\Siswa;

use App\Models\Jadwal;
use App\Models\NilaiSoalSiswa;
use Livewire\Component;
use App\Models\SoalSiswa;
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
    public $ids, $id_user;
    public $soals;
    public $jadwal, $siswa;

    public function mount($id_jadwal = '')
    {
        try {
            $this->ids = Crypt::decryptString($id_jadwal);
            $this->id_user = Auth::user()->id;

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

    public function loadSoals()
    {
        $paginator = SoalSiswa::select([
            'nilai_soal_siswa.id_bank',
            'nilai_soal_siswa.id_jadwal',
            'soal_siswa.id_soal',
            'soal_siswa.id_nilai_soal',
            'nilai_soal_siswa.id_siswa',
            'nilai_soal_siswa.status as status_ujian',
            'soal_siswa.jenis_soal',
            'soal_siswa.no_soal_alias',
            'soal.soal',
            'soal_siswa.opsi_alias_a',
            'soal_siswa.opsi_alias_b',
            'soal_siswa.opsi_alias_c',
            'soal_siswa.opsi_alias_d',
            'soal_siswa.opsi_alias_e',
            'soal_siswa.jawaban_alias',
            'soal_siswa.jawaban_siswa',
            'soal_siswa.ragu',
            // 'soal_siswa.jawaban_benar',
            'soal.opsi_a',
            'soal.opsi_b',
            'soal.opsi_c',
            'soal.opsi_d',
            'soal.opsi_e'
        ])
            ->leftJoin('soal', 'soal_siswa.id_soal', 'soal.id')
            ->leftJoin('nilai_soal_siswa', 'nilai_soal_siswa.id', 'soal_siswa.id_nilai_soal')
            ->where('nilai_soal_siswa.id_jadwal', $this->ids)
            ->where('nilai_soal_siswa.id_siswa', Auth::user()->id)
            ->when($this->jadwal->acak_soal == 1, function ($query) {
                return $query->inRandomOrder();
            })
            ->paginate(50); // Ubah jumlah per halaman sesuai kebutuhan

        // Mengubah koleksi ke array
        $this->soals = $paginator->toArray();

        if ($this->soals['data'][$this->currentQuestionIndex]['status_ujian']) {
            $this->redirect('/siswa/ujian');
        }

        // Jika Anda ingin memetakan opsi seperti sebelumnya
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
                    ['nilai_soal_siswa.id_siswa', $this->id_user]
                ])
                ->value('jawaban_siswa');
        }

        $this->opsi = $this->soals['data'][$this->currentQuestionIndex]['jawaban_siswa'];
        // dd($this->soals);
    }


    public function render()
    {
        if (date("H:i") > $this->siswa->waktu_akhir) {
            $this->redirect('/siswa/ujian');
        }

        return view('livewire.siswa.mengerjakan', [
            'soals' => $this->soals, // Kirim data ke view
        ]);
    }

    public function changeSize($size)
    {
        $this->size = $size;
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

    public function nextQuestion()
    {
        if ($this->currentQuestionIndex < count($this->soals['data']) - 1) {
            $this->currentQuestionIndex++;

            session(['current_question_index' => $this->currentQuestionIndex]);

            $this->opsi = $this->soals['data'][$this->currentQuestionIndex]['jawaban_siswa'];
        }
    }

    public function previousQuestion()
    {
        if ($this->currentQuestionIndex > 0) {
            $this->currentQuestionIndex--;

            session(['current_question_index' => $this->currentQuestionIndex]);

            $this->opsi = $this->soals['data'][$this->currentQuestionIndex]['jawaban_siswa'];
        }
    }

    public function goToQuestion($index)
    {
        $this->currentQuestionIndex = $index;

        session(['current_question_index' => $this->currentQuestionIndex]);

        // Ambil jawaban siswa untuk soal yang dipilih
        $this->opsi = $this->soals['data'][$index]['jawaban_siswa'];
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
        $raguQuestions = SoalSiswa::where([
            ['id_nilai_soal', $this->soals['data'][$this->currentQuestionIndex]['id_nilai_soal']],
            ['ragu', '1'],
        ])->exists();

        if ($raguQuestions) {
            $this->dispatchAlert('error', 'Gagal!', ' Pastikan semua soal sudah terjawab dengan yakin dan tidak ada yang ditandai sebagai ragu.');
        } else {
            $soalSiswaRecords = SoalSiswa::where('id_nilai_soal', $this->soals['data'][$this->currentQuestionIndex]['id_nilai_soal'])
                ->get();

            $totalNilai = 0;

            foreach ($soalSiswaRecords as $record) {
                if ($record->jawaban_siswa == $record->jawaban_alias) {
                    $totalNilai += (float)$record->point_soal;
                }
            }

            NilaiSoalSiswa::where('id', $this->soals['data'][$this->currentQuestionIndex]['id_nilai_soal'])
                ->update(['total_nilai' => $totalNilai, 'status' => '1']);

            $this->dispatchAlertFinish('success', 'Ujian Selesai', 'Anda telah menyelesaikan semua soal dengan yakin. Terima kasih!');
        }
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
