<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\Permission;
use App\Models\User;
use App\Models\Menu;
use App\Models\SiteSetting;
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
        \Illuminate\Validation\Rules\Password::defaults(function () {
            return \Illuminate\Validation\Rules\Password::min(8)
                ->letters()
                ->mixedCase()
                ->numbers()
                ->symbols()
                ->uncompromised();
        });

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
                $siteSettings = [
                    'logo' => SiteSetting::get('site_logo'),
                    'name' => SiteSetting::get('site_name', config('app.name')),
                    'favicon' => SiteSetting::get('site_favicon'),
                    'description' => SiteSetting::get('site_description'),
                    'keywords' => SiteSetting::get('site_keywords'),
                    'address' => SiteSetting::get('site_address'),
                    'phone' => SiteSetting::get('site_phone'),
                    'email' => SiteSetting::get('site_email'),
                    'contact_title' => SiteSetting::get('contact_title', 'Kontak Kami'),
                    'contact_description' => SiteSetting::get('contact_description', 'Punya pertanyaan atau ingin berkolaborasi? Jangan ragu untuk menghubungi kami melalui formulir di bawah ini atau melalui kontak resmi kami.'),
                    'hero_badge' => SiteSetting::get('hero_badge', 'POLITEKNIK NEGERI TANAH LAUT'),
                    'hero_title' => SiteSetting::get('hero_title', 'EXCELLENT INNOVATIVE PROFESSIONAL'),
                    'hero_subtitle' => SiteSetting::get('hero_subtitle', 'Mencetak tenaga kerja handal di bidang teknologi informasi dan manajemen bisnis yang siap bersaing di kancah nasional dan global.'),
                    'hero_btn1_text' => SiteSetting::get('hero_btn1_text', 'Program Studi'),
                    'hero_btn1_url' => SiteSetting::get('hero_btn1_url', '#prodi'),
                    'hero_btn2_text' => SiteSetting::get('hero_btn2_text', 'Profil Jurusan'),
                    'hero_btn2_url' => SiteSetting::get('hero_btn2_url', '/profil'),
                    'footer' => SiteSetting::get('footer_text', '© ' . date('Y') . ' ' . config('app.name')),
                    'primary_color' => SiteSetting::get('primary_color', '#ef4444'),
                ];

                $menus = Menu::where('location', 'admin')
                    ->whereNull('parent_id')
                    ->active()
                    ->with('children')
                    ->ordered()
                    ->get();

                $frontendMenus = Menu::where('location', 'frontend')
                    ->whereNull('parent_id')
                    ->active()
                    ->with('children')
                    ->ordered()
                    ->get();

                $notificationCounts = [
                    'unread_contacts' => \App\Models\Contact::where('is_read', false)->count(),
                    'pending_comments' => \App\Models\Comment::where('status', 'pending')->count(),
                ];

                $visitorCount = \App\Models\Visitor::count();
                $socialMedia = \App\Models\SocialMedia::active()->ordered()->get();

                $view->with([
                    'dynamicMenus' => $menus,
                    'frontendMenus' => $frontendMenus,
                    'notifications' => $notificationCounts,
                    'siteSettings' => $siteSettings,
                    'visitorCount' => $visitorCount,
                    'socialMedia' => $socialMedia
                ]);
            } catch (\Exception $e) {
                $view->with([
                    'dynamicMenus' => collect(),
                    'frontendMenus' => collect(),
                    'notifications' => ['unread_contacts' => 0, 'pending_comments' => 0],
                    'siteSettings' => [
                        'logo' => null,
                        'name' => config('app.name'),
                        'favicon' => null,
                        'footer' => '© ' . date('Y') . ' ' . config('app.name')
                    ]
                ]);
            }
        });

    }
}
