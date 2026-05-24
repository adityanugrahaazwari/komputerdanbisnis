@extends('layouts.app')

@section('header', 'Manajemen Testimoni')

@section('content')
<div class="bg-white rounded-[2rem] shadow-sm border border-gray-100 p-8">
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 mb-8">
        <div>
            <h3 class="text-xl font-black text-gray-900 uppercase tracking-tight">Daftar Testimoni</h3>
            <p class="text-gray-500 text-sm">Kelola testimoni dari alumni dan mitra industri.</p>
        </div>
        @can('testimonials_create')
            <a href="{{ route('testimonials.create') }}" class="bg-red-700 text-white px-6 py-3 rounded-2xl font-bold text-sm hover:bg-red-800 transition flex items-center shadow-lg shadow-red-200">
                <i class="fas fa-plus mr-2"></i> Tambah Testimoni
            </a>
        @endcan
    </div>

    <div class="overflow-x-auto">
        <table class="w-full text-left">
            <thead>
                <tr class="border-b border-gray-50">
                    <th class="py-4 px-4 text-xs font-black text-gray-400 uppercase tracking-widest">Pemberi Testimoni</th>
                    <th class="py-4 px-4 text-xs font-black text-gray-400 uppercase tracking-widest">Jabatan / Perusahaan</th>
                    <th class="py-4 px-4 text-xs font-black text-gray-400 uppercase tracking-widest">Isi Testimoni</th>
                    <th class="py-4 px-4 text-xs font-black text-gray-400 uppercase tracking-widest text-center">Status</th>
                    <th class="py-4 px-4 text-xs font-black text-gray-400 uppercase tracking-widest text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50">
                @foreach($testimonials as $testimonial)
                <tr class="group hover:bg-gray-50 transition-all">
                    <td class="py-4 px-4">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-full bg-gray-100 overflow-hidden flex-shrink-0">
                                @if($testimonial->image)
                                    <img src="{{ asset('storage/' . $testimonial->image) }}" alt="{{ $testimonial->name }}" class="w-full h-full object-cover">
                                @else
                                    <div class="w-full h-full flex items-center justify-center text-gray-400 bg-gray-200">
                                        <i class="fas fa-user"></i>
                                    </div>
                                @endif
                            </div>
                            <p class="font-bold text-gray-900 group-hover:text-red-700 transition">{{ $testimonial->name }}</p>
                        </div>
                    </td>
                    <td class="py-4 px-4">
                        <p class="text-sm text-gray-600 font-medium">{{ $testimonial->role }}</p>
                        <p class="text-xs text-gray-400 italic">{{ $testimonial->company }}</p>
                    </td>
                    <td class="py-4 px-4">
                        <p class="text-xs text-gray-500 line-clamp-2 max-w-xs">{{ $testimonial->quote }}</p>
                    </td>
                    <td class="py-4 px-4 text-center">
                        <span class="{{ $testimonial->is_active ? 'bg-green-50 text-green-600 border-green-100' : 'bg-red-50 text-red-600 border-red-100' }} rounded-full px-3 py-1 text-[10px] font-black uppercase tracking-widest border">
                            {{ $testimonial->is_active ? 'Aktif' : 'Non-Aktif' }}
                        </span>
                    </td>
                    <td class="py-4 px-4 text-right">
                        <div class="flex justify-end items-center gap-2">
                            @can('testimonials_edit')
                                <a href="{{ route('testimonials.edit', $testimonial->id) }}" class="w-8 h-8 rounded-lg bg-gray-100 flex items-center justify-center text-blue-600 hover:bg-blue-600 hover:text-white transition shadow-sm" title="Edit">
                                    <i class="fas fa-edit text-xs"></i>
                                </a>
                            @endcan
                            @can('testimonials_delete')
                                <form action="{{ route('testimonials.destroy', $testimonial->id) }}" method="POST" class="inline" onsubmit="return confirm('Hapus testimoni ini?')">
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
        {{ $testimonials->links() }}
    </div>
</div>
@endsection
