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
            <x-admin.button href="{{ route('lecturers.create') }}">
                <i class="fas fa-plus mr-2"></i> Tambah Dosen/Staf
            </x-admin.button>
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
                        <x-admin.badge :variant="$lecturer->is_active ? 'green' : 'red'">
                            {{ $lecturer->is_active ? 'Aktif' : 'Nonaktif' }}
                        </x-admin.badge>
                    </td>
                    <td class="py-4 px-4 text-right">
                        <div class="flex justify-end items-center gap-2">
                            @can('lecturers_edit')
                                <x-admin.action-button variant="edit" href="{{ route('lecturers.edit', $lecturer->id) }}" title="Edit" />
                            @endcan
                            @can('lecturers_delete')
                                <form action="{{ route('lecturers.destroy', $lecturer->id) }}" method="POST" class="inline" onsubmit="return confirm('Hapus data ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <x-admin.action-button type="button" variant="delete" title="Hapus" />
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
