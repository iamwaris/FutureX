<?php

namespace App\Console\Commands;

use App\Models\SnapshotStat;
use App\Services\LiveStatus\YouTubeLiveService;
use Illuminate\Console\Command;

class SyncSnapshotStats extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'snapshot-stats:sync';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Pull Snapshot stats from YouTube/Twitch APIs where auto-sync is enabled';

    /**
     * Execute the console command.
     */
    public function handle(YouTubeLiveService $youTube): int
    {
        $stats = SnapshotStat::current();
        $updates = [];

        if ($stats->sync_subscribers_from_youtube || $stats->sync_total_views_from_youtube || $stats->sync_videos_from_youtube) {
            $channelStats = $youTube->fetchChannelStatistics();

            if ($channelStats) {
                if ($stats->sync_subscribers_from_youtube && isset($channelStats['subscriberCount'])) {
                    $updates['subscribers'] = (int) $channelStats['subscriberCount'];
                }

                if ($stats->sync_total_views_from_youtube && isset($channelStats['viewCount'])) {
                    $updates['total_views'] = (int) $channelStats['viewCount'];
                }

                if ($stats->sync_videos_from_youtube && isset($channelStats['videoCount'])) {
                    $updates['videos_published'] = (int) $channelStats['videoCount'];
                }
            } else {
                $this->warn('YouTube sync enabled but no channel statistics were returned — check credentials under Integrations.');
            }
        }

        if ($stats->sync_followers_from_twitch) {
            // Twitch's public follower count needs a user access token with
            // the moderator:read:followers scope — the app access token
            // (client_credentials) this project uses for live-status
            // polling isn't sufficient. Flagging clearly rather than
            // silently doing nothing or faking a number.
            $this->warn('Twitch follower auto-sync is enabled but not yet implemented — it requires user OAuth (moderator:read:followers), not just an app access token. Enter followers manually for now.');
        }

        if ($updates) {
            $updates['last_synced_at'] = now();
            $stats->update($updates);
            $this->info('Synced: '.implode(', ', array_keys($updates)));
        } else {
            $this->info('Nothing to sync.');
        }

        return self::SUCCESS;
    }
}
