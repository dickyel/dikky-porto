<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class PageView extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'path',
        'ip',
        'user_agent',
        'referer',
        'viewed_at',
    ];

    protected function casts(): array
    {
        return [
            'viewed_at' => 'datetime',
        ];
    }

    public static function trafficSummary(): array
    {
        $today = Carbon::today();
        $weekStart = Carbon::now()->subDays(6)->startOfDay();
        $monthStart = Carbon::now()->startOfMonth();

        return [
            'today' => static::query()->whereDate('viewed_at', $today)->count(),
            'today_unique' => static::query()->whereDate('viewed_at', $today)->distinct('ip')->count('ip'),
            'week' => static::query()->where('viewed_at', '>=', $weekStart)->count(),
            'week_unique' => static::query()->where('viewed_at', '>=', $weekStart)->distinct('ip')->count('ip'),
            'month' => static::query()->where('viewed_at', '>=', $monthStart)->count(),
            'total' => static::query()->count(),
        ];
    }

    public static function lastSevenDays(): Collection
    {
        $start = Carbon::now()->subDays(6)->startOfDay();

        $rows = static::query()
            ->select(DB::raw('DATE(viewed_at) as day'), DB::raw('COUNT(*) as total'))
            ->where('viewed_at', '>=', $start)
            ->groupBy('day')
            ->pluck('total', 'day');

        $days = collect();
        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::now()->subDays($i);
            $key = $date->toDateString();
            $days->push([
                'label' => $date->format('d M'),
                'total' => (int) ($rows[$key] ?? 0),
            ]);
        }

        return $days;
    }

    public static function topPages(int $limit = 5): Collection
    {
        return static::query()
            ->select('path', DB::raw('COUNT(*) as total'))
            ->groupBy('path')
            ->orderByDesc('total')
            ->limit($limit)
            ->get();
    }
}
