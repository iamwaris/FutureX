<?php

namespace Database\Seeders;

use App\Models\Sponsor;
use Illuminate\Database\Seeder;

class SponsorSeeder extends Seeder
{
    public function run(): void
    {
        $sponsors = [
            [
                'name' => 'Aurora Gear',
                'website_url' => 'https://example.com/aurora-gear',
                'case_study' => 'A 3-month integration campaign featuring co-branded stream overlays and a dedicated unboxing stream.',
                'campaign_highlights' => '1.2M impressions, 40K click-throughs, 3x campaign ROI target.',
                'testimonial_quote' => 'The campaign outperformed every other creator partnership we ran that quarter — professional from the first email to the final report.',
                'testimonial_author' => 'Marketing Lead, Aurora Gear',
                'is_featured' => true,
            ],
            ['name' => 'Nimbus Energy', 'is_featured' => true],
            ['name' => 'Voidline PC', 'is_featured' => true],
            ['name' => 'Fabled Apparel', 'is_featured' => true],
            ['name' => 'Cortex Audio', 'is_featured' => true],
            ['name' => 'Halcyon Media', 'is_featured' => true],
        ];

        foreach ($sponsors as $index => $sponsor) {
            Sponsor::query()->updateOrCreate(
                ['name' => $sponsor['name']],
                [...$sponsor, 'order' => $index],
            );
        }
    }
}
