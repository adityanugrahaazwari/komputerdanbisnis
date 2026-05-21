@extends('layouts.app')

@section('header', 'Manajemen Profil Web')

@section('content')
<div class="bg-white rounded shadow p-6">
    <div class="mb-4">
        <h3 class="text-lg font-semibold">Daftar Bagian Profil</h3>
        <p class="text-gray-600 text-sm">Kelola konten Visi, Misi, Sejarah, dan Struktur Organisasi untuk landing page.</p>
    </div>

    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    <table class="min-w-full bg-white border">
        <thead>
            <tr>
                <th class="py-2 px-4 border-b text-left">Bagian</th>
                <th class="py-2 px-4 border-b text-left">Judul Halaman</th>
                <th class="py-2 px-4 border-b text-left">Terakhir Diupdate</th>
                <th class="py-2 px-4 border-b">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($profiles as $profile)
            <tr>
                <td class="py-2 px-4 border-b font-bold">{{ ucfirst($profile->key) }}</td>
                <td class="py-2 px-4 border-b">{{ $profile->title }}</td>
                <td class="py-2 px-4 border-b text-sm text-gray-500">{{ $profile->updated_at->format('d M Y, H:i') }}</td>
                <td class="py-2 px-4 border-b text-center">
                    @can('profiles_edit')
                        <a href="{{ route('profiles.edit', $profile->id) }}" class="bg-blue-500 hover:bg-blue-600 text-white px-3 py-1 rounded text-sm">Edit Konten</a>
                    @endcan
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
