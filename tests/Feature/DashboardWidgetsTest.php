<?php

namespace Tests\Feature;

use App\Filament\Widgets\DashboardStatsOverview;
use App\Filament\Widgets\RecentInquiries;
use App\Models\BusinessInquiry;
use App\Models\PageView;
use App\Models\ProductClick;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class DashboardWidgetsTest extends TestCase
{
    use RefreshDatabase;

    public function test_stats_overview_reflects_real_traffic_and_click_data(): void
    {
        $this->actingAs(User::factory()->create());

        PageView::create(['path' => '/', 'viewed_at' => now()]);
        PageView::create(['path' => '/shop', 'viewed_at' => now()]);
        PageView::create(['path' => '/old', 'viewed_at' => now()->subDays(30)]); // outside 7-day window

        ProductClick::create(['product_name' => 'Hoodie', 'destination_url' => '#', 'clicked_at' => now()]);

        BusinessInquiry::factory()->create(['campaign_type' => 'sponsorship', 'is_read' => false]);
        BusinessInquiry::factory()->create(['campaign_type' => 'other', 'is_read' => true]);

        Livewire::test(DashboardStatsOverview::class)
            ->assertSee('2') // 7-day traffic count
            ->assertSee('1'); // merch clicks / unread inquiries / sponsor requests all happen to be 1
    }

    public function test_recent_inquiries_widget_lists_submitted_inquiries(): void
    {
        $this->actingAs(User::factory()->create());

        BusinessInquiry::factory()->create(['name' => 'Jamie Sponsor']);

        Livewire::test(RecentInquiries::class)
            ->assertSee('Jamie Sponsor');
    }
}
