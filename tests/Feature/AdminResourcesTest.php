<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminResourcesTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @dataProvider contentResourcePaths
     */
    public function test_content_resource_index_loads(string $path): void
    {
        $this->actingAs(User::factory()->create())
            ->get("/admin/{$path}")
            ->assertOk();
    }

    public static function contentResourcePaths(): array
    {
        return [
            ['page-sections'],
            ['videos'],
            ['gallery-items'],
            ['events'],
            ['faq-items'],
            ['posts'],
            ['streaming-credentials'],
            ['community-links'],
            ['sponsors'],
            ['business-inquiries'],
        ];
    }

    /**
     * @dataProvider settingsPagePaths
     */
    public function test_settings_page_loads(string $path): void
    {
        $this->actingAs(User::factory()->create())
            ->get("/admin/{$path}")
            ->assertOk();
    }

    public static function settingsPagePaths(): array
    {
        return [
            ['theme-builder'],
            ['snapshot-stats-settings'],
            ['newsletter-settings-page'],
            ['media-kit-settings'],
        ];
    }
}
