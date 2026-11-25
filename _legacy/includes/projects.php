<?php

declare(strict_types=1);

function projects_file(): string
{
    return DATA_PATH . '/projects.json';
}

function get_projects(): array
{
    $projects = read_json(projects_file(), []);
    return is_array($projects) ? $projects : [];
}

function save_projects(array $projects): bool
{
    return write_json(projects_file(), array_values($projects));
}

function get_project_by_slug(string $slug): ?array
{
    foreach (get_projects() as $project) {
        if (($project['slug'] ?? '') === $slug) {
            return $project;
        }
    }

    return null;
}

function get_project_by_id(string $id): ?array
{
    foreach (get_projects() as $project) {
        if (($project['id'] ?? '') === $id) {
            return $project;
        }
    }

    return null;
}

function get_featured_project(): ?array
{
    foreach (get_projects() as $project) {
        if (!empty($project['featured'])) {
            return $project;
        }
    }

    $projects = get_projects();
    return $projects[0] ?? null;
}

function get_grid_projects(): array
{
    $featured = get_featured_project();
    $featuredId = $featured['id'] ?? null;

    return array_values(array_filter(
        get_projects(),
        static fn(array $p): bool => ($p['id'] ?? null) !== $featuredId
    ));
}

function unique_slug(string $base, ?string $ignoreId = null): string
{
    $slug = slugify($base);
    $i = 2;
    $candidate = $slug;

    while (true) {
        $existing = get_project_by_slug($candidate);
        if (!$existing || ($ignoreId && ($existing['id'] ?? null) === $ignoreId)) {
            return $candidate;
        }
        $candidate = $slug . '-' . $i;
        $i++;
    }
}

function parse_tags(string $raw): array
{
    $parts = array_map('trim', explode(',', $raw));
    return array_values(array_filter($parts, static fn($t) => $t !== ''));
}

function parse_gallery(string $raw): array
{
    $lines = preg_split('/\r\n|\r|\n/', $raw) ?: [];
    $urls = array_map('trim', $lines);
    return array_values(array_filter($urls, static fn($u) => $u !== ''));
}
