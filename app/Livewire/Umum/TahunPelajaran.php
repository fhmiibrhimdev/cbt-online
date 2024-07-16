<?php

namespace App\Livewire\Umum;

use Livewire\Component;
use App\Models\Semester;
use Livewire\WithPagination;
use Livewire\Attributes\Title;
use Illuminate\Support\Facades\DB;
use App\Models\TahunPelajaran as ModelsTahunPelajaran;

class TahunPelajaran extends Component
{
    use WithPagination;
    #[Title('Tahun Pelajaran')]

    protected $listeners = [
        'delete'
    ];

    protected $rules = [
        'tahun'               => 'required|unique:tahun_pelajaran',
    ];

    public $lengthData = 25;
    public $searchTerm;
    public $previousSearchTerm = '';
    public $isEditing = false;

    public $dataId;

    public $tahun;

    public function mount()
    {
        $this->tahun               = '';
    }

    public function render()
    {
        $this->searchResetPage();
        $search = '%'.$this->searchTerm.'%';

        $tahun_pelajarans = ModelsTahunPelajaran::select('tahun_pelajaran.*')
                ->where(function ($query) use ($search) {
                    $query->where('tahun', 'LIKE', $search);
                })
                ->orderBy('id', 'ASC')
                ->paginate($this->lengthData);

        $semesters = Semester::get();

        return view('livewire.umum.tahun-pelajaran', compact('tahun_pelajarans', 'semesters'));
    }

    public function active($id, $kategori)
    {
        if ($kategori == "semester") {
            Semester::query()->update(['active' => '0']);
            Semester::findOrFail($id)->update(['active' => '1']);
        } else if ($kategori == "tahun_pelajaran") {
            ModelsTahunPelajaran::query()->update(['active' => '0']);
            ModelsTahunPelajaran::findOrFail($id)->update(['active' => '1']);
        }
    }

    public function store()
    {
        $this->validate();

        ModelsTahunPelajaran::create([
            'tahun'               => $this->tahun,
        ]);

        $this->dispatchAlert('success', 'Success!', 'Data created successfully.');
    }

    public function edit($id)
    {
        $this->isEditing        = true;
        $data = ModelsTahunPelajaran::where('id', $id)->first();
        $this->dataId           = $id;
        $this->tahun            = $data->tahun;
    }

    public function update()
    {
        $this->validate();

        if( $this->dataId )
        {
            ModelsTahunPelajaran::findOrFail($this->dataId)->update([
                'tahun'               => $this->tahun,
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
        ModelsTahunPelajaran::findOrFail($this->dataId)->delete();
        $this->dispatchAlert('success', 'Success!', 'Data deleted successfully.');
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
        $this->tahun               = '';
    }

    public function cancel()
    {
        $this->isEditing       = false;
        $this->resetInputFields();
    }
}