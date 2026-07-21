<?php

namespace Tests\Feature;

use App\Models\PageSection;
use App\Models\PageView;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PageViewTrackingTest extends TestCase
{
    use RefreshDatabase;

    public function test_visiting_a_real_page_logs_a_page_view(): void
    {
        $this->seed(\Database\Seeders\PageSectionSeeder::class);

        $this->assertSame(0, PageView::count());

        $this->get('/')->assertOk();

        $this->assertSame(1, PageView::count());
        $this->assertSame('/', PageView::first()->path);
    }

    public function test_theme_css_endpoint_is_not_logged_as_a_page_view(): void
    {
        $this->get('/theme.css')->assertOk();

        $this->assertSame(0, PageView::count());
    }
}
