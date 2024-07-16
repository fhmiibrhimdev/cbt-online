<?php

namespace App\Livewire\Umum;

use App\Models\Jurusan as ModelsJurusan;
use App\Models\KelompokMapel;
use App\Models\MataPelajaran;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Title;

class Jurusan extends Component
{
    use WithPagination;
    #[Title('Jurusan')]
    protected $paginationTheme = 'bootstrap';
    protected $listeners = [
        'delete'
    ];
    protected $rules = [
        'nama_jurusan' => 'required',
    ];

    public $lengthData = 25;
    public $searchTerm;
    public $previousSearchTerm = '';
    public $isEditing = false;

    public $dataId, $nama_jurusan, $kode_jurusan;
    public $mapel_peminatan = [];

    public function mount()
    {
        $this->nama_jurusan = '';
        $this->kode_jurusan = '';

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

        $data = ModelsJurusan::where('nama_jurusan', 'LIKE', $search)
                    ->orWhere('kode_jurusan', 'LIKE', $search)
                    ->paginate($this->lengthData);

        $kelompok_c = MataPelajaran::where('id_kelompok', '3')->get();

        $kelompoks = KelompokMapel::select('mata_pelajaran.id', 'kode_kelompok', 'nama_kelompok', 'nama_mapel')
                        ->join('mata_pelajaran', 'mata_pelajaran.id_kelompok', 'kelompok_mapel.id')
                        ->where('id_parent', '3')
                        ->get();

        return view('livewire.umum.jurusan', compact('data', 'kelompok_c', 'kelompoks'));
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
        $this->nama_jurusan = '';
        $this->kode_jurusan = '';
        $this->mapel_peminatan = [];
    }

    public function cancel()
    {
        $this->resetInputFields();
    }

    public function store()
    {
        $this->validate();

        ModelsJurusan::create([
            'nama_jurusan'      => $this->nama_jurusan,
            'kode_jurusan'      => $this->kode_jurusan,
            'mapel_peminatan'   => implode(',', $this->mapel_peminatan),
            'status'            => '1'
        ]);

        $this->dispatchAlert('success', 'Success!', 'Data created successfully.');
    }
    
    public function edit($id)
    {
        $this->isEditing = true;
        $data = ModelsJurusan::findOrFail($id);
        $this->dataId = $id;
        $this->nama_jurusan     = $data->nama_jurusan;
        $this->kode_jurusan     = $data->kode_jurusan;
        $this->mapel_peminatan  = explode(',', $data->mapel_peminatan);
        $this->dispatch('initSelect2');
    }
    
    public function update()
    {
        $this->validate();
        
        if ($this->dataId) {
            ModelsJurusan::findOrFail($this->dataId)->update([
                'nama_jurusan'      => $this->nama_jurusan,
                'kode_jurusan'      => $this->kode_jurusan,
                'mapel_peminatan'   => implode(',', $this->mapel_peminatan),
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
            'message'   => 'Are you sure?', 
            'text'      => 'If you delete the data, it cannot be restored!'
        ]);
    }

    public function delete()
    {
        ModelsJurusan::findOrFail($this->dataId)->delete();
        $this->dispatchAlert('success', 'Success!', 'Data deleted successfully.');
    }
}
