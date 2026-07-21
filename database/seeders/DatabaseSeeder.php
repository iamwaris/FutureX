<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(PageSectionSeeder::class);
        $this->call(CommunityLinkSeeder::class);
        $this->call(SnapshotStatSeeder::class);
        $this->call(SponsorSeeder::class);
        $this->call(MediaKitSeeder::class);
        $this->call(CreatorModeSeeder::class);
    }
}
