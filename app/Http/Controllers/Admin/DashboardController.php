<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\HeroStat;
use App\Models\PageView;
use App\Models\Project;
use App\Models\Service;
use App\Models\Testimonial;
use App\Models\Tool;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        $counts = [
            'projects' => Project::query()->count(),
            'featured' => Project::query()->where('featured', true)->count(),
            'tools' => Tool::query()->count(),
            'stats' => HeroStat::query()->count(),
            'services' => Service::query()->count(),
            'testimonials' => Testimonial::query()->count(),
        ];

        $traffic = PageView::trafficSummary();
        $chart = PageView::lastSevenDays();
        $recentProjects = Project::query()->latest()->take(4)->get();

        return view('admin.dashboard', compact('counts', 'recentProjects', 'traffic', 'chart'));
    }
}
