<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    protected $fillable = [
        'title',
        'description',
        'type',
        'starts_at',
        'location',
    ];

    protected function casts(): array
    {
        return [
            'starts_at' => 'datetime',
        ];
    }
}
