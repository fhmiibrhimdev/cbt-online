<?php

namespace App\Livewire\Pengaturan;

use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Title;
use Illuminate\Validation\Rules;
use Illuminate\Support\Facades\Hash;

class Administrator extends Component
{
    use WithPagination;
    #[Title('Pengaturan Administrator')]

    protected $listeners = [
        'delete'
    ];

    public $lengthData = 25;
    public $searchTerm;
    public $previousSearchTerm = '';
    public $isEditing = false, $locked = false;

    public $name, $email, $current_password, $password, $password_confirmation;

    public $dataId, $title;

    public function mount()
    {
        $this->name                  = '';
        $this->email                 = '';
        $this->password              = '';
        $this->password_confirmation = '';
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

        $data = User::select('users.id', 'users.name', 'users.email', 'roles.name as role_name')
            ->where(function ($query) use ($search) {
                $query->where('users.name', 'LIKE', $search);
            })
            ->where('roles.name', 'administrator')
            ->join('role_user', 'role_user.user_id', 'users.id')
            ->join('roles', 'roles.id', 'role_user.role_id')
            ->paginate($this->lengthData);

        return view('livewire.pengaturan.administrator', compact('data'));
    }

    private function dispatchAlert($type, $message, $text)
    {
        $this->dispatch('swal:modal', [
            'type'      => $type,
            'message'   => $message,
            'text'      => $text
        ]);
    }

    public function isEditingMode($mode)
    {
        $this->isEditing = $mode;
    }

    private function resetInputFields()
    {
        $this->name                  = '';
        $this->email                 = '';
        $this->password              = '';
        $this->password_confirmation = '';
    }

    public function cancel()
    {
        $this->resetInputFields();
    }

    public function store()
    {
        $this->validate([
            'name'     => ['required', 'string', 'max:255'],
            'email'    => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $user = User::create([
            'name'     => $this->name,
            'email'    => $this->email,
            'password' => Hash::make($this->password),
            'active'   => 'administrator' == "administrator" ? '1' : '0'
        ]);

        $user->addRole('administrator');

        $this->dispatchAlert('success', 'Success!', 'Data created successfully.');
        $this->resetInputFields();

        $this->isEditing = false;
        $this->locked    = false;
    }

    public function edit($id)
    {
        $this->isEditing = true;
        $this->locked    = false;
        $data            = User::findOrFail($id);
        $this->dataId    = $id;
        $this->name      = $data->name;
        $this->email     = $data->email;
    }

    public function lock($id)
    {
        $this->isEditing = true;
        $this->locked    = true;
        $data            = User::findOrFail($id);
        $this->dataId    = $id;
        $this->name      = $data->name;
        $this->email     = $data->email;
    }

    public function update()
    {
        $this->validate([
            'name'  => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255'],
        ]);

        if ($this->dataId) {
            User::findOrFail($this->dataId)->update([
                'name'  => $this->name,
                'email' => $this->email,
            ]);

            $this->dispatchAlert('success', 'Berhasil!', 'Data berhasil diupdate.');
            $this->dataId = null;
        }
    }

    public function updateLock()
    {
        $this->validate([
            'current_password'  => 'required',
            'password'          => 'required'
        ]);

        $user   = User::findOrFail($this->dataId);

        if (!Hash::check($this->current_password, $user->password)) {
            $this->dispatchAlert('warning', 'Alert!', 'Current password is incorrect.');
        } else if ($this->password !== $this->password_confirmation) {
            $this->dispatchAlert('warning', 'Alert!', 'Password and confirmation password doesn\'t match!.');
        } else {
            $user->password = Hash::make($this->password);
            $user->save();

            $this->dispatchAlert('success', 'Success!', 'Password updated successfully.');
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
        User::findOrFail($this->dataId)->delete();
        $this->dispatchAlert('success', 'Success!', 'Data deleted successfully.');
    }
}
