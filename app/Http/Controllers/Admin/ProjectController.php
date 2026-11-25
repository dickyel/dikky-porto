<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Project;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\View\View;

class ProjectController extends Controller
{
    public function index(): View
    {
        $projects = Project::query()->latest()->get();

        return view('admin.projects.index', compact('projects'));
    }

    public function create(): View
    {
        return view('admin.projects.form', [
            'project' => new Project(),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $this->validated($request);
        Project::query()->create($data);

        return redirect()
            ->route('admin.projects.index')
            ->with('success', 'Project berhasil ditambahkan.');
    }

    public function edit(Project $project): View
    {
        return view('admin.projects.form', compact('project'));
    }

    public function update(Request $request, Project $project): RedirectResponse
    {
        $data = $this->validated($request, $project);
        $project->update($data);

        return redirect()
            ->route('admin.projects.index')
            ->with('success', 'Project berhasil diperbarui.');
    }

    public function destroy(Project $project): RedirectResponse
    {
        $this->deleteStoredFiles(array_filter([
            $project->cover,
            ...($project->gallery ?? []),
        ]));

        $project->delete();

        return redirect()
            ->route('admin.projects.index')
            ->with('success', 'Project berhasil dihapus.');
    }

    private function validated(Request $request, ?Project $project = null): array
    {
        $isUpdate = $project !== null;

        $data = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'slug' => ['nullable', 'string', 'max:255', 'unique:projects,slug,'.($project?->id ?? 'NULL')],
            'category' => ['required', 'string', 'max:255'],
            'client' => ['required', 'string', 'max:255'],
            'year' => ['required', 'string', 'max:10'],
            'cover_file' => [$isUpdate ? 'nullable' : 'required', 'image', 'max:5120'],
            'gallery_files' => ['nullable', 'array'],
            'gallery_files.*' => ['image', 'max:5120'],
            'keep_gallery' => ['nullable', 'array'],
            'keep_gallery.*' => ['string'],
            'summary' => ['required', 'string'],
            'description' => ['required', 'string'],
            'tags' => ['nullable', 'string'],
            'featured' => ['nullable', 'boolean'],
        ]);

        $payload = [
            'title' => $data['title'],
            'slug' => filled($data['slug'] ?? null)
                ? Str::slug($data['slug'])
                : Str::slug($data['title']),
            'category' => $data['category'],
            'client' => $data['client'],
            'year' => $data['year'],
            'summary' => $data['summary'],
            'description' => $data['description'],
            'tags' => collect(explode(',', (string) ($data['tags'] ?? '')))
                ->map(fn ($tag) => trim($tag))
                ->filter()
                ->values()
                ->all(),
            'featured' => $request->boolean('featured'),
        ];

        if ($request->hasFile('cover_file')) {
            if ($project?->cover) {
                $this->deleteStoredFiles([$project->cover]);
            }
            $payload['cover'] = $request->file('cover_file')->store('projects/covers', 'public');
        } elseif ($project) {
            $payload['cover'] = $project->cover;
        }

        $gallery = collect($request->input('keep_gallery', $project?->gallery ?? []))
            ->filter()
            ->values()
            ->all();

        if ($project) {
            $removed = collect($project->gallery ?? [])
                ->diff($gallery)
                ->values()
                ->all();
            $this->deleteStoredFiles($removed);
        }

        if ($request->hasFile('gallery_files')) {
            foreach ($request->file('gallery_files') as $file) {
                $gallery[] = $file->store('projects/gallery', 'public');
            }
        }

        if ($gallery === [] && ! empty($payload['cover'])) {
            $gallery = [$payload['cover']];
        }

        $payload['gallery'] = array_values($gallery);

        return $payload;
    }

    private function deleteStoredFiles(array $paths): void
    {
        foreach ($paths as $path) {
            if (
                is_string($path)
                && ! str_starts_with($path, 'http://')
                && ! str_starts_with($path, 'https://')
                && Storage::disk('public')->exists($path)
            ) {
                Storage::disk('public')->delete($path);
            }
        }
    }
}
