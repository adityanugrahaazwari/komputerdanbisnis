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
use App\Http\Controllers\CommentController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\ActivityLogController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\GalleryController;
use App\Http\Controllers\DocumentController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\PermissionGroupController;
use App\Http\Controllers\OrganizationalStructureController;
use App\Http\Controllers\SitemapController;

Route::get('/lang/{locale}', function ($locale) {
    if (in_array($locale, ['id', 'en'])) {
        session(['locale' => $locale]);
    }
    return redirect()->back();
})->name('lang.switch');

Route::get('/', [LandingController::class, 'index'])->name('home');
Route::get('/profil', [LandingController::class, 'profile'])->name('landing.profile');
Route::get('/program-studi', [LandingController::class, 'studyPrograms'])->name('landing.study_programs');
Route::get('/layanan', [LandingController::class, 'services'])->name('landing.services');
Route::get('/berita', [LandingController::class, 'allPosts'])->name('landing.news');
Route::get('/berita/{slug}', [LandingController::class, 'showPost'])->name('landing.post');
Route::get('/galeri', [LandingController::class, 'gallery'])->name('landing.gallery');
Route::get('/downloads', [LandingController::class, 'downloads'])->name('landing.downloads');
Route::get('/sitemap.xml', [SitemapController::class, 'index']);
Route::post('/berita/{post}/komentar', [CommentController::class, 'store'])->name('comments.store');
Route::post('/kontak', [ContactController::class, 'store'])->name('contacts.store');

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Granular permissions are handled inside controllers for cleaner routes
    Route::resource('users', UserController::class);
    Route::resource('roles', RoleController::class);
    Route::resource('permission-groups', PermissionGroupController::class)->names('permission-groups');
    Route::resource('permissions', PermissionController::class);
    Route::resource('menus', MenuController::class);
    Route::resource('posts', PostController::class);
    Route::resource('categories', CategoryController::class);
    Route::resource('galleries', GalleryController::class);
    Route::resource('documents', DocumentController::class);
    Route::resource('services', ServiceController::class);
    
    Route::get('/contacts', [ContactController::class, 'index'])->name('contacts.index');
    Route::get('/contacts/{contact}', [ContactController::class, 'show'])->name('contacts.show');
    Route::delete('/contacts/{contact}', [ContactController::class, 'destroy'])->name('contacts.destroy');

    Route::get('/comments', [CommentController::class, 'index'])->name('comments.index');
    Route::get('/comments/{comment}', [CommentController::class, 'show'])->name('comments.show');
    Route::post('/comments/{comment}/approve', [CommentController::class, 'approve'])->name('comments.approve');
    Route::post('/comments/{comment}/reject', [CommentController::class, 'reject'])->name('comments.reject');
    Route::delete('/comments/{comment}', [CommentController::class, 'destroy'])->name('comments.destroy');

    Route::get('/logs', [ActivityLogController::class, 'index'])->name('logs.index');
    Route::resource('profiles', ProfileController::class)->only(['index', 'edit', 'update']);
    Route::resource('organizational-structures', OrganizationalStructureController::class)->names('organizational-structures');
    Route::resource('study-programs', StudyProgramController::class)->names('study_programs');
    Route::resource('social-media', SocialMediaController::class)->names('social_media');
});
