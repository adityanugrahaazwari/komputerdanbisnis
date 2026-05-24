@extends('layouts.app')

@section('header', 'Edit Testimoni')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="bg-white rounded-[2rem] shadow-sm border border-gray-100 p-8">
        <div class="mb-8">
            <h3 class="text-xl font-black text-gray-900 uppercase tracking-tight">Edit Testimoni</h3>
            <p class="text-gray-500 text-sm">Perbarui informasi testimoni.</p>
        </div>

        <form action="{{ route('testimonials.update', $testimonial->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <div class="md:col-span-2">
                    <label class="block text-gray-700 text-xs font-black uppercase tracking-widest mb-2">Nama Lengkap</label>
                    <input type="text" name="name" class="w-full bg-gray-50 border border-gray-100 rounded-2xl px-4 py-3 text-sm focus:ring-2 focus:ring-red-500 transition outline-none @error('name') border-red-500 @enderror" value="{{ old('name', $testimonial->name) }}" placeholder="Contoh: John Doe, S.Kom">
                    @error('name') <span class="text-red-500 text-xs font-bold mt-1">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="block text-gray-700 text-xs font-black uppercase tracking-widest mb-2">Jabatan / Status</label>
                    <input type="text" name="role" class="w-full bg-gray-50 border border-gray-100 rounded-2xl px-4 py-3 text-sm focus:ring-2 focus:ring-red-500 transition outline-none" value="{{ old('role', $testimonial->role) }}" placeholder="Contoh: Alumni 2020 / Software Engineer">
                </div>

                <div>
                    <label class="block text-gray-700 text-xs font-black uppercase tracking-widest mb-2">Instansi / Perusahaan</label>
                    <input type="text" name="company" class="w-full bg-gray-50 border border-gray-100 rounded-2xl px-4 py-3 text-sm focus:ring-2 focus:ring-red-500 transition outline-none" value="{{ old('company', $testimonial->company) }}" placeholder="Contoh: PT. Teknologi Maju">
                </div>

                <div class="md:col-span-2">
                    <label class="block text-gray-700 text-xs font-black uppercase tracking-widest mb-2">Isi Testimoni</label>
                    <textarea name="quote" rows="5" class="w-full bg-gray-50 border border-gray-100 rounded-2xl px-4 py-3 text-sm focus:ring-2 focus:ring-red-500 transition outline-none @error('quote') border-red-500 @enderror" placeholder="Berikan kutipan testimoni...">{{ old('quote', $testimonial->quote) }}</textarea>
                    @error('quote') <span class="text-red-500 text-xs font-bold mt-1">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="block text-gray-700 text-xs font-black uppercase tracking-widest mb-2">Foto</label>
                    @if($testimonial->image)
                        <div class="mb-2">
                            <img src="{{ asset('storage/' . $testimonial->image) }}" alt="{{ $testimonial->name }}" class="w-20 h-20 rounded-full object-cover border border-gray-100">
                        </div>
                    @endif
                    <input type="file" name="image" class="w-full bg-gray-50 border border-gray-100 rounded-2xl px-4 py-3 text-sm focus:ring-2 focus:ring-red-500 transition outline-none @error('image') border-red-500 @enderror">
                    <p class="text-[10px] text-gray-400 mt-1 italic">Format: JPG, PNG, GIF (Maks. 2MB). Biarkan kosong jika tidak ingin mengubah.</p>
                    @error('image') <span class="text-red-500 text-xs font-bold mt-1">{{ $message }}</span> @enderror
                </div>

                <div class="flex items-center gap-2">
                    <input type="checkbox" name="is_active" id="is_active" value="1" {{ $testimonial->is_active ? 'checked' : '' }} class="rounded text-red-600 focus:ring-red-500">
                    <label for="is_active" class="text-gray-700 text-xs font-black uppercase tracking-widest">Aktifkan Testimoni</label>
                </div>
            </div>

            <div class="mt-12 flex justify-end gap-4">
                <a href="{{ route('testimonials.index') }}" 
                   class="bg-gray-100 dark:bg-slate-800 text-gray-600 dark:text-gray-400 px-8 py-4 rounded-[2rem] font-black text-xs uppercase tracking-[0.2em] hover:bg-gray-200 dark:hover:bg-slate-700 transition-all flex items-center justify-center">
                    Batal
                </a>
                <button type="submit" 
                        class="bg-gray-900 dark:bg-red-700 text-white px-8 py-4 rounded-[2rem] font-black text-xs uppercase tracking-[0.2em] hover:scale-[1.02] transition-all shadow-xl flex items-center justify-center group">
                    <span>Simpan Perubahan</span>
                    <i class="fas fa-save ml-3 group-hover:translate-x-1 transition-transform"></i>
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
