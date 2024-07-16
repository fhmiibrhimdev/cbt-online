<?php

namespace App\Livewire\Umum;

use App\Models\Ekstrakurikuler as ModelsEkstrakurikuler;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Title;

class Ekstrakurikuler extends Component
{
    use WithPagination;
    #[Title('Ekstrakurikuler')]

    protected $paginationTheme = 'bootstrap';
    protected $listeners = [
        'delete'
    ];
    protected $rules = [
        'nama_ekstra' => 'required',
    ];

    public $lengthData = 25;
    public $searchTerm;
    public $previousSearchTerm = '';
    public $isEditing = false;

    public $dataId, $nama_ekstra, $kode_ekstra;

    public function mount()
    {
        $this->nama_ekstra = '';
        $this->kode_ekstra = '';
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

        $data = ModelsEkstrakurikuler::where('nama_ekstra', 'LIKE', $search)
                    ->paginate($this->lengthData);

        return view('livewire.umum.ekstrakurikuler', compact('data'));
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
        $this->nama_ekstra = '';
        $this->kode_ekstra = '';
    }

    public function cancel()
    {
        $this->resetInputFields();
    }

    public function store()
    {
        $this->validate();

        ModelsEkstrakurikuler::create([
            'nama_ekstra' => $this->nama_ekstra,
            'kode_ekstra' => $this->kode_ekstra,
        ]);

        $this->dispatchAlert('success', 'Success!', 'Data created successfully.');
    }
    
    public function edit($id)
    {
        $this->isEditing = true;
        $data = ModelsEkstrakurikuler::findOrFail($id);
        $this->dataId = $id;
        $this->nama_ekstra  = $data->nama_ekstra;
        $this->kode_ekstra  = $data->kode_ekstra;
    }
    
    public function update()
    {
        $this->validate();
        
        if ($this->dataId) {
            ModelsEkstrakurikuler::findOrFail($this->dataId)->update([
                'nama_ekstra' => $this->nama_ekstra,
                'kode_ekstra' => $this->kode_ekstra,
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
        ModelsEkstrakurikuler::findOrFail($this->dataId)->delete();
        $this->dispatchAlert('success', 'Success!', 'Data deleted successfully.');
    }
}
