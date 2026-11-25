<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Testimonial;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class TestimonialController extends Controller
{
    public function index(): View
    {
        return view('admin.testimonials.index', [
            'testimonials' => Testimonial::query()->orderBy('sort_order')->get(),
        ]);
    }

    public function create(): View
    {
        return view('admin.testimonials.form', ['testimonial' => new Testimonial()]);
    }

    public function store(Request $request): RedirectResponse
    {
        Testimonial::query()->create($this->validated($request));

        return redirect()->route('admin.testimonials.index')->with('success', 'Testimonial ditambahkan.');
    }

    public function edit(Testimonial $testimonial): View
    {
        return view('admin.testimonials.form', compact('testimonial'));
    }

    public function update(Request $request, Testimonial $testimonial): RedirectResponse
    {
        $testimonial->update($this->validated($request, $testimonial));

        return redirect()->route('admin.testimonials.index')->with('success', 'Testimonial diperbarui.');
    }

    public function destroy(Testimonial $testimonial): RedirectResponse
    {
        $this->deleteStored([$testimonial->avatar, $testimonial->visual_image]);
        $testimonial->delete();

        return back()->with('success', 'Testimonial dihapus.');
    }

    private function validated(Request $request, ?Testimonial $testimonial = null): array
    {
        $data = $request->validate([
            'quote' => ['required', 'string'],
            'author_name' => ['required', 'string', 'max:255'],
            'author_role' => ['nullable', 'string', 'max:255'],
            'avatar_file' => ['nullable', 'image', 'max:5120'],
            'visual_file' => ['nullable', 'image', 'max:5120'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
            'featured' => ['nullable', 'boolean'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        $avatar = $testimonial?->avatar;
        $visual = $testimonial?->visual_image;

        if ($request->hasFile('avatar_file')) {
            $this->deleteStored([$avatar]);
            $avatar = $request->file('avatar_file')->store('testimonials/avatars', 'public');
        }

        if ($request->hasFile('visual_file')) {
            $this->deleteStored([$visual]);
            $visual = $request->file('visual_file')->store('testimonials/visuals', 'public');
        }

        return [
            'quote' => $data['quote'],
            'author_name' => $data['author_name'],
            'author_role' => $data['author_role'] ?? null,
            'avatar' => $avatar,
            'visual_image' => $visual,
            'sort_order' => $data['sort_order'] ?? 0,
            'featured' => $request->boolean('featured'),
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
