<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\PermissionGroupController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\GalleryController;
use App\Http\Controllers\LecturerController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\DocumentController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\TestimonialController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\ActivityLogController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\OrganizationalStructureController;
use App\Http\Controllers\StudyProgramController;
use App\Http\Controllers\SocialMediaController;
use App\Http\Controllers\AnnouncementController;
use App\Http\Controllers\DashboardSettingController;
use App\Http\Controllers\SiteSettingController;
use App\Http\Controllers\BackupController;
use App\Http\Controllers\ManualBookController;
use App\Http\Controllers\AccountController;

Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
Route::get('/dashboard/chart-data', [DashboardController::class, 'chartData'])->name('dashboard.chart-data');

// Todo routes
Route::post('/todos', [\App\Http\Controllers\TodoController::class, 'store'])->name('todos.store');
Route::post('/todos/{todo}/toggle', [\App\Http\Controllers\TodoController::class, 'toggle'])->name('todos.toggle');
Route::delete('/todos/{todo}', [\App\Http\Controllers\TodoController::class, 'destroy'])->name('todos.destroy');

// Granular permissions are handled inside controllers for cleaner routes
Route::resource('users', UserController::class);
Route::resource('roles', RoleController::class);
Route::resource('permission-groups', PermissionGroupController::class)->names('permission-groups');
Route::resource('permissions', PermissionController::class);
Route::resource('menus', MenuController::class);
Route::resource('posts', PostController::class);
Route::resource('categories', CategoryController::class);
Route::resource('gallery-groups', \App\Http\Controllers\GalleryGroupController::class)->names('gallery-groups');
Route::resource('galleries', GalleryController::class);
Route::resource('lecturers', LecturerController::class);
Route::resource('events', EventController::class);
Route::resource('documents', DocumentController::class);
Route::resource('services', ServiceController::class);
Route::resource('testimonials', TestimonialController::class);

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
Route::resource('announcements', AnnouncementController::class)->except(['show', 'edit', 'update']);
Route::post('/announcements/{announcement}/toggle', [AnnouncementController::class, 'toggle'])->name('announcements.toggle');

Route::get('/dashboard-settings', [DashboardSettingController::class, 'index'])->name('dashboard-settings.index');
Route::put('/dashboard-settings', [DashboardSettingController::class, 'update'])->name('dashboard-settings.update');

Route::get('/site-settings', [SiteSettingController::class, 'index'])->name('site-settings.index');
Route::put('/site-settings', [SiteSettingController::class, 'update'])->name('site-settings.update');

Route::get('/backups', [BackupController::class, 'index'])->name('backups.index');
Route::post('/backups', [BackupController::class, 'create'])->name('backups.create');
Route::get('/backups/{filename}/download', [BackupController::class, 'download'])->name('backups.download');
Route::delete('/backups/{filename}', [BackupController::class, 'destroy'])->name('backups.destroy');

Route::get('/manual-book', [ManualBookController::class, 'index'])->name('manual-book.index');

// Account routes
Route::get('/account/profile', [AccountController::class, 'edit'])->name('account.profile.edit');
Route::put('/account/profile', [AccountController::class, 'updateProfile'])->name('account.profile.update');
Route::get('/account/password', [AccountController::class, 'password'])->name('account.password');
Route::put('/account/password', [AccountController::class, 'updatePassword'])->name('account.password.update');

// Media Manager (UniSharp Filemanager)
Route::group(['prefix' => 'laravel-filemanager', 'middleware' => ['web', 'auth']], function () {
    \UniSharp\LaravelFilemanager\Lfm::routes();
});
