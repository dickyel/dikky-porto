<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class Testimonial extends Model
{
    protected $fillable = [
        'quote',
        'author_name',
        'author_role',
        'avatar',
        'visual_image',
        'featured',
        'sort_order',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'featured' => 'boolean',
            'is_active' => 'boolean',
        ];
    }

    public function scopeActive(Builder $query): Builder
    {
        return $query->where('is_active', true)->orderBy('sort_order');
    }
}
