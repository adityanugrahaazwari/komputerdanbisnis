@extends('layouts.app')

@section('header', 'Manajemen Program Studi')

@section('content')
<div class="bg-white rounded-[2rem] shadow-sm border border-gray-100 p-8">
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 mb-8">
        <div>
            <h3 class="text-xl font-black text-gray-900 uppercase tracking-tight">Daftar Program Studi</h3>
            <p class="text-gray-500 text-sm">Kelola informasi program studi yang tersedia.</p>
        </div>
        @can('study_programs_create')
            <a href="{{ route('study_programs.create') }}" class="bg-red-700 text-white px-6 py-3 rounded-2xl font-bold text-sm hover:bg-red-800 transition flex items-center shadow-lg shadow-red-200">
                <i class="fas fa-plus mr-2"></i> Tambah Prodi
            </a>
        @endcan
    </div>

    <div class="overflow-x-auto">
        <table class="w-full text-left">
            <thead>
                <tr class="border-b border-gray-50">
                    <th class="py-4 px-4 text-xs font-black text-gray-400 uppercase tracking-widest">Kode</th>
                    <th class="py-4 px-4 text-xs font-black text-gray-400 uppercase tracking-widest">Nama Program Studi</th>
                    <th class="py-4 px-4 text-xs font-black text-gray-400 uppercase tracking-widest">Jenjang</th>
                    <th class="py-4 px-4 text-xs font-black text-gray-400 uppercase tracking-widest text-center">Status</th>
                    <th class="py-4 px-4 text-xs font-black text-gray-400 uppercase tracking-widest text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50">
                @foreach($studyPrograms as $prodi)
                <tr class="group hover:bg-gray-50 transition-all">
                    <td class="py-4 px-4 text-sm font-mono text-gray-500">{{ $prodi->code ?: '-' }}</td>
                    <td class="py-4 px-4">
                        <p class="font-bold text-gray-900 group-hover:text-red-700 transition">{{ $prodi->name }}</p>
                    </td>
                    <td class="py-4 px-4 text-sm text-gray-600">{{ $prodi->level ?: '-' }}</td>
                    <td class="py-4 px-4 text-center">
                        <span class="{{ $prodi->is_active ? 'bg-green-50 text-green-600 border-green-100' : 'bg-red-50 text-red-600 border-red-100' }} rounded-full px-3 py-1 text-[10px] font-black uppercase tracking-widest border">
                            {{ $prodi->is_active ? 'Aktif' : 'Non-Aktif' }}
                        </span>
                    </td>
                    <td class="py-4 px-4 text-right">
                        <div class="flex justify-end items-center gap-2">
                            @can('study_programs_edit')
                                <a href="{{ route('study_programs.edit', $prodi->id) }}" class="w-8 h-8 rounded-lg bg-gray-100 flex items-center justify-center text-blue-600 hover:bg-blue-600 hover:text-white transition shadow-sm" title="Edit">
                                    <i class="fas fa-edit text-xs"></i>
                                </a>
                            @endcan
                            @can('study_programs_delete')
                                <form action="{{ route('study_programs.destroy', $prodi->id) }}" method="POST" class="inline" onsubmit="return confirm('Hapus Program Studi ini?')">
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
        {{ $studyPrograms->links() }}
    </div>
</div>
@endsection
