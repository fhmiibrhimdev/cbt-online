<?php

namespace App\Livewire\Ujian\BankSoal;

use App\Models\Soal;
use Livewire\Component;
use App\Models\BankSoal;
use App\Helpers\GlobalHelper;
use Livewire\Attributes\Title;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Crypt;

class Detail extends Component
{
    #[Title('Detail Bank Soal')]

    protected $listeners = [
        'delete'
    ];

    public $ids, $bank_soal, $selectedJenis = '1', $ditampilkan, $total_ditampilkan, $bobotnya, $seharusnya, $seluruh_total_seharusnya;
    public $dataId, $isEditing = false, $id_bank_soal;

    public $datas, $soal = '', $opsi_a = '', $opsi_b = '', $opsi_c = '', $opsi_d = '', $opsi_e = '', $jawaban = '';
    public $id_tp, $id_smt;

    public $opsi_kompleks = [], $opsi_benar_kompleks = [], $jawaban_jodohkan = [];

    public function mount($id_bank_soal)
    {
        $this->id_bank_soal  = $id_bank_soal;
        $this->ids           = Crypt::decrypt($id_bank_soal);

        // $this->selectedJenis = $jenis;

        $this->initialBankSoal();
    }

    public function addOpsiKompleks()
    {
        $nextKey = chr(count($this->opsi_kompleks) + 65);
        $this->opsi_kompleks[$nextKey] = '';

        $this->dispatch('initSummernotePGK');
    }

    public function removeOpsiKompleks($key)
    {
        if (isset($this->opsi_kompleks[$key])) {
            unset($this->opsi_kompleks[$key]);

            $this->opsi_benar_kompleks = array_filter($this->opsi_benar_kompleks, function ($correctKey) use ($key) {
                return $correctKey !== $key;
            });

            $newKeys = range('A', chr(65 + count($this->opsi_kompleks) - 1));
            $this->opsi_kompleks = array_combine($newKeys, array_values($this->opsi_kompleks));

            $this->opsi_benar_kompleks = array_map(function ($oldKey) use ($newKeys) {
                return array_search($oldKey, $newKeys) !== false ? $newKeys[array_search($oldKey, $newKeys)] : '';
            }, $this->opsi_benar_kompleks);
        }
    }

    public function toggleCorrectOpsiKompleks($key)
    {
        if (in_array($key, $this->opsi_benar_kompleks)) {
            $this->opsi_benar_kompleks = array_diff($this->opsi_benar_kompleks, [$key]);
        } else {
            $this->opsi_benar_kompleks[] = $key;
        }
    }

    private function initialBankSoal()
    {
        $this->id_tp    = GlobalHelper::getActiveTahunPelajaranId();
        $this->id_smt   = GlobalHelper::getActiveSemesterId();

        $result = DB::table('bank_soal')
            ->select(
                'bank_soal.kode_bank',
                'mata_pelajaran.nama_mapel',
                'guru.nama_guru',
                'bank_soal.id_kelas',
                'bank_soal.opsi',
                DB::raw("(bank_soal.jml_pg + bank_soal.jml_esai + bank_soal.jml_kompleks + bank_soal.jml_jodohkan + bank_soal.jml_isian) as total_soal")
            )
            ->join('mata_pelajaran', 'mata_pelajaran.id', '=', 'bank_soal.id_mapel')
            ->join('guru', 'guru.id', '=', 'bank_soal.id_guru')
            ->where([
                ['bank_soal.id', $this->ids],
                ['bank_soal.id_tp', $this->id_tp],
            ])
            ->first();

        $this->bank_soal             = new BankSoal();
        $this->bank_soal->kode_bank  = $result->kode_bank ?? "...";
        $this->bank_soal->nama_mapel = $result->nama_mapel ?? "...";
        $this->bank_soal->nama_guru  = $result->nama_guru ?? "...";
        $this->bank_soal->id_kelas   = $result->id_kelas ?? "...";
        $this->bank_soal->opsi       = $result->opsi ?? "0";
        $this->seluruh_total_seharusnya = $result->total_soal ?? "0";
    }

