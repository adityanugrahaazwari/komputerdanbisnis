<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\Permission;
use App\Models\User;
use App\Models\Menu;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\View;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Register Gates based on permissions
        try {
            $permissions = Permission::all();
            foreach ($permissions as $permission) {
                Gate::define($permission->slug, function (User $user) use ($permission) {
                    return $user->hasPermission($permission->slug);
                });
            }
        } catch (\Exception $e) {
            // Ignore exception if tables do not exist yet (e.g. during initial migration)
        }

        // Share menus and notification counts with all views
        View::composer('*', function ($view) {
            try {
                $menus = Menu::where('location', 'admin')
                    ->whereNull('parent_id')
                    ->where('is_active', true)
                    ->with('children')
                    ->orderBy('order')
                    ->get();

                $frontendMenus = Menu::where('location', 'frontend')
                    ->whereNull('parent_id')
                    ->where('is_active', true)
                    ->with('children')
                    ->orderBy('order')
                    ->get();
                
                $notificationCounts = [
                    'unread_contacts' => \App\Models\Contact::where('is_read', false)->count(),
                    'pending_comments' => \App\Models\Comment::where('status', 'pending')->count(),
                ];

                $view->with([
                    'dynamicMenus' => $menus,
                    'frontendMenus' => $frontendMenus,
                    'notifications' => $notificationCounts
                ]);
            } catch (\Exception $e) {
                $view->with([
                    'dynamicMenus' => collect(),
                    'frontendMenus' => collect(),
                    'notifications' => ['unread_contacts' => 0, 'pending_comments' => 0]
                ]);
            }
        });
    }
}
