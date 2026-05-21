@extends('layouts.app')

@section('header', 'Inbox Pesan')

@section('content')
<div class="bg-white rounded-[2rem] shadow-sm border border-gray-100 p-8">
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 mb-8">
        <div>
            <h3 class="text-xl font-black text-gray-900 uppercase tracking-tight">Pesan Masuk</h3>
            <p class="text-gray-500 text-sm">Kelola pesan dan pertanyaan dari pengunjung website.</p>
        </div>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full text-left">
            <thead>
                <tr class="border-b border-gray-50">
                    <th class="py-4 px-6 text-xs font-black text-gray-400 uppercase tracking-widest text-center">Status</th>
                    <th class="py-4 px-6 text-xs font-black text-gray-400 uppercase tracking-widest">Pengirim</th>
                    <th class="py-4 px-6 text-xs font-black text-gray-400 uppercase tracking-widest">Subjek</th>
                    <th class="py-4 px-6 text-xs font-black text-gray-400 uppercase tracking-widest">Tanggal</th>
                    <th class="py-4 px-6 text-xs font-black text-gray-400 uppercase tracking-widest text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50">
                @foreach($contacts as $contact)
                <tr class="group hover:bg-gray-50 transition-all duration-200 {{ $contact->is_read ? 'opacity-75' : 'font-bold' }}">
                    <td class="py-4 px-6 text-center">
                        @if($contact->is_read)
                            <span class="w-8 h-8 rounded-full bg-gray-100 flex items-center justify-center text-gray-400 mx-auto" title="Sudah Dibaca">
                                <i class="fas fa-envelope-open text-xs"></i>
                            </span>
                        @else
                            <span class="w-8 h-8 rounded-full bg-blue-50 flex items-center justify-center text-blue-600 mx-auto animate-pulse" title="Pesan Baru">
                                <i class="fas fa-envelope text-xs"></i>
                            </span>
                        @endif
                    </td>
                    <td class="py-4 px-6">
                        <p class="text-sm text-gray-900">{{ $contact->name }}</p>
                        <p class="text-[10px] text-gray-400 font-medium">{{ $contact->email ?? '' }}</p>
                    </td>
                    <td class="py-4 px-6">
                        <p class="text-sm text-gray-800 line-clamp-1">{{ $contact->subject }}</p>
                    </td>
                    <td class="py-4 px-6">
                        <p class="text-xs text-gray-500">{{ $contact->created_at->format('d M Y') }}</p>
                        <p class="text-[10px] text-gray-400">{{ $contact->created_at->format('H:i') }}</p>
                    </td>
                    <td class="py-4 px-6 text-right">
                        <div class="flex justify-end items-center gap-2">
                            <a href="{{ route('contacts.show', $contact->id) }}" class="w-8 h-8 rounded-lg bg-gray-100 flex items-center justify-center text-blue-600 hover:bg-blue-600 hover:text-white transition shadow-sm" title="Buka Pesan">
                                <i class="fas fa-folder-open text-xs"></i>
                            </a>
                            
                            @can('contacts_delete')
                                <form action="{{ route('contacts.destroy', $contact->id) }}" method="POST" class="inline" onsubmit="return confirm('Hapus pesan ini?')">
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
        {{ $contacts->links() }}
    </div>
</div>
@endsection
