<?php

namespace App\Livewire\Umum\KelasRombel;

use App\Models\Kelas;
use App\Models\Level;
use App\Models\Siswa;
use App\Models\Jurusan;
use Livewire\Component;
use App\Models\Semester;
use App\Models\KelasDetail;
use Livewire\WithPagination;
use App\Models\TahunPelajaran;
use Livewire\Attributes\Title;
use Illuminate\Support\Facades\DB;

class KelasRombel extends Component
{
    use WithPagination;
    #[Title('Kelas Rombel')]

    protected $listeners = [
        'delete'
    ];
    protected $rules = [
        'nama_kelas' => 'required',
    ];

    public $lengthData = 25;
    public $searchTerm;
    public $previousSearchTerm = '';
    public $isEditing = false;

    public $dataId, $id_level, $id_jurusan, $nama_kelas, $kode_kelas, $id_guru, $jumlah_siswa;
    public $id_siswa = [];
    public $levels, $jurusans, $siswas, $siswasedit, $openForm;

    public function mount()
    {
        $this->levels     = Level::get();
        $this->jurusans   = Jurusan::get();

        $this->nama_kelas = '';
        $this->kode_kelas = '';

        $this->id_jurusan = '';
        $this->id_level   = '';
        $this->id_guru    = '';

        $kelas_detail      = KelasDetail::select('id_siswa')->get();
        $id_siswa_in_kelas = $kelas_detail->pluck('id_siswa')->toArray();

        if (empty($id_siswa_in_kelas)) {
            $this->siswas = Siswa::select('id', 'nama_siswa', 'nisn')->get();
        } else {
            $this->siswas = Siswa::select('id', 'nama_siswa', 'nisn')
                ->whereNotIn('id', $id_siswa_in_kelas)
                ->get();
        }
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

        $data = Kelas::select('kelas.id', 'kelas.nama_kelas', 'kelas.kode_kelas', 'kelas.jumlah_siswa', 'jurusan.nama_jurusan', 'level')
            ->join('jurusan', 'jurusan.id', 'kelas.id_jurusan')
            ->join('level', 'level.id', 'kelas.id_level')
            ->where('nama_kelas', 'LIKE', $search)
            ->paginate($this->lengthData);

        return view('livewire.umum.kelas-rombel.kelas-rombel', compact('data'));
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
    }

    private function resetInputFields()
    {
        $this->nama_kelas   = '';
        $this->kode_kelas   = '';

        $this->id_jurusan   = '';
        $this->id_level     = '';
        $this->id_guru      = '';

        $this->id_siswa     = '';
        $this->jumlah_siswa = '';
    }

    public function cancel()
    {
        $this->resetInputFields();
    }

    public function store()
    {
        DB::transaction(function () {
            $this->validate();

            $id_tp = TahunPelajaran::where('active', '0')->first()->id;
            $id_smt = Semester::where('active', '0')->first()->id;

            $kelas = Kelas::create([
                'id_tp'          => $id_tp,
                'id_smt'         => $id_smt,
                'nama_kelas'     => $this->nama_kelas,
                'kode_kelas'     => $this->kode_kelas,
                'id_jurusan'     => $this->id_jurusan,
                'id_level'       => $this->id_level,
                'id_guru'        => '0',
                'jumlah_siswa'   => $this->jumlah_siswa,
            ]);

            $kelasDetailData = [];

            foreach ($this->id_siswa as $siswa_id) {
                $kelasDetailData[] = [
                    'id_kelas'       => $kelas->id,
                    'id_tp'          => $id_tp,
                    'id_smt'         => $id_smt,
                    'id_siswa'       => $siswa_id[0],
                ];
            }

            KelasDetail::insert($kelasDetailData);

            Siswa::whereIn('id', $this->id_siswa)->update(['status_kelas' => '1', 'id_kelas' => $kelas->id]);

            $this->dispatchAlert('success', 'Success!', 'Data created successfully.');
            $this->dispatch('reloadPage');
        });
    }

    public function deleteConfirm($id)
    {
        $this->dataId = $id;
        $this->dispatch('swal:confirm', [
            'type'      => 'warning',
            'message'   => 'Are you sure?',
            'text'      => 'If you delete the data, it cannot be restored!'
        ]);
    }

    public function delete()
    {
        DB::transaction(function () {
            Kelas::findOrFail($this->dataId)->delete();
            KelasDetail::where('id_kelas', $this->dataId)->delete();
            Siswa::where('id_kelas', $this->dataId)->update(['status_kelas' => '0', 'id_kelas' => '0']);

            $this->dispatchAlert('success', 'Success!', 'Data deleted successfully.');
            $this->dispatch('reloadPage');
        });
    }
}
