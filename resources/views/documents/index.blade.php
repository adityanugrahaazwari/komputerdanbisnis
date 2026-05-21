@extends('layouts.app')

@section('header', 'Manajemen Dokumen')

@section('content')
<div class="bg-white rounded-[2rem] shadow-sm border border-gray-100 p-8">
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 mb-8">
        <div>
            <h3 class="text-xl font-black text-gray-900 uppercase tracking-tight">Pusat Unduhan</h3>
            <p class="text-gray-500 text-sm">Kelola file PDF, Dokumen, dan file lainnya untuk diunduh publik.</p>
        </div>
        @can('documents_create')
            <a href="{{ route('documents.create') }}" class="bg-red-700 text-white px-6 py-3 rounded-2xl font-bold text-sm hover:bg-red-800 transition flex items-center shadow-lg shadow-red-200">
                <i class="fas fa-file-upload mr-2"></i> Upload Dokumen
            </a>
        @endcan
    </div>

    <div class="overflow-x-auto">
        <table class="w-full text-left">
            <thead>
                <tr class="border-b border-gray-50">
                    <th class="py-4 px-4 text-xs font-black text-gray-400 uppercase tracking-widest">Judul & Kategori</th>
                    <th class="py-4 px-4 text-xs font-black text-gray-400 uppercase tracking-widest text-center">Tipe File</th>
                    <th class="py-4 px-4 text-xs font-black text-gray-400 uppercase tracking-widest">Tgl Upload</th>
                    <th class="py-4 px-4 text-xs font-black text-gray-400 uppercase tracking-widest text-center">Status</th>
                    <th class="py-4 px-4 text-xs font-black text-gray-400 uppercase tracking-widest text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50">
                @foreach($documents as $doc)
                    <tr class="group hover:bg-gray-50 transition-colors">
                        <td class="py-4 px-4">
                            <p class="font-bold text-gray-900 group-hover:text-red-700 transition">{{ $doc->title }}</p>
                            <span class="text-[10px] font-black uppercase tracking-widest text-gray-400">{{ $doc->category ?? 'Umum' }}</span>
                        </td>
                        <td class="py-4 px-4 text-center">
                            @php
                                $ext = pathinfo($doc->file_path, PATHINFO_EXTENSION);
                                $icon = match($ext) {
                                    'pdf' => 'fa-file-pdf text-red-600',
                                    'doc', 'docx' => 'fa-file-word text-blue-600',
                                    'xls', 'xlsx' => 'fa-file-excel text-green-600',
                                    'ppt', 'pptx' => 'fa-file-powerpoint text-orange-600',
                                    'zip', 'rar' => 'fa-file-archive text-purple-600',
                                    default => 'fa-file text-gray-400'
                                };
                            @endphp
                            <i class="fas {{ $icon }} text-xl"></i>
                            <p class="text-[8px] font-bold uppercase mt-1 text-gray-400">{{ strtoupper($ext) }}</p>
                        </td>
                        <td class="py-4 px-4 text-sm text-gray-500">
                            {{ $doc->created_at->format('d/m/Y') }}
                        </td>
                        <td class="py-4 px-4 text-center">
                            <span class="text-[10px] font-black px-3 py-1 rounded-full uppercase tracking-widest {{ $doc->is_active ? 'bg-green-50 text-green-600' : 'bg-red-50 text-red-600' }}">
                                {{ $doc->is_active ? 'Aktif' : 'Non-aktif' }}
                            </span>
                        </td>
                        <td class="py-4 px-4 text-right">
                            <div class="flex justify-end gap-2">
                                <a href="{{ asset('storage/' . $doc->file_path) }}" target="_blank" class="w-8 h-8 rounded-lg bg-gray-100 flex items-center justify-center text-gray-500 hover:bg-red-600 hover:text-white transition" title="Lihat">
                                    <i class="fas fa-eye text-xs"></i>
                                </a>
                                @can('documents_edit')
                                    <a href="{{ route('documents.edit', $doc->id) }}" class="w-8 h-8 rounded-lg bg-gray-100 flex items-center justify-center text-gray-500 hover:bg-blue-600 hover:text-white transition" title="Edit">
                                        <i class="fas fa-edit text-xs"></i>
                                    </a>
                                @endcan
                                @can('documents_delete')
                                    <form action="{{ route('documents.destroy', $doc->id) }}" method="POST" class="inline" onsubmit="return confirm('Hapus dokumen?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="w-8 h-8 rounded-lg bg-gray-100 flex items-center justify-center text-gray-500 hover:bg-red-600 hover:text-white transition" title="Hapus">
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
        {{ $documents->links() }}
    </div>
</div>
@endsection
