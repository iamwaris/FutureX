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
        ];
    }

    public function test_theme_builder_page_loads(): void
    {
        $this->actingAs(User::factory()->create())
            ->get('/admin/theme-builder')
            ->assertOk();
    }
}
