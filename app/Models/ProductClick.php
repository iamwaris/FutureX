<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductClick extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'product_name',
        'destination_url',
        'clicked_at',
    ];

    protected function casts(): array
    {
        return [
            'clicked_at' => 'datetime',
        ];
    }
}
