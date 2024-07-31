<?php

namespace App\Livewire\Ujian\BankSoal;

use App\Models\Guru;
use App\Models\Kelas;
use App\Models\Level;
use Livewire\Component;
use App\Models\Semester;
use Livewire\WithPagination;
use App\Models\MataPelajaran;
use App\Models\TahunPelajaran;
use Livewire\Attributes\Title;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Crypt;
use App\Models\BankSoal as ModelsBankSoal;
use App\Models\Soal;

class BankSoal extends Component
{
    use WithPagination;
    #[Title('Bank Soal')]

    protected $listeners = [
        'delete'
    ];
    protected $rules = [
        'id_mapel' => 'required',
        'id_guru'  => 'required',
        'id_level' => 'required',
        'id_kelas' => 'required',
    ];

    public $lengthData = 25;
    public $searchTerm;
    public $previousSearchTerm = '';
    public $isEditing = false;

    public $dataId;
    public $kode_bank, $level_bank, $nama_bank = "";
    public $id_level = "", $id_kelas = [], $id_mapel, $id_jurusan, $id_guru, $id_tp, $id_smt = "0";
    public $jml_pg = '0', $jml_esai = '0', $jml_kompleks = '0', $jml_jodohkan = '0', $jml_isian = "0";
    public $tampil_pg, $tampil_esai, $tampil_kompleks, $tampil_jodohkan, $tampil_isian = "0";
    public $bobot_pg = '0', $bobot_esai = '0', $bobot_kompleks = '0', $bobot_jodohkan = '0', $bobot_isian = "0";
    public $opsi = '5', $kkm, $deskripsi, $status_soal = "1";
    public $mapels, $gurus = [], $levels, $kelass = [];

    public function mount()
    {
        $this->mapels = MataPelajaran::select('id', 'nama_mapel')->where('status', '1')->get();
        $this->levels = Level::select('id', 'level')->get();
        $this->dispatch('initSelect2');
    }

    private function initSelect2()
    {
        $this->dispatch('initSelect2');
    }

    public function updatedIdMapel()
    {
        $this->id_guru  = '';
        $this->id_kelas = [];
        $this->kelass   = [];

        $this->gurus = Guru::select('guru.id', 'nama_guru')
            ->join('jabatan_guru', 'jabatan_guru.id_guru', 'guru.id')
            ->join('jabatan_guru_detail', 'jabatan_guru_detail.id_jabatan_guru', 'jabatan_guru.id')
            ->where('jabatan_guru_detail.id_mapel', $this->id_mapel)
            ->distinct()
            ->get()
            ->toArray();

        $this->initSelect2();
    }

    public function updatedIdGuru()
    {
        $arr_id_kelas = Guru::select('jabatan_guru_detail.id_kelas')
            ->join('jabatan_guru', 'jabatan_guru.id_guru', 'guru.id')
            ->join('jabatan_guru_detail', 'jabatan_guru_detail.id_jabatan_guru', 'jabatan_guru.id')
            ->where([
                ['jabatan_guru_detail.id_mapel', $this->id_mapel],
                ['guru.id', $this->id_guru]
            ])
            ->pluck('jabatan_guru_detail.id_kelas');

        $this->kelass = DB::table('kelas')->select('kelas.id', 'kode_kelas', 'level')->join('level', 'level.id', 'kelas.id_level')->whereIn('kelas.id', $arr_id_kelas)->get();

        $this->initSelect2();
    }

    public function updatedIdLevel()
    {
        $this->initSelect2();
    }

    public function updatedIdKelas()
    {
        $kode_mapel      = MataPelajaran::select('id', 'kode_mapel')->where('id', $this->id_mapel)->first()->kode_mapel;
        $level           = Level::select('level')->where('id', $this->id_level)->first()->level;

        $this->kode_bank = $level . '-' . date('dmyis') . '-' . strtoupper($kode_mapel);

        $this->initSelect2();
    }

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
        $this->searchResetPage();
        $search = '%' . $this->searchTerm . '%';

