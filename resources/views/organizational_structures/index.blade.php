@extends('layouts.app')

@section('header', 'Organizational Structure')

@section('content')
<div class="bg-white dark:bg-slate-900 rounded-[2rem] shadow-xl p-8 md:p-10 border border-gray-100 dark:border-slate-800">
    <div class="flex flex-col md:flex-row justify-between items-center mb-10 gap-6">
        <div>
            <h3 class="text-2xl font-black text-gray-900 dark:text-white uppercase tracking-tight">Struktur Organisasi</h3>
            <p class="text-gray-500 dark:text-gray-400 text-sm">Kelola hierarki dan struktur organisasi program studi secara visual.</p>
        </div>
        @can('organizational_structures_create')
            <a href="{{ route('organizational-structures.create') }}" class="bg-red-700 hover:bg-red-800 text-white font-black px-8 py-3 rounded-2xl shadow-lg shadow-red-200 dark:shadow-none transition-all uppercase tracking-widest text-xs flex items-center">
                <i class="fas fa-plus-circle mr-2"></i> Tambah Struktur
            </a>
        @endcan
    </div>

    <div class="overflow-hidden rounded-3xl border border-gray-100 dark:border-slate-800 shadow-sm bg-gray-50/50 dark:bg-slate-800/20 p-6">
        <table class="min-w-full">
            <thead class="sr-only">
                <tr>
                    <th>Struktur</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y-0">
                @php
                    $renderTree = function($nodes, $depth = 0) use (&$renderTree) {
                        foreach($nodes as $index => $node) {
                            $isLast = $index === count($nodes) - 1;
                            @endphp
                            <tr class="group">
                                <td class="py-2 pr-6">
                                    <div class="flex items-start" style="margin-left: {{ $depth * 3 }}rem">
                                        @if($depth > 0)
                                            <div class="flex items-start">
                                                {{-- Vertical line from parent --}}
                                                <div class="relative w-8 h-12">
                                                    <div class="absolute top-0 left-0 w-px h-full bg-gray-300 dark:bg-slate-700 {{ $isLast ? 'h-6' : '' }}"></div>
                                                    <div class="absolute top-6 left-0 w-full h-px bg-gray-300 dark:bg-slate-700"></div>
                                                </div>
                                            </div>
                                        @endif
                                        
                                        <div class="flex items-center gap-4 bg-white dark:bg-slate-900 p-4 rounded-2xl border border-gray-100 dark:border-slate-800 shadow-sm group-hover:shadow-md group-hover:border-red-200 dark:group-hover:border-red-900 transition-all flex-1 max-w-2xl">
                                            @if($node->image)
                                                <img src="{{ asset('storage/' . $node->image) }}" class="w-12 h-12 rounded-xl object-cover border-2 border-gray-50 dark:border-slate-800 shadow-sm">
                                            @else
                                                <div class="w-12 h-12 rounded-xl bg-red-50 dark:bg-red-900/20 flex items-center justify-center text-red-600 dark:text-red-400">
                                                    <i class="fas fa-user text-xl"></i>
                                                </div>
                                            @endif
                                            
                                            <div class="flex-1">
                                                <div class="text-sm font-black text-gray-900 dark:text-white uppercase tracking-tight">{{ $node->name }}</div>
                                                <div class="text-[10px] font-bold text-red-600 dark:text-red-500 uppercase tracking-[0.15em] mt-0.5">{{ $node->position }}</div>
                                            </div>

                                            <div class="flex gap-2 opacity-0 group-hover:opacity-100 transition-opacity">
                                                @can('organizational_structures_edit')
                                                    <a href="{{ route('organizational-structures.edit', $node->id) }}" class="p-2 text-gray-400 hover:text-blue-600 dark:hover:text-blue-400 transition-colors">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                @endcan
                                                @can('organizational_structures_delete')
                                                    <form action="{{ route('organizational-structures.destroy', $node->id) }}" method="POST" class="inline" onsubmit="return confirm('Hapus elemen struktur ini?')">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="p-2 text-gray-400 hover:text-red-600 transition-colors">
                                                            <i class="fas fa-trash-alt"></i>
                                                        </button>
                                                    </form>
                                                @endcan
                                            </div>
                                            
                                            <div class="text-[10px] font-black text-gray-300 dark:text-slate-700 bg-gray-50 dark:bg-slate-800/50 px-2 py-1 rounded-lg">
                                                #{{ $node->order }}
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            @php
                            if($node->children->count() > 0) {
                                $renderTree($node->children, $depth + 1);
                            }
                        }
                    };
                    $renderTree($structures);
                @endphp
                @if($structures->isEmpty())
                    <tr>
                        <td class="py-20 text-center">
                            <div class="flex flex-col items-center justify-center opacity-20">
                                <i class="fas fa-sitemap text-6xl mb-4"></i>
                                <p class="text-xl font-black uppercase tracking-widest">Belum Ada Data</p>
                            </div>
                        </td>
                    </tr>
                @endif
            </tbody>
        </table>
    </div>
</div>
@endsection
