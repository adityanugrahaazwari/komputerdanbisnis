<?php

namespace App\Http\Controllers;

use App\Models\SiteSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SiteSettingController extends Controller
{
    public function index()
    {
        $this->authorizePermission('site_settings_edit');
        
        $settings = [
            'site_name' => SiteSetting::get('site_name', config('app.name')),
            'site_description' => SiteSetting::get('site_description'),
            'site_logo' => SiteSetting::get('site_logo'),
            'site_favicon' => SiteSetting::get('site_favicon'),
            'site_address' => SiteSetting::get('site_address'),
            'site_phone' => SiteSetting::get('site_phone'),
            'site_email' => SiteSetting::get('site_email'),
            'contact_title' => SiteSetting::get('contact_title', 'Kontak Kami'),
            'contact_description' => SiteSetting::get('contact_description', 'Punya pertanyaan atau ingin berkolaborasi? Jangan ragu untuk menghubungi kami melalui formulir di bawah ini atau melalui kontak resmi kami.'),
            'hero_badge' => SiteSetting::get('hero_badge', 'POLITEKNIK NEGERI TANAH LAUT'),
            'hero_title' => SiteSetting::get('hero_title', 'EXCELLENT INNOVATIVE PROFESSIONAL'),
            'hero_subtitle' => SiteSetting::get('hero_subtitle', 'Mencetak tenaga kerja handal di bidang teknologi informasi dan manajemen bisnis yang siap bersaing di kancah nasional dan global.'),
            'hero_btn1_text' => SiteSetting::get('hero_btn1_text', 'Program Studi'),
            'hero_btn1_url' => SiteSetting::get('hero_btn1_url', '#prodi'),
            'hero_btn2_text' => SiteSetting::get('hero_btn2_text', 'Profil Jurusan'),
            'hero_btn2_url' => SiteSetting::get('hero_btn2_url', '/profil'),
            'footer_text' => SiteSetting::get('footer_text', '© ' . date('Y') . ' ' . config('app.name')),
        ];

        return view('site_settings.index', compact('settings'));
    }

    public function update(Request $request)
    {
        $this->authorizePermission('site_settings_edit');

        $request->validate([
            'site_name' => 'nullable|string|max:255',
            'site_description' => 'nullable|string',
            'site_logo' => 'nullable|image|mimes:jpeg,png,jpg,svg|max:2048',
            'site_favicon' => 'nullable|image|mimes:ico,png,jpg|max:1024',
            'site_address' => 'nullable|string',
            'site_phone' => 'nullable|string|max:20',
            'site_email' => 'nullable|email|max:255',
            'footer_text' => 'nullable|string|max:255',
        ]);

        $fields = [
            'site_name', 'site_description', 'site_address', 'site_phone', 'site_email', 
            'contact_title', 'contact_description', 
            'hero_badge', 'hero_title', 'hero_subtitle', 'hero_btn1_text', 'hero_btn1_url', 'hero_btn2_text', 'hero_btn2_url',
            'footer_text'
        ];
        foreach ($fields as $field) {
            if ($request->has($field)) {
                SiteSetting::set($field, $request->$field);
            }
        }

        if ($request->hasFile('site_logo')) {
            $oldLogo = SiteSetting::get('site_logo');
            if ($oldLogo) {
                Storage::disk('public')->delete($oldLogo);
            }
            $path = $request->file('site_logo')->store('settings', 'public');
            SiteSetting::set('site_logo', $path);
        }

        if ($request->hasFile('site_favicon')) {
            $oldFavicon = SiteSetting::get('site_favicon');
            if ($oldFavicon) {
                Storage::disk('public')->delete($oldFavicon);
            }
            $path = $request->file('site_favicon')->store('settings', 'public');
            SiteSetting::set('site_favicon', $path);
        }

        return redirect()->back()->with('success', 'Pengaturan berhasil diperbarui.');
    }

    protected function authorizePermission($permission)
    {
        if (!auth()->user()->can($permission)) {
            abort(403, 'Unauthorized action.');
        }
    }
}
