<?php

namespace App\Livewire\Concerns;

use App\Services\LiveStatus\LiveStatusManager;
use App\Services\LiveStatus\LiveStreamStatus;

trait ReadsLiveStatus
{
    protected function liveStatus(): LiveStreamStatus
    {
        return app(LiveStatusManager::class)->current();
    }
}
