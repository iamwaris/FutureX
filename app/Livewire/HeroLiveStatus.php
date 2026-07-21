<?php

namespace App\Livewire;

use App\Livewire\Concerns\ReadsLiveStatus;
use Livewire\Component;

class HeroLiveStatus extends Component
{
    use ReadsLiveStatus;

    public function render()
    {
        return view('livewire.hero-live-status', [
            'status' => $this->liveStatus(),
        ]);
    }
}
