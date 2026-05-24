@extends('layouts.app')

@section('header', 'Edit Menu')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="bg-white rounded-[2rem] shadow-sm border border-gray-100 p-8">
        <div class="mb-8">
            <h3 class="text-xl font-black text-gray-900 uppercase tracking-tight">Perbarui Menu</h3>
            <p class="text-gray-500 text-sm">Ubah konfigurasi navigasi untuk dashboard admin atau landing page.</p>
        </div>

        <form action="{{ route('menus.update', $menu->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <div class="md:col-span-2">
                    <label class="block text-gray-700 text-xs font-black uppercase tracking-widest mb-2">Judul Menu</label>
                    <input type="text" name="title" class="w-full bg-gray-50 border border-gray-100 rounded-2xl px-4 py-3 text-sm focus:ring-2 focus:ring-red-500 transition outline-none" value="{{ old('title', $menu->title) }}" placeholder="Contoh: Beranda atau messages.home">
                    <p class="text-[10px] text-gray-400 mt-1 italic">Gunakan prefix 'messages.' untuk dukungan multi-bahasa.</p>
                </div>

                <div>
                    <label class="block text-gray-700 text-xs font-black uppercase tracking-widest mb-2">Lokasi Menu</label>
                    <select name="location" class="w-full bg-gray-50 border border-gray-100 rounded-2xl px-4 py-3 text-sm focus:ring-2 focus:ring-red-500 transition outline-none">
                        <option value="admin" {{ $menu->location === 'admin' ? 'selected' : '' }}>Dashboard Admin (Sidebar)</option>
                        <option value="frontend" {{ $menu->location === 'frontend' ? 'selected' : '' }}>Landing Page (Navbar Utama)</option>
                    </select>
                </div>

                <div>
                    <label class="block text-gray-700 text-xs font-black uppercase tracking-widest mb-2">URL / Route</label>
                    <input type="text" name="url" class="w-full bg-gray-50 border border-gray-100 rounded-2xl px-4 py-3 text-sm focus:ring-2 focus:ring-red-500 transition outline-none" value="{{ old('url', $menu->url) }}" placeholder="Contoh: /dashboard atau #profil">
                </div>

                <div>
                    <label class="block text-gray-700 text-xs font-black uppercase tracking-widest mb-2">Icon (FontAwesome)</label>
                    <input type="text" name="icon" class="w-full bg-gray-50 border border-gray-100 rounded-2xl px-4 py-3 text-sm focus:ring-2 focus:ring-red-500 transition outline-none" value="{{ old('icon', $menu->icon) }}" placeholder="fas fa-home">
                </div>

                <div>
                    <label class="block text-gray-700 text-xs font-black uppercase tracking-widest mb-2">Parent Menu (Opsional)</label>
                    <select name="parent_id" class="w-full bg-gray-50 border border-gray-100 rounded-2xl px-4 py-3 text-sm focus:ring-2 focus:ring-red-500 transition outline-none">
                        <option value="">-- Tanpa Parent (Root) --</option>
                        @foreach($parentMenus as $parent)
                            <option value="{{ $parent->id }}" {{ $menu->parent_id == $parent->id ? 'selected' : '' }}>{{ $parent->location }}: {{ Str::contains($parent->title, 'messages.') ? __($parent->title) : $parent->title }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-gray-700 text-xs font-black uppercase tracking-widest mb-2">Urutan (Order)</label>
                    <input type="number" name="order" class="w-full bg-gray-50 border border-gray-100 rounded-2xl px-4 py-3 text-sm focus:ring-2 focus:ring-red-500 transition outline-none" value="{{ old('order', $menu->order) }}">
                </div>

                <div>
                    <label class="block text-gray-700 text-xs font-black uppercase tracking-widest mb-2">Permission Slug (Admin Only)</label>
                    <input type="text" name="permission_slug" class="w-full bg-gray-50 border border-gray-100 rounded-2xl px-4 py-3 text-sm focus:ring-2 focus:ring-red-500 transition outline-none" value="{{ old('permission_slug', $menu->permission_slug) }}" placeholder="users_view">
                </div>

                <div class="md:col-span-2">
                    <label class="flex items-center gap-2 cursor-pointer">
                        <input type="checkbox" name="is_active" value="1" {{ $menu->is_active ? 'checked' : '' }} class="w-4 h-4 text-red-600 border-gray-300 rounded focus:ring-red-500">
                        <span class="text-gray-700 text-sm font-bold">Aktifkan Menu</span>
                    </label>
                </div>
            </div>

            <div class="mt-12 flex justify-end gap-4">
                <a href="{{ route('menus.index') }}" 
                   class="bg-gray-100 dark:bg-slate-800 text-gray-600 dark:text-gray-400 px-8 py-4 rounded-[2rem] font-black text-xs uppercase tracking-[0.2em] hover:bg-gray-200 dark:hover:bg-slate-700 transition-all flex items-center justify-center">
                    Batal
                </a>
                <button type="submit" 
                        class="bg-gray-900 dark:bg-red-700 text-white px-8 py-4 rounded-[2rem] font-black text-xs uppercase tracking-[0.2em] hover:scale-[1.02] transition-all shadow-xl flex items-center justify-center group">
                    <span>Perbarui Menu</span>
                    <i class="fas fa-save ml-3 group-hover:translate-x-1 transition-transform"></i>
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
