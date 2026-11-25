<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Project extends Model
{
    protected $fillable = [
        'title',
        'slug',
        'category',
        'client',
        'year',
        'cover',
        'summary',
        'description',
        'tags',
        'gallery',
        'featured',
    ];

    protected function casts(): array
    {
        return [
            'tags' => 'array',
            'gallery' => 'array',
            'featured' => 'boolean',
        ];
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    protected static function booted(): void
    {
        static::saving(function (Project $project) {
            if (blank($project->slug)) {
                $project->slug = Str::slug($project->title);
            }
        });
    }
}
