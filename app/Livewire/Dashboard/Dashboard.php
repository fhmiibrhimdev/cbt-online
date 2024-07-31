<?php

namespace App\Livewire\Dashboard;

use App\Models\User;
use Livewire\Component;
use Livewire\Attributes\Title;
use Illuminate\Support\Facades\Auth;

class Dashboard extends Component
{
    #[Title('Dashboard')]

    public function render()
    {
        $user = User::find(Auth::user()->id);

        if ($user->hasRole('administrator')) {
            return view('livewire.dashboard.dashboard-admin');
        } else if ($user->hasRole('guru')) {
            return view('livewire.dashboard.dashboard-guru');
        } else if ($user->hasRole('siswa')) {
            return view('livewire.dashboard.dashboard-siswa');
        }
    }
}
