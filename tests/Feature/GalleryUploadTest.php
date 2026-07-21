<?php

namespace Tests\Feature;

use App\Models\GalleryItem;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Tests\TestCase;

class GalleryUploadTest extends TestCase
{
    use RefreshDatabase;

    public function test_a_gallery_item_can_have_an_image_uploaded_to_it(): void
    {
        $item = GalleryItem::create([
            'caption' => 'Meet & greet at the con',
            'category' => 'conventions',
        ]);

        $media = $item->addMedia(UploadedFile::fake()->image('photo.jpg'))
            ->toMediaCollection('image');

        $this->assertFileExists($media->getPath());
        $this->assertNotNull($item->fresh()->getFirstMedia('image'));
        $this->assertStringContainsString('photo', $item->fresh()->getFirstMediaUrl('image'));
    }
}
