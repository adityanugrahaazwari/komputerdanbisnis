<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\StudyProgramController;
use App\Http\Controllers\SocialMediaController;
use App\Http\Controllers\LandingController;

Route::get('/lang/{locale}', function ($locale) {
    if (in_array($locale, ['id', 'en'])) {
        session(['locale' => $locale]);
    }
    return redirect()->back();
})->name('lang.switch');

Route::get('/', [LandingController::class, 'index'])->name('home');
Route::get('/berita', [LandingController::class, 'allPosts'])->name('landing.news');
Route::get('/berita/{slug}', [LandingController::class, 'showPost'])->name('landing.post');

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Granular permissions are handled inside controllers for cleaner routes
    Route::resource('users', UserController::class);
    Route::resource('roles', RoleController::class);
    Route::resource('permissions', PermissionController::class);
    Route::resource('menus', MenuController::class);
    Route::resource('posts', PostController::class);
    Route::resource('profiles', ProfileController::class)->only(['index', 'edit', 'update']);
    Route::resource('study-programs', StudyProgramController::class)->names('study_programs');
    Route::resource('social-media', SocialMediaController::class)->names('social_media');
});
