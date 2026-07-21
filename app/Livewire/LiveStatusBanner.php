<?php

namespace App\Livewire;

use App\Livewire\Concerns\ReadsLiveStatus;
use Livewire\Component;

class LiveStatusBanner extends Component
{
    use ReadsLiveStatus;

    public function render()
    {
        return view('livewire.live-status-banner', [
            'status' => $this->liveStatus(),
        ]);
    }
}
