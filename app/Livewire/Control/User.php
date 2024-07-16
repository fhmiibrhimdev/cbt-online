<?php

namespace App\Livewire\Control;

use App\Models\User as ModelsUser;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Title;

class User extends Component
{
    use WithPagination;
    #[Title('Example')]

    protected $paginationTheme = 'bootstrap';
    protected $listeners = [
        'delete'
    ];
    protected $rules = [
        'title' => 'required',
    ];

    public $lengthData = 25;
    public $searchTerm;
    public $previousSearchTerm = '';
    public $isEditing = false;

    public $dataId, $title;

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

        $data = ModelsUser::select('id', 'name', 'email', 'active')
                    ->where('name', 'LIKE', $search)
                    ->paginate($this->lengthData);

        return view('livewire.control.user', compact('data'));
    }

    public function status($id, $active)
    {
        ModelsUser::where('id', $id)->update(['active' => $active]);
    }
}
