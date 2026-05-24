@extends('layouts.app')

@section('header', 'Manajemen Dosen & Staf')

@section('content')
<div class="bg-white rounded-[2rem] shadow-sm border border-gray-100 p-8">
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 mb-8">
        <div>
            <h3 class="text-xl font-black text-gray-900 uppercase tracking-tight">Direktori Dosen & Staf</h3>
            <p class="text-gray-500 text-sm">Kelola data pengajar dan staf kependidikan.</p>
        </div>
        @can('lecturers_create')
            <a href="{{ route('lecturers.create') }}" class="bg-red-700 text-white px-6 py-3 rounded-2xl font-bold text-sm hover:bg-red-800 transition flex items-center shadow-lg shadow-red-200">
                <i class="fas fa-plus mr-2"></i> Tambah Dosen/Staf
            </a>
        @endcan
    </div>

    <div class="overflow-x-auto">
        <table class="w-full text-left">
            <thead>
                <tr class="border-b border-gray-50">
                    <th class="py-4 px-4 text-xs font-black text-gray-400 uppercase tracking-widest text-center">Foto</th>
                    <th class="py-4 px-4 text-xs font-black text-gray-400 uppercase tracking-widest">Nama / NIP</th>
                    <th class="py-4 px-4 text-xs font-black text-gray-400 uppercase tracking-widest">Jabatan / Keahlian</th>
                    <th class="py-4 px-4 text-xs font-black text-gray-400 uppercase tracking-widest">Prodi</th>
                    <th class="py-4 px-4 text-xs font-black text-gray-400 uppercase tracking-widest text-center">Status</th>
                    <th class="py-4 px-4 text-xs font-black text-gray-400 uppercase tracking-widest text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50">
                @foreach($lecturers as $lecturer)
                <tr class="group hover:bg-gray-50 transition-all">
                    <td class="py-4 px-4">
                        <div class="flex justify-center">
                            @if($lecturer->photo)
                                <img src="{{ asset('storage/' . $lecturer->photo) }}" class="w-10 h-10 rounded-full object-cover border-2 border-white shadow-sm">
                            @else
                                <div class="w-10 h-10 rounded-full bg-red-50 flex items-center justify-center text-red-300">
                                    <i class="fas fa-user text-xs"></i>
                                </div>
                            @endif
                        </div>
                    </td>
                    <td class="py-4 px-4">
                        <p class="font-bold text-gray-900 group-hover:text-red-700 transition">{{ $lecturer->name }}</p>
                        <span class="text-[10px] text-gray-400">NIP: {{ $lecturer->nip ?? '-' }}</span>
                    </td>
                    <td class="py-4 px-4">
                        <p class="text-xs font-bold text-gray-700">{{ $lecturer->position ?? '-' }}</p>
                        <p class="text-[10px] text-gray-500">{{ $lecturer->expertise ?? '-' }}</p>
                    </td>
                    <td class="py-4 px-4">
                        <span class="text-xs font-medium text-gray-600">{{ $lecturer->studyProgram->name ?? 'Semua Prodi' }}</span>
                    </td>
                    <td class="py-4 px-4 text-center">
                        <span class="{{ $lecturer->is_active ? 'bg-green-50 text-green-600' : 'bg-red-50 text-red-600' }} rounded-full px-3 py-1 text-[10px] font-black uppercase tracking-widest border border-black/5">
                            {{ $lecturer->is_active ? 'Aktif' : 'Nonaktif' }}
                        </span>
                    </td>
                    <td class="py-4 px-4 text-right">
                        <div class="flex justify-end items-center gap-2">
                            @can('lecturers_edit')
                                <a href="{{ route('lecturers.edit', $lecturer->id) }}" class="w-8 h-8 rounded-lg bg-gray-100 flex items-center justify-center text-blue-600 hover:bg-blue-600 hover:text-white transition shadow-sm" title="Edit">
                                    <i class="fas fa-edit text-xs"></i>
                                </a>
                            @endcan
                            @can('lecturers_delete')
                                <form action="{{ route('lecturers.destroy', $lecturer->id) }}" method="POST" class="inline" onsubmit="return confirm('Hapus data ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="w-8 h-8 rounded-lg bg-gray-100 flex items-center justify-center text-red-600 hover:bg-red-600 hover:text-white transition shadow-sm" title="Hapus">
                                        <i class="fas fa-trash text-xs"></i>
                                    </button>
                                </form>
                            @endcan
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="mt-8">
        {{ $lecturers->links() }}
    </div>
</div>
@endsection
