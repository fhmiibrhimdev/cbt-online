<?php

namespace App\Livewire\Pengaturan;

use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;
use App\Helpers\GlobalHelper;
use Livewire\Attributes\Title;

class Siswa extends Component
{
    use WithPagination;
    #[Title('Pengaturan Siswa')]

    public $lengthData = 25;
    public $searchTerm;
    public $previousSearchTerm = '';
    public $dataId;

    public $where = 'siswa';
    public $id_tp, $id_smt;

    public function mount()
    {
        $this->id_tp    = GlobalHelper::getActiveTahunPelajaranId();
        $this->id_smt   = GlobalHelper::getActiveSemesterId();
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

        $data = User::select('users.id', 'users.name', 'users.email', 'roles.name as role_name', 'users.active')
            ->where(function ($query) use ($search) {
                $query->where('users.name', 'LIKE', $search);
            })
            ->where('roles.name', $this->where)
            ->join('role_user', 'role_user.user_id', 'users.id')
            ->join('roles', 'roles.id', 'role_user.role_id')
            ->join('siswa', 'siswa.id_user', 'users.id')
            ->where('siswa.id_tp', $this->id_tp)
            ->paginate($this->lengthData);

        return view('livewire.pengaturan.siswa', compact('data'));
    }

    public function status($id, $active)
    {
        User::where('id', $id)->update(['active' => $active]);
    }

    public function statusAll($active)
    {
        User::join('role_user', 'users.id', 'role_user.user_id')
            ->join('roles', 'roles.id', 'role_user.role_id')
            ->join('siswa', 'siswa.id_user', 'users.id')
            ->where([
                ['roles.name', $this->where],
                ['siswa.id_tp', $this->id_tp],
            ])
            ->update(['users.active' => $active]);
    }
}
