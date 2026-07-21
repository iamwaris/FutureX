<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Sponsor extends Model implements HasMedia
{
    use InteractsWithMedia;

    protected $fillable = [
        'name',
        'website_url',
        'case_study',
        'campaign_highlights',
        'testimonial_quote',
        'testimonial_author',
        'is_featured',
        'order',
    ];

    protected function casts(): array
    {
        return [
            'is_featured' => 'boolean',
        ];
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('logo')->singleFile();
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('order');
    }
}
