<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SnapshotStat extends Model
{
    protected $fillable = [
        'followers',
        'subscribers',
        'total_views',
        'years_creating',
        'videos_published',
        'community_members',
        'sync_followers_from_twitch',
        'sync_subscribers_from_youtube',
        'sync_total_views_from_youtube',
        'sync_videos_from_youtube',
        'last_synced_at',
    ];

    protected function casts(): array
    {
        return [
            'sync_followers_from_twitch' => 'boolean',
            'sync_subscribers_from_youtube' => 'boolean',
            'sync_total_views_from_youtube' => 'boolean',
            'sync_videos_from_youtube' => 'boolean',
            'last_synced_at' => 'datetime',
        ];
    }

    /**
     * Single active row, same pattern as ThemeSetting::current() — and for
     * the same reason, refresh() after a firstOrCreate() create-path so the
     * unsigned-int/boolean column defaults aren't left null in memory.
     */
    public static function current(): self
    {
        $instance = static::query()->firstOrCreate(['id' => 1]);

        if ($instance->wasRecentlyCreated) {
            $instance->refresh();
        }

        return $instance;
    }
}
