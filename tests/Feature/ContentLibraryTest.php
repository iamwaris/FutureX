<?php

namespace Tests\Feature;

use App\Livewire\ContentLibrary;
use App\Models\Video;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class ContentLibraryTest extends TestCase
{
    use RefreshDatabase;

    public function test_search_filters_by_title(): void
    {
        Video::factory()->create(['title' => 'Radiant Climb Highlights']);
        Video::factory()->create(['title' => 'Cooking Stream VOD']);

        Livewire::test(ContentLibrary::class)
            ->set('search', 'Radiant')
            ->assertSee('Radiant Climb Highlights')
            ->assertDontSee('Cooking Stream VOD');
    }

    public function test_type_filter_narrows_results(): void
    {
        Video::factory()->create(['title' => 'A Clip', 'type' => 'clip']);
        Video::factory()->create(['title' => 'A Short', 'type' => 'short']);

        Livewire::test(ContentLibrary::class)
            ->set('type', 'clip')
            ->assertSee('A Clip')
            ->assertDontSee('A Short');
    }

    public function test_category_filter_narrows_results(): void
    {
        Video::factory()->create(['title' => 'Valorant Video', 'category' => 'Valorant']);
        Video::factory()->create(['title' => 'Chatting Video', 'category' => 'Just Chatting']);

        Livewire::test(ContentLibrary::class)
            ->set('category', 'Valorant')
            ->assertSee('Valorant Video')
            ->assertDontSee('Chatting Video');
    }

    public function test_reset_filters_clears_search_type_and_category(): void
    {
        Livewire::test(ContentLibrary::class)
            ->set('search', 'x')
            ->set('type', 'clip')
            ->set('category', 'Valorant')
            ->call('resetFilters')
            ->assertSet('search', '')
            ->assertSet('type', '')
            ->assertSet('category', '');
    }

    /**
     * Exit criteria: "stay responsive at scale (test with 100+ dummy items)".
     */
    public function test_library_paginates_correctly_with_over_100_items(): void
    {
        Video::factory()->count(120)->create();

        $start = microtime(true);

        $component = Livewire::test(ContentLibrary::class);

        $elapsed = microtime(true) - $start;

        // 12 per page — first page should never dump all 120 at once.
        $component->assertViewHas('videos', fn ($videos) => $videos->total() === 120 && $videos->count() === 12);

        $this->assertLessThan(2.0, $elapsed, 'Content Library took too long to render with 120 items.');
    }
}
