<?php

namespace App\Livewire\Ujian;

use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Title;
use App\Models\Ruang as ModelsRuang;

class Ruang extends Component
{
    use WithPagination;
    #[Title('Jenis Ujian')]

    protected $paginationTheme = 'bootstrap';
    protected $listeners = [
        'delete'
    ];
    protected $rules = [
        'nama_ruang' => 'required',
        'kode_ruang' => 'required',
    ];

    public $lengthData = 25;
    public $searchTerm;
    public $previousSearchTerm = '';
    public $isEditing = false;

    public $dataId, $nama_ruang, $kode_ruang;

    public function mount()
    {
        $this->nama_ruang = '';
        $this->kode_ruang = '';
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

        $data = ModelsRuang::where('nama_ruang', 'LIKE', $search)
                    ->orWhere('kode_ruang', 'LIKE', $search)
                    ->paginate($this->lengthData);

        return view('livewire.ujian.ruang', compact('data'));
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
        $this->mount();
    }

    public function cancel()
    {
        $this->resetInputFields();
    }

    public function store()
    {
        $this->validate();

        ModelsRuang::create([
            'nama_ruang'     => $this->nama_ruang,
            'kode_ruang'     => $this->kode_ruang,
        ]);

        $this->dispatchAlert('success', 'Success!', 'Data created successfully.');
    }
    
    public function edit($id)
    {
        $this->isEditing = true;
        $data = ModelsRuang::findOrFail($id);
        $this->dataId = $id;
        $this->nama_ruang  = $data->nama_ruang;
        $this->kode_ruang  = $data->kode_ruang;
    }
    
    public function update()
    {
        $this->validate();
        
        if ($this->dataId) {
            ModelsRuang::findOrFail($this->dataId)->update([
                'nama_ruang'     => $this->nama_ruang,
                'kode_ruang'     => $this->kode_ruang,
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
        ModelsRuang::findOrFail($this->dataId)->delete();
        $this->dispatchAlert('success', 'Success!', 'Data deleted successfully.');
    }
}
