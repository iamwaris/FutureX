<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CreatorMode extends Model
{
    protected $fillable = [
        'key',
        'label',
        'description',
        'theme_preset_id',
        'section_overrides',
    ];

    protected function casts(): array
    {
        return [
            'section_overrides' => 'array',
        ];
    }

    public function themePreset()
    {
        return $this->belongsTo(ThemePreset::class);
    }
}
