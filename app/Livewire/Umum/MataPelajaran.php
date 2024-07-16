<?php

namespace App\Livewire\Umum;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\KelompokMapel;
use Livewire\Attributes\Title;
use Illuminate\Support\Facades\DB;
use App\Models\MataPelajaran as ModelsMataPelajaran;

class MataPelajaran extends Component
{
    use WithPagination;
    #[Title('Mata Pelajaran')]

    protected $listeners = [
        'delete'
    ];

    public $lengthData = 50;
    public $searchTerm;
    public $previousSearchTerm = '';
    public $isEditing = false;

    public $dataId, $id_kelompok;
    public $kategori, $kode_kelompok, $nama_kelompok, $id_parent;
    public $status, $nama_mapel, $kode_mapel, $no_urut;
    public $deleteMode = '';

    public function mount()
    {
        $this->id_kelompok = '';
        $this->kategori = '';
        $this->kode_kelompok = '';
        $this->nama_kelompok = '';
        $this->id_parent = '0';

        $this->nama_mapel = '';
        $this->kode_mapel = '';
        $this->no_urut = '1';
        $this->status = '1';

        $this->dispatch('initSelect2');
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
        $search = '%'.$this->searchTerm.'%';

        $data = ModelsMataPelajaran::select('mata_pelajaran.*', 'kelompok_mapel.kode_kelompok as kode_kelompok', 'kelompok_mapel.nama_kelompok as nama_kelompok')
                    ->join('kelompok_mapel', 'kelompok_mapel.id', 'mata_pelajaran.id_kelompok')
                    ->where(function($query) use ($search) {
                        $query->where('nama_mapel', 'LIKE', $search)
                              ->orWhere('kode_mapel', 'LIKE', $search);
                    })
                    ->orderBy('nama_kelompok', 'ASC')
                    ->orderBy(DB::raw('CAST(no_urut AS UNSIGNED)'), 'ASC')
                    ->paginate($this->lengthData);

        $kelompok_mapels = KelompokMapel::get();

        return view('livewire.umum.mata-pelajaran', compact('data', 'kelompok_mapels'));
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
        $this->dispatch('resetSelect2');
    }

    private function resetInputFields()
    {
        $this->kategori = '';
        $this->kode_kelompok = '';
        $this->nama_kelompok = '';
        $this->id_parent = '0';
        $this->id_kelompok = '';

        $this->nama_mapel = '';
        $this->kode_mapel = '';
        $this->no_urut = '1';
        $this->status = '1';
    }

    public function cancel()
    {
        $this->resetInputFields();
    }

    public function store($mode)
    {
        $this->validate($this->getValidationRule($mode));

        if ($mode == "subkelompok" && $this->id_parent > 0) {
            $this->kategori = KelompokMapel::whereId($this->id_parent)->first()->kategori;
        }

        $this->createData($mode);

        $this->dispatchAlert('success', 'Success!', 'Data created successfully.');
    }

    private function getValidationRule($mode)
    {
        switch ($mode) {
            case "kelompok":
                return [
                    'kategori'      => 'required',
                    'kode_kelompok' => 'required',
                    'nama_kelompok' => 'required',
                ];
            case "subkelompok":
                return [
                    'kode_kelompok' => 'required',
                    'nama_kelompok' => 'required',
                    'id_parent'     => 'required',
                ];
            case "mapel":
                return [
                    'id_kelompok'  => 'required',
                    'nama_mapel'   => 'required',
                    'kode_mapel'   => 'required',
                    'status'       => 'required',
                    'no_urut'      => 'required',
                ];
            default:
                return [];
        }
    }

    private function createData($mode)
    {
        switch ($mode) {
            case "kelompok":
            case "subkelompok":
                KelompokMapel::create([
                    'kategori'      => $this->kategori,
                    'kode_kelompok' => $this->kode_kelompok,
                    'nama_kelompok' => $this->nama_kelompok,
                    'id_parent'     => $this->id_parent,
                ]);
                break;
            case "mapel":
                ModelsMataPelajaran::create([
                    'id_kelompok' => $this->id_kelompok,
                    'nama_mapel'  => $this->nama_mapel,
                    'kode_mapel'  => $this->kode_mapel,
                    'status'      => $this->status ?? '1',
                    'no_urut'     => $this->no_urut,
                ]);
                break;
        }
    }

