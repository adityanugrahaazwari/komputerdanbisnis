@extends('layouts.app')

@section('header', 'Manajemen Program Studi')

@section('content')
<div class="bg-white rounded shadow p-6">
    <div class="flex justify-between mb-4">
        <h3 class="text-lg font-semibold">Daftar Program Studi</h3>
        @can('study_programs_create')
            <a href="{{ route('study_programs.create') }}" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded">Tambah Prodi</a>
        @endcan
    </div>

    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    <table class="min-w-full bg-white border">
        <thead>
            <tr>
                <th class="py-2 px-4 border-b text-left">Kode</th>
                <th class="py-2 px-4 border-b text-left">Nama Program Studi</th>
                <th class="py-2 px-4 border-b text-left">Jenjang</th>
                <th class="py-2 px-4 border-b text-center">Status</th>
                <th class="py-2 px-4 border-b">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($studyPrograms as $prodi)
            <tr>
                <td class="py-2 px-4 border-b">{{ $prodi->code ?: '-' }}</td>
                <td class="py-2 px-4 border-b font-bold">{{ $prodi->name }}</td>
                <td class="py-2 px-4 border-b">{{ $prodi->level ?: '-' }}</td>
                <td class="py-2 px-4 border-b text-center">
                    <span class="{{ $prodi->is_active ? 'bg-green-200 text-green-800' : 'bg-red-200 text-red-800' }} rounded px-2 py-1 text-xs">
                        {{ $prodi->is_active ? 'Aktif' : 'Non-Aktif' }}
                    </span>
                </td>
                <td class="py-2 px-4 border-b text-center">
                    @can('study_programs_edit')
                        <a href="{{ route('study_programs.edit', $prodi->id) }}" class="text-blue-500 hover:underline mr-2">Edit</a>
                    @endcan
                    @can('study_programs_delete')
                        <form action="{{ route('study_programs.destroy', $prodi->id) }}" method="POST" class="inline" onsubmit="return confirm('Hapus Program Studi ini?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-500 hover:underline">Hapus</button>
                        </form>
                    @endcan
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    <div class="mt-4">
        {{ $studyPrograms->links() }}
    </div>
</div>
@endsection
