<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\HeroStat;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class HeroStatController extends Controller
{
    public function index(): View
    {
        return view('admin.stats.index', [
            'stats' => HeroStat::query()->orderBy('sort_order')->get(),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'value' => ['required', 'string', 'max:50'],
            'label' => ['required', 'string', 'max:100'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
        ]);

        HeroStat::query()->create([
            ...$data,
            'sort_order' => $data['sort_order'] ?? 0,
            'is_active' => true,
        ]);

        return back()->with('success', 'Stat ditambahkan.');
    }

    public function update(Request $request, HeroStat $hero_stat): RedirectResponse
    {
        $data = $request->validate([
            'value' => ['required', 'string', 'max:50'],
            'label' => ['required', 'string', 'max:100'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        $hero_stat->update([
            ...$data,
            'is_active' => $request->boolean('is_active'),
        ]);

        return back()->with('success', 'Stat diperbarui.');
    }

    public function destroy(HeroStat $hero_stat): RedirectResponse
    {
        $hero_stat->delete();

        return back()->with('success', 'Stat dihapus.');
    }
}
