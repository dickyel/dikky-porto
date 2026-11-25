<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Response;

class SitemapController extends Controller
{
    public function index(): Response
    {
        $projects = Project::query()
            ->latest('updated_at')
            ->get(['slug', 'updated_at']);

        $content = view('seo.sitemap', [
            'projects' => $projects,
        ])->render();

        return response($content, 200)
            ->header('Content-Type', 'application/xml; charset=UTF-8');
    }

    public function robots(): Response
    {
        $content = view('seo.robots')->render();

        return response($content, 200)
            ->header('Content-Type', 'text/plain; charset=UTF-8');
    }
}
