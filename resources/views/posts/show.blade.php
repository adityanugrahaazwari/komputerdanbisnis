@extends('layouts.app')

@section('header', 'Post Detail: ' . $post->title)

@section('content')
<div class="grid grid-cols-1 md:grid-cols-3 gap-6">
    <!-- Left Column: Post Content -->
    <div class="md:col-span-2 space-y-6">
        <div class="bg-white rounded shadow p-6">
            <h1 class="text-2xl font-bold mb-4">{{ $post->title }}</h1>
            
            <div class="flex items-center text-sm text-gray-500 mb-6">
                <span class="mr-4"><i class="fas fa-user mr-1"></i> {{ $post->user->name }}</span>
                <span class="mr-4"><i class="fas fa-calendar mr-1"></i> {{ $post->created_at->format('d M Y H:i') }}</span>
                
                @php
                    $statusClasses = [
                        'draft' => 'bg-gray-200 text-gray-800',
                        'pending' => 'bg-yellow-200 text-yellow-800',
                        'published' => 'bg-green-200 text-green-800',
                        'rejected' => 'bg-red-200 text-red-800',
                    ];
                @endphp
                <span class="{{ $statusClasses[$post->status] ?? 'bg-gray-200' }} rounded px-2 py-1 text-xs">
                    {{ ucfirst($post->status) }}
                </span>
            </div>

            @if($post->image)
                <div class="mb-6">
                    <img src="{{ asset('storage/' . $post->image) }}" alt="{{ $post->title }}" class="w-full h-auto rounded shadow">
                </div>
            @endif

            <div class="prose max-w-none">
                {!! nl2br(e($post->content)) !!}
            </div>

            <div class="mt-8 flex space-x-2">
                @can('posts_edit')
                    @if(auth()->user()->can('posts_publish') || $post->user_id === auth()->id())
                        <a href="{{ route('posts.edit', $post->id) }}" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded">Edit Berita</a>
                    @endif
                @endcan
                <a href="{{ route('posts.index') }}" class="bg-gray-200 hover:bg-gray-300 text-gray-800 px-4 py-2 rounded">Kembali</a>
            </div>
        </div>
    </div>

    <!-- Right Column: Submission Logs -->
    <div class="md:col-span-1">
        <div class="bg-white rounded shadow p-6">
            <h3 class="text-lg font-bold mb-4 border-b pb-2">Riwayat Pengajuan</h3>
            <div class="relative">
                <div class="absolute left-3 top-0 bottom-0 w-0.5 bg-gray-200"></div>
                <div class="space-y-6 relative">
                    @foreach($post->submissions as $submission)
                        <div class="ml-8 relative">
                            <div class="absolute -left-[26px] top-1 w-4 h-4 rounded-full border-2 border-white {{ $statusClasses[$submission->status] ?? 'bg-gray-200' }}"></div>
                            <div class="text-sm font-semibold">{{ $submission->user->name }}</div>
                            <div class="text-xs text-gray-500 mb-1">
                                {{ $submission->created_at->format('d M Y, H:i') }} 
                                <span class="ml-1 px-1 rounded {{ $statusClasses[$submission->status] ?? 'bg-gray-200' }}">{{ ucfirst($submission->status) }}</span>
                            </div>
                            <div class="text-sm text-gray-700 bg-gray-50 p-2 rounded border">
                                {{ $submission->notes ?: '(Tidak ada catatan)' }}
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
