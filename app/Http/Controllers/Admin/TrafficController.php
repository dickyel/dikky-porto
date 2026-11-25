<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PageView;
use Illuminate\View\View;

class TrafficController extends Controller
{
    public function index(): View
    {
        return view('admin.traffic', [
            'traffic' => PageView::trafficSummary(),
            'chart' => PageView::lastSevenDays(),
            'topPages' => PageView::topPages(8),
            'recent' => PageView::query()->latest('viewed_at')->take(20)->get(),
        ]);
    }
}
