<?php

namespace Database\Seeders;

use App\Models\CommunityLink;
use Illuminate\Database\Seeder;

class CommunityLinkSeeder extends Seeder
{
    public function run(): void
    {
        $links = [
            ['platform' => 'discord', 'label' => 'Discord', 'stat_label' => '15,200 members', 'url' => '#', 'is_primary' => true],
            ['platform' => 'youtube', 'label' => 'YouTube', 'stat_label' => '128,400 subscribers', 'url' => '#', 'is_primary' => false],
            ['platform' => 'tiktok', 'label' => 'TikTok', 'stat_label' => '61,300 followers', 'url' => '#', 'is_primary' => false],
            ['platform' => 'x', 'label' => 'X', 'stat_label' => '42,100 followers', 'url' => '#', 'is_primary' => false],
            ['platform' => 'instagram', 'label' => 'Instagram', 'stat_label' => '28,900 followers', 'url' => '#', 'is_primary' => false],
            ['platform' => 'reddit', 'label' => 'Reddit', 'stat_label' => '3,800 members', 'url' => '#', 'is_primary' => false],
        ];

        foreach ($links as $index => $link) {
            CommunityLink::query()->updateOrCreate(
                ['platform' => $link['platform']],
                [...$link, 'order' => $index],
            );
        }
    }
}
