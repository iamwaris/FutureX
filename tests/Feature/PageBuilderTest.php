<?php

namespace Tests\Feature;

use App\Models\PageSection;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PageBuilderTest extends TestCase
{
    use RefreshDatabase;

    public function test_disabling_a_section_removes_it_from_the_homepage(): void
    {
        $this->seed(\Database\Seeders\PageSectionSeeder::class);

        $this->get('/')->assertSee('id="sponsors"', false);

        PageSection::query()->where('key', 'sponsors')->update(['is_enabled' => false]);

        $this->get('/')->assertDontSee('id="sponsors"', false);
    }

    public function test_reordering_sections_changes_render_order(): void
    {
        $this->seed(\Database\Seeders\PageSectionSeeder::class);

        // Schedule normally renders after Featured Content.
        $before = $this->get('/')->getContent();
        $this->assertTrue(
            strpos($before, 'id="featured-content"') < strpos($before, 'id="schedule"'),
            'Expected Featured Content to render before Schedule by default.',
        );

        $scheduleOrder = PageSection::query()->where('key', 'schedule')->value('order');
        PageSection::query()->where('key', 'featured-content')->update(['order' => $scheduleOrder + 1]);
        PageSection::query()->where('key', 'schedule')->update(['order' => $scheduleOrder - 1]);

        $after = $this->get('/')->getContent();
        $this->assertTrue(
            strpos($after, 'id="schedule"') < strpos($after, 'id="featured-content"'),
            'Expected Schedule to render before Featured Content after reordering.',
        );
    }
}
