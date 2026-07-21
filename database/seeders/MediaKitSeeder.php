<?php

namespace Database\Seeders;

use App\Models\MediaKit;
use Illuminate\Database\Seeder;

class MediaKitSeeder extends Seeder
{
    public function run(): void
    {
        MediaKit::current()->update([
            'bio' => 'Full-time streamer and content creator building a business around games, community, and genuine partnerships. Six years in, still growing.',
            'brand_values' => ['Authenticity', 'Competitive Excellence', 'Community First'],
            'avg_viewers' => 3200,
            'peak_viewers' => 9800,
            'monthly_impressions' => 4200000,
            'age_ranges' => [
                ['label' => '13-17', 'percentage' => 8],
                ['label' => '18-24', 'percentage' => 42],
                ['label' => '25-34', 'percentage' => 35],
                ['label' => '35+', 'percentage' => 15],
            ],
            'gender_distribution' => [
                ['label' => 'Male', 'percentage' => 68],
                ['label' => 'Female', 'percentage' => 29],
                ['label' => 'Other', 'percentage' => 3],
            ],
            'languages' => [
                ['label' => 'English', 'percentage' => 74],
                ['label' => 'Spanish', 'percentage' => 12],
                ['label' => 'Portuguese', 'percentage' => 8],
                ['label' => 'Other', 'percentage' => 6],
            ],
            'geographic_breakdown' => [
                ['label' => 'United States', 'percentage' => 48],
                ['label' => 'United Kingdom', 'percentage' => 14],
                ['label' => 'Canada', 'percentage' => 10],
                ['label' => 'Brazil', 'percentage' => 7],
                ['label' => 'Other', 'percentage' => 21],
            ],
        ]);
    }
}
