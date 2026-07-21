<?php

namespace Tests\Feature;

use App\Livewire\GalleryGrid;
use App\Models\GalleryItem;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class GalleryTest extends TestCase
{
    use RefreshDatabase;

    public function test_category_filter_narrows_results(): void
    {
        GalleryItem::factory()->create(['caption' => 'Con photo', 'category' => 'conventions']);
        GalleryItem::factory()->create(['caption' => 'Cosplay shot', 'category' => 'cosplay']);

        Livewire::test(GalleryGrid::class)
            ->set('category', 'conventions')
            ->assertSee('Con photo')
            ->assertDontSee('Cosplay shot');
    }

    public function test_gallery_page_loads_and_includes_lightbox_markup(): void
    {
        GalleryItem::factory()->count(3)->create();

        $response = $this->get('/gallery');

        $response->assertOk();
        $response->assertSee('x-cloak', false);
    }

    /**
     * Exit criteria: "stay responsive at scale (test with 100+ dummy items)".
     */
    public function test_gallery_paginates_correctly_with_over_100_items(): void
    {
        GalleryItem::factory()->count(110)->create();

        $component = Livewire::test(GalleryGrid::class);

        $component->assertViewHas('items', fn ($items) => $items->total() === 110 && $items->count() === 16);
    }
}