    public function edit($id, $mode)
    {
        $this->isEditing = true;
        $this->dataId = $id;
        if ($mode == "kelompok") {
            $data = KelompokMapel::findOrFail($id);
            $this->kategori  = $data->kategori;
            $this->kode_kelompok  = $data->kode_kelompok;
            $this->nama_kelompok  = $data->nama_kelompok;
            $this->id_parent  = $data->id_parent;
        } else if ($mode == "mapel") {
            $data = ModelsMataPelajaran::findOrFail($id);
            $this->id_kelompok  = $data->id_kelompok;
            $this->nama_mapel  = $data->nama_mapel;
            $this->kode_mapel  = $data->kode_mapel;
            $this->no_urut  = $data->no_urut;
            $this->status  = $data->status;
        }
        $this->dispatch('initSelect2');
    }
    
    public function update($mode)
    {
        if ($this->dataId) {
            $this->validate($this->getValidationRule($mode));
    
            $this->updateData($mode);
    
            $this->dispatchAlert('success', 'Success!', 'Data updated successfully.');
            $this->isEditing = false;
            $this->dataId = null;
        }
    }

    private function updateData($mode)
    {
        $data = $this->getDataForUpdate($mode);

        switch ($mode) {
            case "kelompok":
            case "subkelompok":
                KelompokMapel::findOrFail($this->dataId)->update($data);
                break;
            case "mapel":
                ModelsMataPelajaran::findOrFail($this->dataId)->update($data);
                break;
        }
    }

    private function getDataForUpdate($mode)
    {
        switch ($mode) {
            case "kelompok":
            case "subkelompok":
                return [
                    'kategori'      => $this->kategori,
                    'kode_kelompok' => $this->kode_kelompok,
                    'nama_kelompok' => $this->nama_kelompok,
                    'id_parent'     => $this->id_parent,
                ];
            case "mapel":
                return [
                    'id_kelompok' => $this->id_kelompok,
                    'nama_mapel'  => $this->nama_mapel,
                    'kode_mapel'  => $this->kode_mapel,
                    'no_urut'     => $this->no_urut,
                ];
            default:
                return [];
        }
    }


    public function deleteConfirm($id, $mode)
    {
        $this->dataId = $id;
        $this->dispatch('swal:confirm', [
            'type'      => 'warning',  
            'message'   => 'Are you sure?', 
            'text'      => 'If you delete the data, it cannot be restored!'
        ]);
        $this->deleteMode = $mode;
    }

    public function delete()
    {
        if ($this->deleteMode == "kelompok") {
            $data = KelompokMapel::findOrFail($this->dataId);
            $id_parent = $data->id;
            KelompokMapel::where('id_parent', $id_parent)->delete(); $data->delete();
            ModelsMataPelajaran::where('id_kelompok', $id_parent)->delete(); $data->delete();
        } else if ($this->deleteMode == "subkelompok") {
            $data = KelompokMapel::findOrFail($this->dataId);
            $id_parent = $data->id; $data->delete();
            ModelsMataPelajaran::where('id_kelompok', $id_parent)->delete(); $data->delete();
        } else if ($this->deleteMode == "mapel") {
            ModelsMataPelajaran::findOrFail($this->dataId)->delete();
        }
        $this->dispatchAlert('success', 'Success!', 'Data deleted successfully.');
    }
    
    public function active($id, $mode)
    {
        $mode == "active" ? ModelsMataPelajaran::findOrFail($id)->update(['status' => '1']) : ModelsMataPelajaran::findOrFail($id)->update(['status' => '0']);
        $this->dispatchAlert('success', 'Success!', 'Status updated succesfully.');
    }
}