    public function render()
    {
        $this->initialBankSoal();

        $seluruh_total_dibuat = DB::table('soal')
            ->select('soal.id')
            ->leftJoin('bank_soal', 'bank_soal.id', 'soal.id_bank')
            ->where([['id_bank', $this->ids], ['bank_soal.id_tp', $this->id_tp]])
            ->get()->count();

        $seluruh_total_ditampilkan = DB::table('bank_soal')
            ->select(
                DB::raw("(tampil_pg + tampil_esai + tampil_kompleks + tampil_jodohkan + tampil_isian) as total_ditampilkan")
            )->where([['id', $this->ids], ['id_tp', $this->id_tp],])
            ->first()->total_ditampilkan ?? 0;

        $columns = [
            "1" => ["jumlah" => "jml_pg", "tampil" => "tampil_pg", "bobot" => "bobot_pg"],
            "2" => ["jumlah" => "jml_kompleks", "tampil" => "tampil_kompleks", "bobot" => "bobot_kompleks"],
            "3" => ["jumlah" => "jml_jodohkan", "tampil" => "tampil_jodohkan", "bobot" => "bobot_jodohkan"],
            "4" => ["jumlah" => "jml_isian", "tampil" => "tampil_isian", "bobot" => "bobot_isian"],
            "5" => ["jumlah" => "jml_esai", "tampil" => "tampil_esai", "bobot" => "bobot_esai"],
        ];

        $seharusnya = 0;
        $ditampilkan = 0;

        if (array_key_exists($this->selectedJenis, $columns)) {
            $columnJumlah = $columns[$this->selectedJenis]['jumlah'];
            $columnTampil = $columns[$this->selectedJenis]['tampil'];
            $columnBobot = $columns[$this->selectedJenis]['bobot'];
            $bankSoal = BankSoal::select($columnJumlah, $columnTampil, $columnBobot)->where([
                ['id', $this->ids],
                ['id_tp', $this->id_tp],
            ])->first();
            $this->seharusnya = $bankSoal->$columnJumlah ?? 0;
            $this->bobotnya = $bankSoal->$columnBobot ?? 0;
            $this->ditampilkan = $bankSoal->$columnTampil ?? 0;
        }

        $this->datas = Soal::select('soal.id', 'soal', 'nomor_soal', 'opsi_a', 'opsi_b', 'opsi_c', 'opsi_d', 'opsi_e', 'jawaban', 'tampilkan', DB::raw("IFNULL(COUNT(jadwal.id), 0) as jadwal_count"), DB::raw("IFNULL(COUNT(nilai_soal_siswa.id), 0) as nilai_count"))
            ->join('bank_soal', 'bank_soal.id', 'soal.id_bank')
            ->leftJoin('jadwal', function ($join) {
                $join->on('jadwal.id_bank', '=', 'bank_soal.id')
                    ->where('jadwal.status', '=', '1');
            })
            ->leftJoin('nilai_soal_siswa', 'nilai_soal_siswa.id_jadwal', 'jadwal.id')
            ->where([
                ['soal.id_bank', $this->ids],
                ['soal.jenis', $this->selectedJenis],
                ['bank_soal.id_tp', $this->id_tp]
            ])
            ->groupBy('soal.id', 'soal.soal', 'soal.nomor_soal', 'soal.opsi_a', 'soal.opsi_b', 'soal.opsi_c', 'soal.opsi_d', 'soal.opsi_e', 'soal.jawaban', 'soal.tampilkan')
            ->get();

        $total_dibuat = $this->datas->count();
        $this->datas = $this->datas->toArray();

        if ($this->selectedJenis == "3") {
            $this->dispatch('linkerListJDH');
        }
        return view('livewire.ujian.bank-soal.detail', compact('total_dibuat', 'seluruh_total_dibuat', 'seluruh_total_ditampilkan'));
    }

    public function jenis($jenis)
    {
        $this->selectedJenis = $jenis;
    }

    private function dispatchAlert($type, $message, $text)
    {
        $this->dispatch('swal:modal', [
            'type'      => $type,
            'message'   => $message,
            'text'      => $text
        ]);

        $this->resetInputFields();
    }

    public function isEditingMode($mode)
    {
        $this->isEditing = $mode;
        if ($this->selectedJenis == "1") {
            $this->dispatch('initSummernotePG');
        } else if ($this->selectedJenis == "2") {
            $this->dispatch('initSummernotePGK');
        } else if ($this->selectedJenis == "3") {
            $this->dispatch('initSummernoteJDH');
        } else if ($this->selectedJenis == "4") {
            $this->dispatch('initSummernoteIS');
        } else if ($this->selectedJenis == "5") {
            $this->dispatch('initSummernoteES');
        }
    }

    private function resetInputFields()
    {
        $this->soal    = '';
        $this->opsi_a  = '';
        $this->opsi_b  = '';
        $this->opsi_c  = '';
        $this->opsi_d  = '';
        $this->opsi_e  = '';
        $this->jawaban = '';

        $this->opsi_kompleks = [];
        $this->opsi_benar_kompleks = [];
        $this->jawaban_jodohkan = [];

        if ($this->selectedJenis == "1") {
            $this->dispatch('initSummernotePG');
        } else if ($this->selectedJenis == "2") {
            $this->dispatch('initSummernotePGK');
        } else if ($this->selectedJenis == "3") {
            $this->dispatch('initSummernoteJDH');
        } else if ($this->selectedJenis == "4") {
            $this->dispatch('initSummernoteIS');
        } else if ($this->selectedJenis == "5") {
            $this->dispatch('initSummernoteES');
        }
    }

