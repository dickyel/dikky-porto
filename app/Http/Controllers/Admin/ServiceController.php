<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Service;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class ServiceController extends Controller
{
    public function index(): View
    {
        return view('admin.services.index', [
            'services' => Service::query()->orderBy('sort_order')->get(),
        ]);
    }

    public function create(): View
    {
        return view('admin.services.form', ['service' => new Service()]);
    }

    public function store(Request $request): RedirectResponse
    {
        Service::query()->create($this->validated($request));

        return redirect()->route('admin.services.index')->with('success', 'Service ditambahkan.');
    }

    public function edit(Service $service): View
    {
        return view('admin.services.form', compact('service'));
    }

    public function update(Request $request, Service $service): RedirectResponse
    {
        $service->update($this->validated($request, $service));

        return redirect()->route('admin.services.index')->with('success', 'Service diperbarui.');
    }

    public function destroy(Service $service): RedirectResponse
    {
        $this->deleteStored([$service->thumbnail, $service->preview_image]);
        $service->delete();

        return back()->with('success', 'Service dihapus.');
    }

    private function validated(Request $request, ?Service $service = null): array
    {
        $data = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'thumbnail_file' => ['nullable', 'image', 'max:5120'],
            'preview_file' => ['nullable', 'image', 'max:5120'],
            'stat_values' => ['nullable', 'array'],
            'stat_labels' => ['nullable', 'array'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        $stats = [];
        foreach ($data['stat_values'] ?? [] as $i => $value) {
            $label = $data['stat_labels'][$i] ?? '';
            if (filled($value) || filled($label)) {
                $stats[] = ['value' => $value, 'label' => $label];
            }
        }

        $thumbnail = $service?->thumbnail;
        $preview = $service?->preview_image;

        if ($request->hasFile('thumbnail_file')) {
            $this->deleteStored([$thumbnail]);
            $thumbnail = $request->file('thumbnail_file')->store('services/thumbs', 'public');
        }

        if ($request->hasFile('preview_file')) {
            $this->deleteStored([$preview]);
            $preview = $request->file('preview_file')->store('services/previews', 'public');
        }

        return [
            'title' => $data['title'],
            'description' => $data['description'] ?? null,
            'thumbnail' => $thumbnail,
            'preview_image' => $preview,
            'stats' => $stats,
            'sort_order' => $data['sort_order'] ?? 0,
            'is_active' => $request->boolean('is_active', true),
        ];
    }

    private function deleteStored(array $paths): void
    {
        foreach ($paths as $path) {
            if (
                is_string($path)
                && ! str_starts_with($path, 'http')
                && Storage::disk('public')->exists($path)
            ) {
                Storage::disk('public')->delete($path);
            }
        }
    }
}
