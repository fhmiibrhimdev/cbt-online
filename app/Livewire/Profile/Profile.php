<?php

namespace App\Livewire\Profile;

use App\Models\User;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Livewire\Attributes\Title;

class Profile extends Component
{
    #[Title('Setting Profile')]
    
    public $name, $email, $password, $current_password, $password_confirmation;

    public function mount()
    {
        $user = Auth::user();

        $this->name = $user->name;
        $this->email = $user->email;
    }

    public function render()
    {
        return view('livewire.profile.profile');
    }

    private function dispatchAlert($type, $message, $text)
    {
        $this->dispatch('swal:modal', [
            'type'      => $type,  
            'message'   => $message, 
            'text'      => $text
        ]);
    }

    public function updateProfile()
    {
        $this->validate([
            'name'      => 'required',
            'email'     => 'required|email'
        ]);

        $data   = User::findOrFail(Auth::user()->id);
        $data->update([
            'name'  => $this->name,
            'email' => $this->email,
        ]);
        $this->dispatchAlert('success', 'Success!', 'Profile updated successfully.');
    }

    public function updatePassword()
    {
        $this->validate([
            'current_password'  => 'required',
            'password'          => 'required'
        ]);
        
        $user   = User::findOrFail(Auth::user()->id);

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
}
