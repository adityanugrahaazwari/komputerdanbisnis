@extends('layouts.app')

@section('header', 'Edit Kegiatan')

@section('content')
<div class="bg-white rounded-[2rem] shadow-sm border border-gray-100 p-8">
    <div class="mb-8">
        <h3 class="text-xl font-black text-gray-900 uppercase tracking-tight">Edit Kegiatan</h3>
        <p class="text-gray-500 text-sm">Perbarui data {{ $event->title }}.</p>
    </div>

    <form action="{{ route('events.update', $event->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="md:col-span-2">
                <label class="block text-gray-700 font-bold mb-2 text-sm uppercase tracking-wide">Judul Kegiatan</label>
                <input type="text" name="title" class="w-full border-gray-200 rounded-2xl px-4 py-3 focus:ring-red-500 focus:border-red-500 @error('title') border-red-500 @enderror" value="{{ old('title', $event->title) }}">
                @error('title') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 font-bold mb-2 text-sm uppercase tracking-wide">Tanggal Mulai</label>
                <input type="datetime-local" name="start_date" class="w-full border-gray-200 rounded-2xl px-4 py-3 focus:ring-red-500 focus:border-red-500 @error('start_date') border-red-500 @enderror" value="{{ old('start_date', $event->start_date->format('Y-m-d\TH:i')) }}">
                @error('start_date') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 font-bold mb-2 text-sm uppercase tracking-wide">Tanggal Selesai (Opsional)</label>
                <input type="datetime-local" name="end_date" class="w-full border-gray-200 rounded-2xl px-4 py-3 focus:ring-red-500 focus:border-red-500 @error('end_date') border-red-500 @enderror" value="{{ old('end_date', $event->end_date ? $event->end_date->format('Y-m-d\TH:i') : '') }}">
                @error('end_date') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 font-bold mb-2 text-sm uppercase tracking-wide">Tipe Kegiatan</label>
                <select name="type" class="w-full border-gray-200 rounded-2xl px-4 py-3 focus:ring-red-500 focus:border-red-500 @error('type') border-red-500 @enderror">
                    <option value="academic" {{ old('type', $event->type) == 'academic' ? 'selected' : '' }}>Kalender Akademik</option>
                    <option value="webinar" {{ old('type', $event->type) == 'webinar' ? 'selected' : '' }}>Webinar / Workshop</option>
                    <option value="competition" {{ old('type', $event->type) == 'competition' ? 'selected' : '' }}>Lomba / Kompetisi</option>
                    <option value="holiday" {{ old('type', $event->type) == 'holiday' ? 'selected' : '' }}>Hari Libur</option>
                    <option value="other" {{ old('type', $event->type) == 'other' ? 'selected' : '' }}>Lainnya</option>
                </select>
                @error('type') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 font-bold mb-2 text-sm uppercase tracking-wide">Warna Label</label>
                <input type="color" name="color" class="w-full h-14 border-gray-200 rounded-2xl px-2 py-2 focus:ring-red-500 focus:border-red-500 @error('color') border-red-500 @enderror" value="{{ old('color', $event->color) }}">
                @error('color') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
            </div>

            <div class="md:col-span-2">
                <label class="block text-gray-700 font-bold mb-2 text-sm uppercase tracking-wide">Lokasi / Link</label>
                <input type="text" name="location" class="w-full border-gray-200 rounded-2xl px-4 py-3 focus:ring-red-500 focus:border-red-500 @error('location') border-red-500 @enderror" value="{{ old('location', $event->location) }}">
                @error('location') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
            </div>

            <div class="md:col-span-2">
                <label class="block text-gray-700 font-bold mb-2 text-sm uppercase tracking-wide">Deskripsi</label>
                <textarea name="description" rows="4" class="w-full border-gray-200 rounded-2xl px-4 py-3 focus:ring-red-500 focus:border-red-500 @error('description') border-red-500 @enderror">{{ old('description', $event->description) }}</textarea>
                @error('description') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 font-bold mb-2 text-sm uppercase tracking-wide">Ganti Poster (Opsional)</label>
                @if($event->image)
                    <div class="mb-2">
                        <img src="{{ asset('storage/' . $event->image) }}" class="w-32 rounded-xl object-cover border">
                    </div>
                @endif
                <input type="file" name="image" class="w-full border-gray-200 rounded-2xl px-4 py-3 @error('image') border-red-500 @enderror">
                <p class="text-[10px] text-gray-400 mt-1 italic">Rekomendasi ukuran: 16:9 (Contoh: 1200x675px). @if($event->image) Kosongkan jika tidak ingin mengubah. @endif</p>
                @error('image') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
            </div>

            <div class="mb-4 flex items-center h-full">
                <label class="flex items-center cursor-pointer">
                    <input type="checkbox" name="is_active" value="1" class="hidden peer" {{ old('is_active', $event->is_active) ? 'checked' : '' }}>
                    <div class="w-12 h-6 bg-gray-200 peer-checked:bg-green-500 rounded-full transition-all relative after:content-[''] after:absolute after:top-1 after:left-1 after:bg-white after:w-4 after:h-4 after:rounded-full after:transition-all peer-checked:after:translate-x-6"></div>
                    <span class="ml-3 text-gray-700 font-bold text-sm uppercase tracking-wide">Tampilkan di Web</span>
                </label>
            </div>
        </div>

        <div class="mt-12 flex justify-end gap-4">
            <a href="{{ route('events.index') }}" class="bg-gray-100 text-gray-600 px-8 py-4 rounded-[2rem] font-black text-xs uppercase tracking-[0.2em] hover:bg-gray-200 transition-all">
                Batal
            </a>
            <button type="submit" class="bg-red-700 text-white px-8 py-4 rounded-[2rem] font-black text-xs uppercase tracking-[0.2em] hover:scale-[1.02] transition-all shadow-xl shadow-red-200 flex items-center">
                <i class="fas fa-save mr-3"></i>
                Simpan Perubahan
            </button>
        </div>
    </form>
</div>
@endsection
