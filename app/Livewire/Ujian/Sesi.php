<?php

namespace App\Livewire\Ujian;

use App\Models\Sesi as ModelsSesi;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Title;

class Sesi extends Component
{
    use WithPagination;
    #[Title('Sesi')]

    protected $paginationTheme = 'bootstrap';
    protected $listeners = [
        'delete'
    ];
    protected $rules = [
        'nama_sesi' => 'required',
        'kode_sesi' => 'required',
        'waktu_mulai' => 'required',
        'waktu_akhir' => 'required',
    ];

    public $lengthData = 25;
    public $searchTerm;
    public $previousSearchTerm = '';
    public $isEditing = false;

    public $dataId, $nama_sesi, $kode_sesi, $waktu_mulai, $waktu_akhir;

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

        $data = ModelsSesi::where('nama_sesi', 'LIKE', $search)
                    ->orWhere('kode_sesi', 'LIKE', $search)
                    ->paginate($this->lengthData);

        return view('livewire.ujian.sesi', compact('data'));
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
        $this->nama_sesi = '';
        $this->kode_sesi = '';
        $this->waktu_mulai = '';
        $this->waktu_akhir = '';
    }

    public function cancel()
    {
        $this->resetInputFields();
    }

    public function store()
    {
        $this->validate();

        ModelsSesi::create([
            'nama_sesi'     => $this->nama_sesi,
            'kode_sesi'     => $this->kode_sesi,
            'waktu_mulai'     => $this->waktu_mulai,
            'waktu_akhir'     => $this->waktu_akhir,
        ]);

        $this->dispatchAlert('success', 'Success!', 'Data created successfully.');
    }
    
    public function edit($id)
    {
        $this->isEditing = true;
        $data = ModelsSesi::findOrFail($id);
        $this->dataId = $id;
        $this->nama_sesi  = $data->nama_sesi;
        $this->kode_sesi  = $data->kode_sesi;
        $this->waktu_mulai  = $data->waktu_mulai;
        $this->waktu_akhir  = $data->waktu_akhir;
    }
    
    public function update()
    {
        $this->validate();
        
        if ($this->dataId) {
            ModelsSesi::findOrFail($this->dataId)->update([
                'nama_sesi'     => $this->nama_sesi,
                'kode_sesi'     => $this->kode_sesi,
                'waktu_mulai'     => $this->waktu_mulai,
                'waktu_akhir'     => $this->waktu_akhir,
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
        ModelsSesi::findOrFail($this->dataId)->delete();
        $this->dispatchAlert('success', 'Success!', 'Data deleted successfully.');
    }
}
