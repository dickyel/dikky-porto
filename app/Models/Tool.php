<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class Tool extends Model
{
    protected $fillable = [
        'name',
        'icon_key',
        'icon_svg',
        'icon_url',
        'sort_order',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
        ];
    }

    public function scopeActive(Builder $query): Builder
    {
        return $query->where('is_active', true)->orderBy('sort_order');
    }

    public function renderIcon(): string
    {
        if (filled($this->icon_svg)) {
            return $this->icon_svg;
        }

        if (filled($this->icon_url)) {
            return '<img src="'.e($this->icon_url).'" alt="'.e($this->name).'" width="18" height="18" />';
        }

        return match ($this->icon_key) {
            'figma' => '<svg viewBox="0 0 24 24" width="18" height="18"><path fill="#F24E1E" d="M5 5.5A3.5 3.5 0 0 1 8.5 2H12v7H8.5A3.5 3.5 0 0 1 5 5.5z"/><path fill="#FF7262" d="M12 2h3.5A3.5 3.5 0 0 1 19 5.5 3.5 3.5 0 0 1 15.5 9H12V2z"/><path fill="#A259FF" d="M5 12a3.5 3.5 0 0 1 3.5-3.5H12V15H8.5A3.5 3.5 0 0 1 5 12z"/><path fill="#1ABCFE" d="M12 8.5h3.5A3.5 3.5 0 1 1 12 12V8.5z"/><path fill="#0ACF83" d="M5 18.5A3.5 3.5 0 0 1 8.5 15H12v3.5A3.5 3.5 0 0 1 8.5 22 3.5 3.5 0 0 1 5 18.5z"/></svg>',
            'framer' => '<svg viewBox="0 0 24 24" width="16" height="16"><path fill="currentColor" d="M4 2h16v6H12l8 8h-8v6l-8-8V2z"/></svg>',
            'webflow' => '<svg viewBox="0 0 24 24" width="18" height="18"><path fill="#4353FF" d="M17.9 4H24l-5.2 16h-5.1L17.9 4zM9.4 4l3.9 16H8.2L4.3 8.6 2.1 16H0L3.1 4h6.3z"/></svg>',
            'after-effects' => '<svg viewBox="0 0 24 24" width="18" height="18"><rect width="24" height="24" rx="4" fill="#00005B"/><text x="4" y="17" fill="#D7A3FF" font-size="11" font-family="sans-serif" font-weight="700">Ae</text></svg>',
            'notion' => '<svg viewBox="0 0 24 24" width="16" height="16"><path fill="currentColor" d="M4 4h12l4 3v13H8l-4-3V4zm3 3v10h2V9h5v8h2V7H7z"/></svg>',
            default => '<span style="font-size:11px;font-weight:700">'.e(strtoupper(substr($this->name, 0, 2))).'</span>',
        };
    }
}
