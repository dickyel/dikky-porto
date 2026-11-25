<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    protected $fillable = [
        'title',
        'description',
        'thumbnail',
        'preview_image',
        'stats',
        'sort_order',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'stats' => 'array',
            'is_active' => 'boolean',
        ];
    }

    public function scopeActive(Builder $query): Builder
    {
        return $query->where('is_active', true)->orderBy('sort_order');
    }
}
