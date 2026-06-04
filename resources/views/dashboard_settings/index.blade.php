@extends('layouts.app')

@section('header', 'Pengaturan Dashboard')

@section('content')
<div class="bg-white dark:bg-slate-900 rounded-[2.5rem] p-8 shadow-sm border border-gray-100 dark:border-slate-800">
    <div class="mb-8">
        <h3 class="text-xl font-black text-gray-900 dark:text-white uppercase tracking-tight">Kustomisasi Dashboard per Role</h3>
        <p class="text-gray-500 dark:text-gray-400 text-sm font-medium">Atur bagian mana saja yang ingin ditampilkan di halaman depan dashboard untuk setiap peran pengguna.</p>
    </div>

    <form action="{{ route('dashboard-settings.update') }}" method="POST">
        @csrf
        @method('PUT')

        <div class="overflow-x-auto">
            <table class="w-full text-left border-separate border-spacing-y-4">
                <thead>
                    <tr class="text-[10px] font-black text-gray-400 uppercase tracking-[0.2em]">
                        <th class="px-6 py-3">Peran (Role)</th>
                        <th class="px-4 py-3 text-center">Quick Actions</th>
                        <th class="px-4 py-3 text-center">Statistik</th>
                        <th class="px-4 py-3 text-center">Chart</th>
                        <th class="px-4 py-3 text-center">Agenda</th>
                        <th class="px-4 py-3 text-center">Berita Populer</th>
                        <th class="px-4 py-3 text-center">To-Do List</th>
                        <th class="px-4 py-3 text-center">Server Info</th>
                        <th class="px-4 py-3 text-center">Log</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($roles as $role)
                    <tr class="bg-gray-50 dark:bg-slate-800/50 rounded-2xl">
                        <td class="px-6 py-4 rounded-l-2xl">
                            <span class="font-bold text-gray-900 dark:text-white uppercase tracking-tighter text-sm">{{ $role->name }}</span>
                            <p class="text-[9px] text-gray-400 font-bold uppercase tracking-widest mt-1">{{ $role->slug }}</p>
                        </td>
                        
                        @php
                            $s = $role->dashboardSetting;
                            $fields = [
                                'show_quick_actions' => 'Aksi Cepat',
                                'show_stats' => 'Statistik',
                                'show_announcements' => 'Pengumuman',
                                'show_upcoming_events' => 'Agenda',
                                'show_popular_posts' => 'Populer',
                                'show_todo_list' => 'To-Do',
                                'show_server_status' => 'Server',
                                'show_system_logs' => 'Log',
                            ];
                        @endphp

                        @foreach($fields as $field => $label)
                        <td class="px-4 py-4 text-center">
                            <label class="inline-flex items-center cursor-pointer" title="{{ $label }}">
                                <input type="checkbox" name="settings[{{ $role->id }}][{{ $field }}]" value="1" {{ $s && $s->$field ? 'checked' : '' }} class="sr-only peer">
                                <div class="w-9 h-5 bg-gray-200 dark:bg-slate-700 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-4 after:w-4 after:transition-all peer-checked:bg-red-600 relative"></div>
                            </label>
                        </td>
                        @endforeach
                        <td class="rounded-r-2xl"></td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="mt-8 flex justify-end">
            <button type="submit" class="bg-gray-900 dark:bg-red-700 text-white px-10 py-4 rounded-2xl font-black text-xs uppercase tracking-[0.2em] hover:scale-[1.02] transition-all shadow-lg flex items-center group">
                <i class="fas fa-save mr-3 group-hover:rotate-12 transition-transform"></i>
                Simpan Konfigurasi
            </button>
        </div>
    </form>
</div>

<div class="mt-8 bg-blue-50 dark:bg-blue-900/20 border border-blue-100 dark:border-blue-800 rounded-3xl p-6">
    <div class="flex gap-4">
        <i class="fas fa-info-circle text-blue-600 mt-1"></i>
        <div>
            <h4 class="text-sm font-black text-blue-900 dark:text-blue-300 uppercase tracking-tight mb-1">Informasi Pengaturan</h4>
            <p class="text-xs text-blue-700 dark:text-blue-400 leading-relaxed font-medium">
                Perubahan pada pengaturan ini akan langsung berdampak pada tampilan dashboard pengguna sesuai dengan peran mereka masing-masing. Gunakan pengaturan ini untuk menyederhanakan workflow staf Anda.
            </p>
        </div>
    </div>
</div>
@endsection
