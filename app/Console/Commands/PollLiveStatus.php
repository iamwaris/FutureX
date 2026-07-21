<?php

namespace App\Console\Commands;

use App\Services\LiveStatus\LiveStatusManager;
use Illuminate\Console\Command;

class PollLiveStatus extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'live-status:poll';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Poll configured streaming platforms and cache the current live status';

    /**
     * Execute the console command.
     */
    public function handle(LiveStatusManager $manager): int
    {
        $status = $manager->refresh();

        $this->info($status->isLive
            ? "Live on {$status->platform}: {$status->title}"
            : 'Offline.');

        return self::SUCCESS;
    }
}
