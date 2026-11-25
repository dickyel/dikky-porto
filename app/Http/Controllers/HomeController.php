<?php

namespace App\Http\Controllers;

use App\Models\HeroStat;
use App\Models\Project;
use App\Models\Service;
use App\Models\SiteProfile;
use App\Models\Testimonial;
use App\Models\Tool;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function index(): View
    {
        $profile = SiteProfile::current();

        $tools = Tool::query()->active()->get();
        $stats = HeroStat::query()->active()->get();
        $services = Service::query()->active()->get();
        $testimonials = Testimonial::query()->active()->get();

        $featured = Project::query()
            ->where('featured', true)
            ->latest()
            ->first();

        $projects = Project::query()
            ->when($featured, fn ($q) => $q->where('id', '!=', $featured->id))
            ->latest()
            ->take(4)
            ->get();

        if (! $featured) {
            $featured = $projects->shift();
        }

        return view('home', compact(
            'profile',
            'tools',
            'stats',
            'services',
            'testimonials',
            'featured',
            'projects'
        ));
    }
}
