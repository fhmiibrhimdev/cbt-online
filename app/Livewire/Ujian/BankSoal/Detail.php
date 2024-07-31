<?php

namespace App\Livewire\Ujian\BankSoal;

use Livewire\Component;
use App\Models\BankSoal;
use App\Models\Soal;
use Livewire\Attributes\Title;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Crypt;

class Detail extends Component
{
    #[Title('Detail Bank Soal')]

    protected $listeners = [
        'delete'
    ];

    public $ids, $bank_soal, $selectedJenis = '1', $ditampilkan, $seharusnya, $seluruh_total_seharusnya;
    public $dataId, $isEditing = false, $id_bank_soal;

    public $soal = '', $opsi_a = '', $opsi_b = '', $opsi_c = '', $opsi_d = '', $opsi_e = '', $jawaban = '';

    private function initialBankSoal()
    {
        $result = DB::table('bank_soal')
            ->select('bank_soal.kode_bank', 'mata_pelajaran.nama_mapel', 'guru.nama_guru', 'bank_soal.id_kelas', 'bank_soal.opsi', DB::raw("(bank_soal.jml_pg + bank_soal.jml_esai + bank_soal.jml_kompleks + bank_soal.jml_jodohkan + bank_soal.jml_isian) as total_soal"))
            ->join('mata_pelajaran', 'mata_pelajaran.id', '=', 'bank_soal.id_mapel')
            ->join('guru', 'guru.id', '=', 'bank_soal.id_guru')
            ->where('bank_soal.id', $this->ids)
            ->first();

        $this->bank_soal             = new BankSoal();
        $this->bank_soal->kode_bank  = $result->kode_bank;
        $this->bank_soal->nama_mapel = $result->nama_mapel;
        $this->bank_soal->nama_guru  = $result->nama_guru;
        $this->bank_soal->id_kelas   = $result->id_kelas;
        $this->bank_soal->total_soal = $result->total_soal;
        $this->bank_soal->opsi       = $result->opsi;
        $this->seluruh_total_seharusnya = $this->bank_soal->total_soal;
    }

    private function initialDitampilkan()
    {
        $total_tampil   = Soal::where([['id_bank', $this->ids], ['jenis', $this->selectedJenis], ['tampilkan', '1'],])->count();

        $this->ditampilkan = $total_tampil;
    }

    public function mount($id_bank_soal, $jenis)
    {
        $this->id_bank_soal  = $id_bank_soal;
        $this->ids           = Crypt::decrypt($id_bank_soal);

        $this->selectedJenis = $jenis;

        $this->initialBankSoal();

        $this->initialDitampilkan();
    }

    public function render()
    {
        $this->initialBankSoal();

        $seluruh_total_dibuat = Soal::select('id')->where([['id_bank', $this->ids]])->get()->count();
        $seluruh_total_ditampilkan = BankSoal::select(DB::raw("(tampil_pg + tampil_esai + tampil_kompleks + tampil_jodohkan + tampil_isian) as total_ditampilkan"))->where('id', $this->ids)->first()->total_ditampilkan;

        $columns = [
            "1" => ["jumlah" => "jml_pg", "tampil" => "tampil_pg"],
            "2" => ["jumlah" => "jml_kompleks", "tampil" => "tampil_kompleks"],
            "3" => ["jumlah" => "jml_jodohkan", "tampil" => "tampil_jodohkan"],
            "4" => ["jumlah" => "jml_isian", "tampil" => "tampil_isian"],
            "5" => ["jumlah" => "jml_esai", "tampil" => "tampil_esai"],
        ];

        $seharusnya = 0;
        $ditampilkan = 0;

        if (array_key_exists($this->selectedJenis, $columns)) {
            $columnJumlah = $columns[$this->selectedJenis]['jumlah'];
            $columnTampil = $columns[$this->selectedJenis]['tampil'];
            $bankSoal = BankSoal::select($columnJumlah, $columnTampil)->where('id', $this->ids)->first();
            $this->seharusnya = $bankSoal->$columnJumlah;
            $ditampilkan = $bankSoal->$columnTampil;
        }

        $data = Soal::select('id', 'soal', 'nomor_soal', 'opsi_a', 'opsi_b', 'opsi_c', 'opsi_d', 'opsi_e', 'jawaban', 'tampilkan')
            ->where([
                ['id_bank', $this->ids],
                ['jenis', $this->selectedJenis]
            ])
            ->get();

        $total_dibuat = $data->count();



        return view('livewire.ujian.bank-soal.detail', compact('data', 'total_dibuat', 'seluruh_total_dibuat', 'ditampilkan', 'seluruh_total_ditampilkan'));
    }

    public function jenis($jenis)
    {

        return redirect()->route('bank-soal-detail', ['id_bank_soal' => $this->id_bank_soal, 'jenis' => $jenis]);
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
        $this->dispatch('initSummernote');
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

        $this->dispatch('initSummernote');
    }

    public function cancel()
    {
        $this->resetInputFields();
    }

    public function store()
    {
        $lastNomorSoal = Soal::select('nomor_soal')
            ->where([
                ['id_bank', $this->ids],
                ['jenis', $this->selectedJenis]
            ])->max('nomor_soal');

        $nomor_soal    = $lastNomorSoal !== null ? $lastNomorSoal + 1 : 1;

        Soal::create([
            'id_bank'    => $this->ids,
            'jenis'      => $this->selectedJenis,
            'nomor_soal' => $nomor_soal,
            'soal'       => $this->soal,
            'opsi_a'     => $this->opsi_a,
            'opsi_b'     => $this->opsi_b,
            'opsi_c'     => $this->opsi_c,
            'opsi_d'     => $this->opsi_d,
            'opsi_e'     => $this->opsi_e,
            'jawaban'    => $this->jawaban,
            'tampilkan'  => '0',
        ]);

        $this->dispatchAlert('success', 'Success!', 'Data created successfully.');
    }

    public function edit($id)
    {
        $this->isEditing = true;
        $data = Soal::select('soal', 'opsi_a', 'opsi_b', 'opsi_c', 'opsi_d', 'opsi_e', 'jawaban')->findOrFail($id);

        // dd($data);
        $this->dataId  = $id;
        $this->soal    = $data->soal;
        $this->opsi_a  = $data->opsi_a;
        $this->opsi_b  = $data->opsi_b;
        $this->opsi_c  = $data->opsi_c;
        $this->opsi_d  = $data->opsi_d;
        $this->opsi_e  = $data->opsi_e;
        $this->jawaban = $data->jawaban;

        $this->dispatch('initSummernote');
    }

    public function update()
    {
        $lastNomorSoal = Soal::select('nomor_soal')
            ->where([
                ['id_bank', $this->ids],
                ['jenis', $this->selectedJenis]
            ])->max('nomor_soal');

        $nomor_soal = $lastNomorSoal !== null ? $lastNomorSoal + 1 : 1;

        if ($this->dataId) {
            Soal::findOrFail($this->dataId)->update([
                'nomor_soal' => $nomor_soal,
                'soal'       => $this->soal,
                'opsi_a'     => $this->opsi_a,
                'opsi_b'     => $this->opsi_b,
                'opsi_c'     => $this->opsi_c,
                'opsi_d'     => $this->opsi_d,
                'opsi_e'     => $this->opsi_e,
                'jawaban'    => $this->jawaban,
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


        // dd($this->ditampilkan);

        $this->initialDitampilkan();
    }
}
