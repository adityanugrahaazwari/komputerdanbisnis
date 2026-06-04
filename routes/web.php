<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\LandingController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\SitemapController;
use App\Http\Controllers\SearchController;

/*
|--------------------------------------------------------------------------
| Web Routes (Public & Auth)
|--------------------------------------------------------------------------
|
| Pelajari lebih lanjut: admin routes dipisahkan di routes/admin.php
|
*/

Route::get('/lang/{locale}', function ($locale) {
    if (in_array($locale, ['id', 'en'])) {
        session(['locale' => $locale]);
    }
    return redirect()->back();
})->name('lang.switch');

// Frontend Routes
Route::get('/', [LandingController::class, 'index'])->name('home');
Route::get('/search', [SearchController::class, 'index'])->name('search');
Route::get('/profil', [LandingController::class, 'profile'])->name('landing.profile');
Route::get('/program-studi', [LandingController::class, 'studyPrograms'])->name('landing.study_programs');
Route::get('/layanan', [LandingController::class, 'services'])->name('landing.services');
Route::get('/dosen', [LandingController::class, 'lecturers'])->name('landing.lecturers');
Route::get('/kalender-kegiatan', [LandingController::class, 'calendar'])->name('landing.calendar');
Route::get('/berita', [LandingController::class, 'allPosts'])->name('landing.news');
Route::get('/berita/{slug}', [LandingController::class, 'showPost'])->name('landing.post');
Route::get('/galeri', [LandingController::class, 'gallery'])->name('landing.gallery');
Route::get('/downloads', [LandingController::class, 'downloads'])->name('landing.downloads');
Route::get('/sitemap.xml', [SitemapController::class, 'index']);

// Public Submissions
Route::post('/berita/{post}/komentar', [CommentController::class, 'store'])->name('comments.store');
Route::post('/kontak', [ContactController::class, 'store'])->name('contacts.store');

// Auth Routes
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Password Reset Routes
Route::get('/forgot-password', [\App\Http\Controllers\PasswordResetController::class, 'create'])->name('password.request');
Route::post('/forgot-password', [\App\Http\Controllers\PasswordResetController::class, 'store'])->name('password.email');
Route::get('/reset-password/{token}', [\App\Http\Controllers\PasswordResetController::class, 'reset'])->name('password.reset');
Route::post('/reset-password', [\App\Http\Controllers\PasswordResetController::class, 'update'])->name('password.update');
