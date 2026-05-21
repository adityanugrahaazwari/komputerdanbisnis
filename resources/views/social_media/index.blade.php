@extends('layouts.app')

@section('header', 'Manajemen Sosial Media')

@section('content')
<div class="bg-white rounded shadow p-6">
    <div class="flex justify-between mb-4">
        <h3 class="text-lg font-semibold">Daftar Sosial Media</h3>
        @can('social_media_create')
            <a href="{{ route('social_media.create') }}" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded">Tambah Sosial Media</a>
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
                <th class="py-2 px-4 border-b text-left">Platform</th>
                <th class="py-2 px-4 border-b text-left">URL</th>
                <th class="py-2 px-4 border-b text-center">Icon</th>
                <th class="py-2 px-4 border-b text-center">Status</th>
                <th class="py-2 px-4 border-b">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($socials as $social)
            <tr>
                <td class="py-2 px-4 border-b font-bold">{{ $social->platform }}</td>
                <td class="py-2 px-4 border-b text-sm text-blue-600 truncate max-w-xs">{{ $social->url }}</td>
                <td class="py-2 px-4 border-b text-center"><i class="{{ $social->icon }} text-xl"></i></td>
                <td class="py-2 px-4 border-b text-center">
                    <span class="{{ $social->is_active ? 'bg-green-200 text-green-800' : 'bg-red-200 text-red-800' }} rounded px-2 py-1 text-xs">
                        {{ $social->is_active ? 'Aktif' : 'Non-Aktif' }}
                    </span>
                </td>
                <td class="py-2 px-4 border-b text-center">
                    @can('social_media_edit')
                        <a href="{{ route('social_media.edit', $social->id) }}" class="text-blue-500 hover:underline mr-2">Edit</a>
                    @endcan
                    @can('social_media_delete')
                        <form action="{{ route('social_media.destroy', $social->id) }}" method="POST" class="inline" onsubmit="return confirm('Hapus sosial media ini?')">
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
</div>
@endsection
