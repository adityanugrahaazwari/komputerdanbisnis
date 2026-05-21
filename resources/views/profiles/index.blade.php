@extends('layouts.app')

@section('header', 'Manajemen Profil Web')

@section('content')
<div class="bg-white dark:bg-slate-900 rounded-[2rem] shadow-xl p-8 md:p-10 border border-gray-100 dark:border-slate-800">
    <div class="flex flex-col md:flex-row justify-between items-center mb-10 gap-6">
        <div>
            <h3 class="text-2xl font-black text-gray-900 dark:text-white uppercase tracking-tight">Konten Profil Web</h3>
            <p class="text-gray-500 dark:text-gray-400 text-sm">Kelola konten statis seperti Visi, Misi, dan Sejarah.</p>
        </div>
    </div>

    <div class="overflow-hidden rounded-3xl border border-gray-100 dark:border-slate-800 shadow-sm">
        <table class="min-w-full divide-y divide-gray-200 dark:divide-slate-800">
            <thead class="bg-gray-50 dark:bg-slate-800">
                <tr>
                    <th class="px-6 py-4 text-left text-xs font-black text-gray-500 dark:text-gray-400 uppercase tracking-[0.2em]">Bagian</th>
                    <th class="px-6 py-4 text-left text-xs font-black text-gray-500 dark:text-gray-400 uppercase tracking-[0.2em]">Judul Halaman</th>
                    <th class="px-6 py-4 text-left text-xs font-black text-gray-500 dark:text-gray-400 uppercase tracking-[0.2em]">Terakhir Diupdate</th>
                    <th class="px-6 py-4 text-center text-xs font-black text-gray-500 dark:text-gray-400 uppercase tracking-[0.2em]">Aksi</th>
                </tr>
            </thead>
            <tbody class="bg-white dark:bg-slate-900 divide-y divide-gray-100 dark:divide-slate-800">
                @foreach($profiles as $profile)
                @if($profile->key === 'structure')
                    @continue {{-- We skip this because it's managed in the new tree CRUD --}}
                @endif
                <tr class="hover:bg-red-50/30 dark:hover:bg-red-900/5 transition-colors group">
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span class="px-3 py-1 bg-red-100 dark:bg-red-900/30 text-red-700 dark:text-red-400 text-[10px] font-black rounded-full uppercase tracking-tighter border border-red-200 dark:border-red-900/50">
                            {{ $profile->key }}
                        </span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm font-bold text-gray-900 dark:text-white">{{ $profile->title }}</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-xs text-gray-500 dark:text-gray-400">{{ $profile->updated_at->format('d M Y, H:i') }}</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-medium">
                        <div class="flex justify-center">
                            @can('profiles_edit')
                                <a href="{{ route('profiles.edit', $profile->id) }}" class="w-10 h-10 rounded-xl bg-gray-100 dark:bg-slate-800 flex items-center justify-center text-blue-600 hover:bg-blue-600 hover:text-white transition shadow-sm" title="Edit Konten">
                                    <i class="fas fa-edit text-sm"></i>
                                </a>
                            @endcan
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    {{-- Info Box for Structure --}}
    <div class="mt-8 p-6 bg-blue-50 dark:bg-blue-900/10 border border-blue-100 dark:border-blue-900/30 rounded-3xl flex items-center justify-between">
        <div class="flex items-center gap-4">
            <div class="w-12 h-12 bg-blue-100 dark:bg-blue-900/30 rounded-2xl flex items-center justify-center text-blue-600 dark:text-blue-400">
                <i class="fas fa-sitemap text-xl"></i>
            </div>
            <div>
                <h4 class="text-sm font-black text-blue-900 dark:text-blue-400 uppercase tracking-tight">Manajemen Struktur Organisasi</h4>
                <p class="text-xs text-blue-700 dark:text-blue-500 font-medium">Struktur organisasi sekarang dikelola menggunakan sistem hierarki (Tree).</p>
            </div>
        </div>
        <a href="{{ route('organizational-structures.index') }}" class="px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white rounded-xl font-black text-[10px] uppercase tracking-[0.2em] transition">
            Buka Manajemen Struktur
        </a>
    </div>
</div>
@endsection
