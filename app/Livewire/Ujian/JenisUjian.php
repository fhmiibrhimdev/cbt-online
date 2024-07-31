<?php

namespace App\Livewire\Ujian;

use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Title;
use App\Models\JenisUjian as ModelsJenisUjian;

class JenisUjian extends Component
{
    use WithPagination;
    #[Title('Jenis Ujian')]

    protected $paginationTheme = 'bootstrap';
    protected $listeners = [
        'delete'
    ];
    protected $rules = [
        'nama_jenis' => 'required',
        'kode_jenis' => 'required',
    ];

    public $lengthData         = 25;
    public $searchTerm;
    public $previousSearchTerm = '';
    public $isEditing          = false;

    public $dataId, $nama_jenis, $kode_jenis;

    public function mount()
    {
        $this->nama_jenis = '';
        $this->kode_jenis = '';
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

        $data   = ModelsJenisUjian::where('nama_jenis', 'LIKE', $search)
            ->orWhere('kode_jenis', 'LIKE', $search)
            ->paginate($this->lengthData);

        return view('livewire.ujian.jenis-ujian', compact('data'));
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

        ModelsJenisUjian::create([
            'nama_jenis' => $this->nama_jenis,
            'kode_jenis' => $this->kode_jenis,
        ]);

        $this->dispatchAlert('success', 'Success!', 'Data created successfully.');
    }

    public function edit($id)
    {
        $this->isEditing  = true;
        $data             = ModelsJenisUjian::findOrFail($id);
        $this->dataId     = $id;
        $this->nama_jenis = $data->nama_jenis;
        $this->kode_jenis = $data->kode_jenis;
    }

    public function update()
    {
        $this->validate();

        if ($this->dataId) {
            ModelsJenisUjian::findOrFail($this->dataId)->update([
                'nama_jenis' => $this->nama_jenis,
                'kode_jenis' => $this->kode_jenis,
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
        ModelsJenisUjian::findOrFail($this->dataId)->delete();
        $this->dispatchAlert('success', 'Success!', 'Data deleted successfully.');
    }
}
