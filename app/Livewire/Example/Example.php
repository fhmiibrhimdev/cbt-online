<?php

namespace App\Livewire\Example;

use App\Models\Todo;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithPagination;

class Example extends Component
{
    use WithPagination;
    #[Title('Example')]

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

        $data = Todo::where('title', 'LIKE', $search)
                    ->paginate($this->lengthData);

        return view('livewire.example.example', compact('data'));
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
        $this->title = '';
    }

    public function cancel()
    {
        $this->resetInputFields();
    }

    public function store()
    {
        $this->validate();

        Todo::create([
            'title'     => $this->title,
        ]);

        $this->dispatchAlert('success', 'Success!', 'Data created successfully.');
    }
    
    public function edit($id)
    {
        $this->isEditing = true;
        $data = Todo::findOrFail($id);
        $this->dataId = $id;
        $this->title  = $data->title;
    }
    
    public function update()
    {
        $this->validate();
        
        if ($this->dataId) {
            Todo::findOrFail($this->dataId)->update([
                'title' => $this->title,
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
        Todo::findOrFail($this->dataId)->delete();
        $this->dispatchAlert('success', 'Success!', 'Data deleted successfully.');
    }
}
