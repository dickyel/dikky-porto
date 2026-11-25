<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\HeroStatController;
use App\Http\Controllers\Admin\ProfileController;
use App\Http\Controllers\Admin\ProjectController as AdminProjectController;
use App\Http\Controllers\Admin\ServiceController;
use App\Http\Controllers\Admin\TestimonialController;
use App\Http\Controllers\Admin\ToolController;
use App\Http\Controllers\Admin\TrafficController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\SitemapController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/projects/{project:slug}', [ProjectController::class, 'show'])->name('projects.show');
Route::get('/sitemap.xml', [SitemapController::class, 'index'])->name('sitemap');
Route::get('/robots.txt', [SitemapController::class, 'robots'])->name('robots');

Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'create'])->name('login');
    Route::post('/login', [LoginController::class, 'store'])->name('login.store');
});

Route::post('/logout', [LoginController::class, 'destroy'])
    ->middleware('auth')
    ->name('logout');

Route::middleware('auth')->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/traffic', [TrafficController::class, 'index'])->name('traffic.index');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');

    Route::get('/tools', [ToolController::class, 'index'])->name('tools.index');
    Route::post('/tools', [ToolController::class, 'store'])->name('tools.store');
    Route::put('/tools/{tool}', [ToolController::class, 'update'])->name('tools.update');
    Route::delete('/tools/{tool}', [ToolController::class, 'destroy'])->name('tools.destroy');

    Route::get('/stats', [HeroStatController::class, 'index'])->name('stats.index');
    Route::post('/stats', [HeroStatController::class, 'store'])->name('stats.store');
    Route::put('/stats/{hero_stat}', [HeroStatController::class, 'update'])->name('stats.update');
    Route::delete('/stats/{hero_stat}', [HeroStatController::class, 'destroy'])->name('stats.destroy');

    Route::resource('services', ServiceController::class)->except(['show']);
    Route::resource('testimonials', TestimonialController::class)->except(['show']);

    Route::get('/projects', [AdminProjectController::class, 'index'])->name('projects.index');
    Route::get('/projects/create', [AdminProjectController::class, 'create'])->name('projects.create');
    Route::post('/projects', [AdminProjectController::class, 'store'])->name('projects.store');
    Route::get('/projects/{project:id}/edit', [AdminProjectController::class, 'edit'])->name('projects.edit');
    Route::put('/projects/{project:id}', [AdminProjectController::class, 'update'])->name('projects.update');
    Route::delete('/projects/{project:id}', [AdminProjectController::class, 'destroy'])->name('projects.destroy');
});