    public function cancel()
    {
        $this->resetInputFields();
    }

    public function store()
    {
        $lastNomorSoal = Soal::select('nomor_soal')
            ->where([['id_bank', $this->ids], ['jenis', $this->selectedJenis]])->max('nomor_soal');

        $nomor_soal    = $lastNomorSoal !== null ? $lastNomorSoal + 1 : 1;

        if ($this->selectedJenis == "1") {
            $opsi_a  = $this->opsi_a;
            $opsi_b  = $this->opsi_b;
            $opsi_c  = $this->opsi_c;
            $opsi_d  = $this->opsi_d;
            $opsi_e  = $this->opsi_e;
            $jawaban = $this->jawaban;
        } elseif ($this->selectedJenis == "2") {
            $opsi_a = json_encode($this->opsi_kompleks, JSON_UNESCAPED_SLASHES);
            $opsi_b  = '';
            $opsi_c  = '';
            $opsi_d  = '';
            $opsi_e  = '';
            $jawaban = json_encode($this->opsi_benar_kompleks, JSON_UNESCAPED_SLASHES);
        } else if ($this->selectedJenis == "3") {
            $opsi_a  = '';
            $opsi_b  = '';
            $opsi_c  = '';
            $opsi_d  = '';
            $opsi_e  = '';
            $jawaban = json_encode($this->processLinks($this->jawaban_jodohkan), JSON_UNESCAPED_SLASHES);
        } else if ($this->selectedJenis == "4" || $this->selectedJenis == "5") {
            $opsi_a  = '';
            $opsi_b  = '';
            $opsi_c  = '';
            $opsi_d  = '';
            $opsi_e  = '';
            $jawaban = $this->jawaban;
        }

        // dd($jawaban);

        Soal::create([
            'id_bank'    => $this->ids,
            'jenis'      => $this->selectedJenis,
            'nomor_soal' => $nomor_soal,
            'soal'       => $this->soal,
            'opsi_a'     => $opsi_a,
            'opsi_b'     => $opsi_b,
            'opsi_c'     => $opsi_c,
            'opsi_d'     => $opsi_d,
            'opsi_e'     => $opsi_e,
            'jawaban'    => $jawaban,
            'tampilkan'  => '0',
        ]);

        $this->dispatchAlert('success', 'Success!', 'Data created successfully.');
    }

    public function edit($id)
    {
        $this->isEditing = true;
        $data = Soal::select('soal', 'opsi_a', 'opsi_b', 'opsi_c', 'opsi_d', 'opsi_e', 'jawaban')->findOrFail($id);

        $this->dataId  = $id;
        $this->soal    = $data->soal;

        if ($this->selectedJenis == '1') {
            $this->opsi_a  = $data->opsi_a;
            $this->opsi_b  = $data->opsi_b;
            $this->opsi_c  = $data->opsi_c;
            $this->opsi_d  = $data->opsi_d;
            $this->opsi_e  = $data->opsi_e;
            $this->jawaban = $data->jawaban;
        } elseif ($this->selectedJenis == '2') {
            $this->opsi_kompleks = json_decode($data->opsi_a, true) ?? [];
            $this->opsi_benar_kompleks = json_decode($data->jawaban, true) ?? [];
        } elseif ($this->selectedJenis == '3') {
            $this->jawaban = json_decode($data->jawaban);
        } elseif ($this->selectedJenis == '4' || $this->selectedJenis == '5') {
            $this->jawaban = $data->jawaban;
        }

        if ($this->selectedJenis == "1") {
            $this->dispatch('initSummernotePG');
        } else if ($this->selectedJenis == "2") {
            $this->dispatch('initSummernotePGK');
        } else if ($this->selectedJenis == "3") {
            $this->dispatch('initSummernoteJDH');
        } else if ($this->selectedJenis == "4") {
            $this->dispatch('initSummernoteIS');
        } else if ($this->selectedJenis == "5") {
            $this->dispatch('initSummernoteES');
        }
    }

