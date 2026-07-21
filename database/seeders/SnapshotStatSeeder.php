<?php

namespace Database\Seeders;

use App\Models\SnapshotStat;
use Illuminate\Database\Seeder;

class SnapshotStatSeeder extends Seeder
{
    public function run(): void
    {
        SnapshotStat::current()->update([
            'followers' => 128400,
            'subscribers' => 4200,
            'total_views' => 18500000,
            'years_creating' => 6,
            'videos_published' => 940,
            'community_members' => 15200,
        ]);
    }
}
