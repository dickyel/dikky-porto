<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Tool;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ToolController extends Controller
{
    public function index(): View
    {
        return view('admin.tools.index', [
            'tools' => Tool::query()->orderBy('sort_order')->get(),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:100'],
            'icon_key' => ['nullable', 'string', 'max:50'],
            'icon_url' => ['nullable', 'url', 'max:2048'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
        ]);

        $data['is_active'] = true;
        $data['sort_order'] = $data['sort_order'] ?? 0;

        Tool::query()->create($data);

        return back()->with('success', 'Tool ditambahkan.');
    }

    public function update(Request $request, Tool $tool): RedirectResponse
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:100'],
            'icon_key' => ['nullable', 'string', 'max:50'],
            'icon_url' => ['nullable', 'url', 'max:2048'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        $data['is_active'] = $request->boolean('is_active');
        $tool->update($data);

        return back()->with('success', 'Tool diperbarui.');
    }

    public function destroy(Tool $tool): RedirectResponse
    {
        $tool->delete();

        return back()->with('success', 'Tool dihapus.');
    }
}