    public function update()
    {
        $lastNomorSoal = Soal::select('nomor_soal')
            ->where([
                ['id_bank', $this->ids],
                ['jenis', $this->selectedJenis]
            ])->max('nomor_soal');

        $nomor_soal = $lastNomorSoal !== null ? $lastNomorSoal + 1 : 1;

        if ($this->selectedJenis == "1") {
            $opsi_a  = $this->opsi_a;
            $opsi_b  = $this->opsi_b;
            $opsi_c  = $this->opsi_c;
            $opsi_d  = $this->opsi_d;
            $opsi_e  = $this->opsi_e;
            $jawaban = $this->jawaban;
        } elseif ($this->selectedJenis == "2") {
            $opsi_a = json_encode($this->opsi_kompleks, JSON_UNESCAPED_SLASHES);
            $opsi_b  = '';
            $opsi_c  = '';
            $opsi_d  = '';
            $opsi_e  = '';
            $jawaban = json_encode($this->opsi_benar_kompleks, JSON_UNESCAPED_SLASHES);
        } else if ($this->selectedJenis == "3") {
            $opsi_a  = '';
            $opsi_b  = '';
            $opsi_c  = '';
            $opsi_d  = '';
            $opsi_e  = '';
            $jawaban = json_encode($this->processLinks($this->jawaban_jodohkan), JSON_UNESCAPED_SLASHES);
        } else if ($this->selectedJenis == "4" || $this->selectedJenis == "5") {
            $opsi_a  = '';
            $opsi_b  = '';
            $opsi_c  = '';
            $opsi_d  = '';
            $opsi_e  = '';
            $jawaban = $this->jawaban;
        }

        if ($this->dataId) {
            Soal::findOrFail($this->dataId)->update([
                'nomor_soal' => $nomor_soal,
                'soal'       => $this->soal,
                'opsi_a'     => $opsi_a,
                'opsi_b'     => $opsi_b,
                'opsi_c'     => $opsi_c,
                'opsi_d'     => $opsi_d,
                'opsi_e'     => $opsi_e,
                'jawaban'    => $jawaban,
            ]);

            $this->dispatchAlert('success', 'Success!', 'Data updated successfully.');
            $this->dataId = null;
        }
    }

    public function deleteConfirm($id)
    {
        $this->dataId = $id;
        $this->dispatch('swal:confirm', [
            'type'    => 'warning',
            'message' => 'Are you sure?',
            'text'    => 'If you delete the data, it cannot be restored!'
        ]);
    }

    public function delete()
    {
        Soal::findOrFail($this->dataId)->delete();
        $this->dispatchAlert('success', 'Success!', 'Data deleted successfully.');
    }

    public function status($id, $active)
    {
        if ($active == "1") {
            if ((int)$this->ditampilkan >= (int)$this->seharusnya) {
                $this->dispatchAlert('warning', 'Info!', 'Soal yang terpilih: ' . $this->ditampilkan . '<br/> Seharusnya: ' . $this->seharusnya);
                return;
            }
        }

        Soal::where('id', $id)->update(['tampilkan' => $active]);


        $total_tampil   = Soal::where([['id_bank', $this->ids], ['jenis', $this->selectedJenis], ['tampilkan', '1'],])->count();

        $jenisMapping = [
            '1' => 'tampil_pg',
            '2' => 'tampil_kompleks',
            '3' => 'tampil_jodohkan',
            '4' => 'tampil_isian',
            '5' => 'tampil_esai'
        ];

        if (isset($jenisMapping[$this->selectedJenis])) {
            $nama_kolom = $jenisMapping[$this->selectedJenis];
            BankSoal::where('id', $this->ids)->update([$nama_kolom => $total_tampil]);
        }
    }

    private function detectFormat($links)
    {
        if (is_array($links)) {
            // Cek apakah ini array dari array
            return 'arrayOfArrays';
        } elseif (is_object($links) && !is_array($links)) {
            // Cek apakah ini object dari array
            return 'objectOfArrays';
        }
        return 'unknown';
    }

    private function processLinks(&$jawaban)
    {
        $format = $this->detectFormat($jawaban['links']);
        $newLinks = []; // Mulai dengan array kosong

        if ($format === 'objectOfArrays') {
            // Jika format links adalah objek, konversi ke array
            foreach ($jawaban['links'] as $key => $value) {
                $index = (int)$key;
                $newLinks[$index] = $value;
            }
        } elseif ($format === 'arrayOfArrays') {
            // Jika format sudah array dari array
            $newLinks = $jawaban['links'];
        } else {
            // Tangani format lainnya jika perlu
        }

        // Menambahkan null pada indeks 0 jika tidak ada data di sana
        if (!array_key_exists(0, $newLinks)) {
            $newLinks = array_merge([null], $newLinks);
        }

        // Atur hasil akhir ke jawaban['links']
        $jawaban['links'] = array_values($newLinks); // Reindex array jika diperlukan

        return $jawaban;
    }
}
