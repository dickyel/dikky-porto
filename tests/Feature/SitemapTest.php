<?php

namespace Tests\Feature;

use App\Models\Project;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SitemapTest extends TestCase
{
    use RefreshDatabase;

    public function test_sitemap_lists_home_and_projects(): void
    {
        $project = Project::query()->create([
            'title' => 'Finora Analytics',
            'slug' => 'finora-analytics',
            'category' => 'Dashboard · SaaS',
            'client' => 'Finora',
            'year' => '2024',
            'cover' => 'https://example.com/cover.jpg',
            'summary' => 'Analytics dashboard case study.',
            'description' => 'Full case study description.',
            'tags' => ['SaaS', 'Dashboard'],
            'gallery' => [],
            'featured' => true,
        ]);

        $response = $this->get(route('sitemap'));

        $response->assertOk();
        $response->assertHeader('Content-Type', 'application/xml; charset=UTF-8');
        $response->assertSee(route('home'), false);
        $response->assertSee(route('projects.show', $project), false);
        $response->assertSee('<urlset', false);
    }

    public function test_robots_points_to_sitemap_and_blocks_admin(): void
    {
        $response = $this->get(route('robots'));

        $response->assertOk();
        $response->assertHeader('Content-Type', 'text/plain; charset=UTF-8');
        $response->assertSee('Disallow: /admin', false);
        $response->assertSee('Sitemap: '.route('sitemap'), false);
    }
}
