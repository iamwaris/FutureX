<?php

namespace App\Models;

use App\Support\ThemeTokens;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ThemePreset extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        ...ThemeTokens::FIELDS,
    ];

    protected function casts(): array
    {
        return [
            'radius' => 'integer',
        ];
    }

    /**
     * Snapshots the live theme into a new named preset.
     */
    public static function captureCurrent(string $name): self
    {
        return static::create([
            'name' => $name,
            ...ThemeSetting::current()->only(ThemeTokens::FIELDS),
        ]);
    }

    /**
     * Applies this preset's tokens onto the live theme.
     */
    public function applyToLiveTheme(): void
    {
        ThemeSetting::current()->update($this->only(ThemeTokens::FIELDS));
    }
}
