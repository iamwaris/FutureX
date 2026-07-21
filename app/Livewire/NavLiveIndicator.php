<?php

namespace App\Livewire;

use App\Livewire\Concerns\ReadsLiveStatus;
use Livewire\Component;

class NavLiveIndicator extends Component
{
    use ReadsLiveStatus;

    public function render()
    {
        return view('livewire.nav-live-indicator', [
            'status' => $this->liveStatus(),
        ]);
    }
}