        $data   = ModelsBankSoal::select(
            'bank_soal.id',
            'kode_bank',
            'id_kelas',
            'mata_pelajaran.nama_mapel',
            'mata_pelajaran.kode_mapel',
            'nama_guru',
            DB::raw("(jml_pg + jml_esai + jml_kompleks + jml_jodohkan + jml_isian) as total_seharusnya"),
            DB::raw("(tampil_pg + tampil_esai + tampil_kompleks + tampil_jodohkan + tampil_isian) as total_ditampilkan")
        )
            ->leftJoin('mata_pelajaran', 'mata_pelajaran.id', 'bank_soal.id_mapel')
            ->leftJoin('guru', 'guru.id', 'bank_soal.id_guru')
            ->where(function ($query) use ($search) {
                $query->where('bank_soal.kode_bank', 'LIKE', $search);
                $query->orWhere('mata_pelajaran.nama_mapel', 'LIKE', $search);
            })
            ->paginate($this->lengthData);

        return view('livewire.ujian.bank-soal.bank-soal', compact('data'));
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
        $this->initSelect2();
    }

    private function resetInputFields()
    {
        $this->kode_bank       = '';

        $this->id_level        = '';
        $this->id_kelas        = [];
        $this->id_mapel        = '';
        $this->id_guru         = '';
        $this->id_tp           = '';
        $this->id_smt          = '';

        $this->jml_pg          = '0';
        $this->jml_esai        = '0';
        $this->jml_kompleks    = '0';
        $this->jml_jodohkan    = '0';
        $this->jml_isian       = '0';

        $this->tampil_pg       = '0';
        $this->tampil_esai     = '0';
        $this->tampil_kompleks = '0';
        $this->tampil_jodohkan = '0';
        $this->tampil_isian    = '0';

        $this->bobot_pg        = '0';
        $this->bobot_esai      = '0';
        $this->bobot_kompleks  = '0';
        $this->bobot_jodohkan  = '0';
        $this->bobot_isian     = '0';

        $this->opsi            = '5';
        $this->kkm             = '0';
        $this->deskripsi       = '-';
        $this->status_soal     = '1';

        $this->gurus = [];
    }

    public function cancel()
    {
        $this->resetInputFields();
    }

    public function store()
    {
        $this->validate();

        $id_tp = TahunPelajaran::where('active', '1')->first()->id;
        $id_smt = Semester::where('active', '1')->first()->id;

        ModelsBankSoal::create([
            'kode_bank'       => $this->kode_bank,

            'id_level'        => $this->id_level,
            'id_kelas'        => implode(',', $this->id_kelas),
            'id_mapel'        => $this->id_mapel,
            'id_guru'         => $this->id_guru,
            'id_tp'           => $id_tp,
            'id_smt'          => $id_smt,

            'jml_pg'          => $this->jml_pg,
            'jml_esai'        => $this->jml_esai,
            'jml_kompleks'    => $this->jml_kompleks,
            'jml_jodohkan'    => $this->jml_jodohkan,
            'jml_isian'       => $this->jml_isian,

            'tampil_pg'       => '0',
            'tampil_esai'     => '0',
            'tampil_kompleks' => '0',
            'tampil_jodohkan' => '0',
            'tampil_isian'    => '0',

            'bobot_pg'        => $this->bobot_pg,
            'bobot_esai'      => $this->bobot_esai,
            'bobot_kompleks'  => $this->bobot_kompleks,
            'bobot_jodohkan'  => $this->bobot_jodohkan,
            'bobot_isian'     => $this->bobot_isian,

            'opsi'            => $this->opsi,
            'kkm'             => '0',
            'deskripsi'       => '-',
            'status_soal'     => $this->status_soal,
        ]);

        $this->dispatchAlert('success', 'Success!', 'Data created successfully.');
    }

    public function edit($id)
    {
        $this->isEditing      = true;
        $data                 = ModelsBankSoal::findOrFail($id);
        $this->dataId         = $id;

        $this->kode_bank      = $data->kode_bank;
        $this->nama_bank      = $data->nama_bank;
        $this->id_level       = $data->id_level;
        $this->id_kelas       = explode(',', $data->id_kelas);
        $this->id_mapel       = $data->id_mapel;
        $this->id_guru        = $data->id_guru;
        $this->id_tp          = $data->id_tp;
        $this->id_smt         = $data->id_smt;
        $this->jml_pg         = $data->jml_pg;
        $this->jml_esai       = $data->jml_esai;
        $this->jml_kompleks   = $data->jml_kompleks;
        $this->jml_jodohkan   = $data->jml_jodohkan;
        $this->jml_isian      = $data->jml_isian;
        $this->bobot_pg       = $data->bobot_pg;
        $this->bobot_esai     = $data->bobot_esai;
        $this->bobot_kompleks = $data->bobot_kompleks;
        $this->bobot_jodohkan = $data->bobot_jodohkan;
        $this->bobot_isian    = $data->bobot_isian;
        $this->opsi           = $data->opsi;
        $this->status_soal    = $data->status_soal;

        $this->gurus = Guru::select('guru.id', 'nama_guru')
            ->join('jabatan_guru', 'jabatan_guru.id_guru', 'guru.id')
            ->join('jabatan_guru_detail', 'jabatan_guru_detail.id_jabatan_guru', 'jabatan_guru.id')
            ->where('jabatan_guru_detail.id_mapel', $this->id_mapel)
            ->distinct()
            ->get()
            ->toArray();

        $arr_id_kelas = Guru::select('jabatan_guru_detail.id_kelas')
            ->join('jabatan_guru', 'jabatan_guru.id_guru', 'guru.id')
            ->join('jabatan_guru_detail', 'jabatan_guru_detail.id_jabatan_guru', 'jabatan_guru.id')
            ->where([
                ['jabatan_guru_detail.id_mapel', $this->id_mapel],
                ['guru.id', $this->id_guru]
            ])
            ->pluck('jabatan_guru_detail.id_kelas');

        $this->kelass    = DB::table('kelas')->select('kelas.id', 'kode_kelas', 'level')->join('level', 'level.id', 'kelas.id_level')->whereIn('kelas.id', $arr_id_kelas)->get();

        $kode_mapel      = MataPelajaran::select('id', 'kode_mapel')->where('id', $this->id_mapel)->first()->kode_mapel;
        $level           = Level::select('level')->where('id', $this->id_level)->first()->level;


        $this->kode_bank = $level . '-' . date('dmyis') . '-' . strtoupper($kode_mapel);

        $this->initSelect2();
    }

    public function update()
    {
        $this->validate();

        $id_tp  = TahunPelajaran::where('active', '1')->first()->id;
        $id_smt = Semester::where('active', '1')->first()->id;

        if ($this->dataId) {
            ModelsBankSoal::findOrFail($this->dataId)->update([
                'kode_bank'       => $this->kode_bank,

                'id_level'        => $this->id_level,
                'id_kelas'        => implode(',', $this->id_kelas),
                'id_mapel'        => $this->id_mapel,
                'id_guru'         => $this->id_guru,
                'id_tp'           => $id_tp,
                'id_smt'          => $id_smt,

                'jml_pg'          => $this->jml_pg,
                'jml_esai'        => $this->jml_esai,
                'jml_kompleks'    => $this->jml_kompleks,
                'jml_jodohkan'    => $this->jml_jodohkan,
                'jml_isian'       => $this->jml_isian,

                'bobot_pg'        => $this->bobot_pg,
                'bobot_esai'      => $this->bobot_esai,
                'bobot_kompleks'  => $this->bobot_kompleks,
                'bobot_jodohkan'  => $this->bobot_jodohkan,
                'bobot_isian'     => $this->bobot_isian,

                'opsi'            => $this->opsi,
                'kkm'             => '0',
                'deskripsi'       => '-',
                'status_soal'     => $this->status_soal,
            ]);

            $this->dispatchAlert('success', 'Success!', 'Data updated successfully.');
            $this->dataId = null;
        }
    }

    public function deleteConfirm($id)
    {
        $this->dataId = $id;
        $this->dispatch('swal:confirm', [
            'type'      => 'warning',
            'message'   => 'Apa anda yakin?',
            'text'      => 'Jika ingin menghapus data, seluruh data soal di dalamnya akan terhapus!'
        ]);
    }

    public function delete()
    {
        ModelsBankSoal::findOrFail($this->dataId)->delete();
        Soal::where('id_bank', $this->dataId)->delete();
        $this->dispatchAlert('success', 'Success!', 'Data deleted successfully.');
    }
}
