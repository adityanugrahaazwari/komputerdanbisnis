@extends('layouts.app')

@section('header', 'Pencadangan Data')

@section('content')
<div class="bg-white dark:bg-slate-900 rounded-[2.5rem] p-8 shadow-sm border border-gray-100 dark:border-slate-800">
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-6 mb-8">
        <div>
            <h3 class="text-xl font-black text-gray-900 dark:text-white uppercase tracking-tight">Manajemen Backup Database</h3>
            <p class="text-gray-500 dark:text-gray-400 text-sm font-medium">Cadangkan data Anda secara berkala untuk mencegah kehilangan data.</p>
        </div>
        
        <form action="{{ route('backups.create') }}" method="POST">
            @csrf
            <button type="submit" class="bg-gray-900 dark:bg-red-700 text-white px-8 py-4 rounded-2xl font-black text-xs uppercase tracking-[0.2em] hover:scale-[1.02] transition-all shadow-lg flex items-center group">
                <i class="fas fa-database mr-3 group-hover:rotate-12 transition-transform"></i>
                Buat Backup Baru
            </button>
        </form>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full text-left border-separate border-spacing-y-4">
            <thead>
                <tr class="text-[10px] font-black text-gray-400 uppercase tracking-[0.2em]">
                    <th class="px-6 py-3">Nama File</th>
                    <th class="px-6 py-3">Ukuran</th>
                    <th class="px-6 py-3">Tanggal Dibuat</th>
                    <th class="px-6 py-3 text-right">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($backups as $backup)
                <tr class="bg-gray-50 dark:bg-slate-800/50 rounded-2xl">
                    <td class="px-6 py-4 rounded-l-2xl">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 bg-white dark:bg-slate-700 rounded-xl flex items-center justify-center text-red-600 shadow-sm">
                                <i class="fas fa-file-code"></i>
                            </div>
                            <span class="font-bold text-gray-900 dark:text-white text-sm">{{ $backup['name'] }}</span>
                        </div>
                    </td>
                    <td class="px-6 py-4 italic text-gray-500 dark:text-gray-400 text-sm font-medium">
                        {{ $backup['size'] }}
                    </td>
                    <td class="px-6 py-4 text-gray-500 dark:text-gray-400 text-sm font-medium">
                        {{ $backup['date'] }}
                    </td>
                    <td class="px-6 py-4 rounded-r-2xl text-right">
                        <div class="flex justify-end gap-2">
                            <a href="{{ route('backups.download', $backup['name']) }}" class="p-3 bg-white dark:bg-slate-700 text-blue-600 rounded-xl shadow-sm hover:scale-110 transition-transform" title="Download">
                                <i class="fas fa-download"></i>
                            </a>
                            <form action="{{ route('backups.destroy', $backup['name']) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus backup ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="p-3 bg-white dark:bg-slate-700 text-red-600 rounded-xl shadow-sm hover:scale-110 transition-transform" title="Hapus">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="text-center py-12 bg-gray-50 dark:bg-slate-800/50 rounded-2xl italic text-gray-400">
                        Belum ada file backup yang tersedia.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<div class="mt-8 grid grid-cols-1 md:grid-cols-2 gap-8">
    <div class="bg-blue-50 dark:bg-blue-900/20 border border-blue-100 dark:border-blue-800 rounded-3xl p-6">
        <div class="flex gap-4">
            <i class="fas fa-info-circle text-blue-600 mt-1"></i>
            <div>
                <h4 class="text-sm font-black text-blue-900 dark:text-blue-300 uppercase tracking-tight mb-1">Tips Keamanan</h4>
                <p class="text-xs text-blue-700 dark:text-blue-400 leading-relaxed font-medium">
                    Selalu unduh file backup ke komputer lokal atau cloud storage Anda setelah dibuat. Jangan biarkan terlalu banyak file backup menumpuk di server untuk menghemat ruang penyimpanan.
                </p>
            </div>
        </div>
    </div>
    
    <div class="bg-amber-50 dark:bg-amber-900/20 border border-amber-100 dark:border-amber-800 rounded-3xl p-6">
        <div class="flex gap-4">
            <i class="fas fa-exclamation-triangle text-amber-600 mt-1"></i>
            <div>
                <h4 class="text-sm font-black text-amber-900 dark:text-amber-300 uppercase tracking-tight mb-1">Catatan Penting</h4>
                <p class="text-xs text-amber-700 dark:text-amber-400 leading-relaxed font-medium">
                    Fitur restore saat ini hanya dapat dilakukan secara manual oleh tim teknis melalui phpMyAdmin untuk memastikan integritas data tetap terjaga. Hubungi admin sistem jika Anda perlu memulihkan data.
                </p>
            </div>
        </div>
    </div>
</div>
@endsection
