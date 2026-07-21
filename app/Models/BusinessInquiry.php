<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BusinessInquiry extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'company',
        'email',
        'campaign_type',
        'budget',
        'timeline',
        'message',
        'attachment_path',
        'is_read',
    ];

    protected function casts(): array
    {
        return [
            'is_read' => 'boolean',
        ];
    }
}
