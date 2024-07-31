<?php

namespace App\Livewire\Pengaturan;

use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Title;

class Guru extends Component
{
    use WithPagination;
    #[Title('Pengaturan Guru')]

    public $lengthData = 25;
    public $searchTerm;
    public $previousSearchTerm = '';
    public $dataId;

    public $where = 'guru';

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

        $data = User::select('users.id', 'users.name', 'users.email', 'roles.name as role_name', 'users.active')
            ->where(function ($query) use ($search) {
                $query->where('users.name', 'LIKE', $search);
            })
            ->where('roles.name', $this->where)
            ->join('role_user', 'role_user.user_id', 'users.id')
            ->join('roles', 'roles.id', 'role_user.role_id')
            ->paginate($this->lengthData);

        return view('livewire.pengaturan.guru', compact('data'));
    }

    public function status($id, $active)
    {
        User::where('id', $id)->update(['active' => $active]);
    }

    public function statusAll($active)
    {
        User::join('role_user', 'users.id', 'role_user.user_id')
            ->join('roles', 'roles.id', 'role_user.role_id')
            ->where('roles.name', $this->where)
            ->update(['users.active' => $active]);
    }
}
