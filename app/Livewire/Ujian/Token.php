<?php

namespace App\Livewire\Ujian;

use Carbon\Carbon;
use App\Models\Token as ModelsToken;
use Livewire\Component;
use Illuminate\Support\Str;
use Livewire\Attributes\Title;

class Token extends Component
{
    #[Title('Token')]

    public $auto = 'T';
    public $jarak = 30;
    public $currentToken;
    public $tokenUpdatedAt;

    protected $listeners = [
        'startAutoRefresh'
    ];

    protected $rules = [
        'auto'  => 'required|in:Y,T',
        'jarak' => 'required|integer|min:1',
    ];

    public function mount()
    {
        $token = ModelsToken::first();
        if ($token) {
            $this->currentToken   = $token->token;
            $this->tokenUpdatedAt = $token->updated_at;
            $this->auto           = $token->auto;
            $this->jarak          = $token->jarak;
        } else {
            $this->currentToken   = 'Tidak Ada Token';
            $this->tokenUpdatedAt = Carbon::now();
        }

        if ($this->auto == 'Y') {
            $this->dispatch('start-interval', ['interval' => $this->jarak * 60 * 1000, 'updatedAt' => $this->tokenUpdatedAt]);
        }
    }

    public function updatedAuto()
    {
        if ($this->auto == 'Y') {
            $this->startAutoRefresh();
        }
    }

    public function startAutoRefresh()
    {
        $newToken = strtoupper(Str::random(6)); // Sesuaikan panjang token sesuai kebutuhan
        $token = ModelsToken::updateOrCreate(
            ['id'    => 1], // Assuming you have only one token entry
            ['token' => $newToken, 'auto' => $this->auto, 'jarak' => $this->jarak]
        );

        $this->currentToken = $token->token;
        $this->tokenUpdatedAt = $token->updated_at;

        if ($this->auto == 'Y') {
            $this->dispatch('start-interval', ['interval' => $this->jarak * 60 * 1000, 'updatedAt' => $this->tokenUpdatedAt]);
        }
    }

    public function generateNewToken()
    {
        $newToken = strtoupper(Str::random(6)); // Sesuaikan panjang token sesuai kebutuhan
        $token = ModelsToken::updateOrCreate(
            ['id'    => 1], // Assuming you have only one token entry
            ['token' => $newToken, 'auto' => 'T', 'jarak' => $this->jarak]
        );

        $this->currentToken = $token->token;
        $this->tokenUpdatedAt = $token->updated_at;

        if ($this->auto == 'Y') {
            return redirect()->route('token');
        }

        // if ($this->auto == 'Y') {
        //     // $this->dispatch('start-interval', ['interval' => $this->jarak * 60 * 1000, 'updatedAt' => $this->tokenUpdatedAt]);
        // } else if ($this->auto == 'T') {
        $this->dispatch('init-toggle-jarak');
        // }
    }

    public function save()
    {
        $this->validate();

        if ($this->auto == 'Y') {
            $this->startAutoRefresh();
        } else {
            ModelsToken::updateOrCreate(
                ['id'    => 1],
                ['token' => $this->currentToken, 'auto' => $this->auto, 'jarak' => $this->jarak]
            );
        }
    }

    public function render()
    {
        return view('livewire.ujian.token');
    }
}
