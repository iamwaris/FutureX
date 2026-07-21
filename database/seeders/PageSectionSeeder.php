<?php

namespace Database\Seeders;

use App\Models\PageSection;
use Illuminate\Database\Seeder;

class PageSectionSeeder extends Seeder
{
    /**
     * Matches the section partials in resources/views/sections/*.blade.php —
     * the "key" is the include name, "label" is what shows in the Filament
     * Page Builder.
     */
    public function run(): void
    {
        $sections = [
            ['key' => 'hero', 'label' => 'Hero'],
            ['key' => 'live-status', 'label' => 'Live Status'],
            ['key' => 'snapshot', 'label' => 'Creator Snapshot'],
            ['key' => 'featured-content', 'label' => 'Featured Content'],
            ['key' => 'about', 'label' => 'About'],
            ['key' => 'schedule', 'label' => 'Stream Schedule'],
            ['key' => 'community', 'label' => 'Community Hub'],
            ['key' => 'sponsors', 'label' => 'Sponsors'],
            ['key' => 'shop', 'label' => 'Shop'],
            ['key' => 'newsletter', 'label' => 'Newsletter'],
        ];

        foreach ($sections as $index => $section) {
            PageSection::query()->updateOrCreate(
                ['key' => $section['key']],
                ['label' => $section['label'], 'order' => $index, 'is_enabled' => true],
            );
        }
    }
}
