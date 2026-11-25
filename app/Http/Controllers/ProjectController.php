<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\View\View;

class ProjectController extends Controller
{
    public function show(Project $project): View
    {
        $next = Project::query()
            ->where('id', '!=', $project->id)
            ->latest()
            ->first();

        return view('projects.show', compact('project', 'next'));
    }
}
