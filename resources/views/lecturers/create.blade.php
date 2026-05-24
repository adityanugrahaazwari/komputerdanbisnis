@extends('layouts.app')

@section('header', 'Tambah Dosen/Staf')

@section('content')
<div class="bg-white rounded-[2rem] shadow-sm border border-gray-100 p-8">
    <div class="mb-8">
        <h3 class="text-xl font-black text-gray-900 uppercase tracking-tight">Tambah Dosen/Staf</h3>
        <p class="text-gray-500 text-sm">Input data dosen atau staf baru ke dalam direktori.</p>
    </div>

    <form action="{{ route('lecturers.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="mb-4">
                <label class="block text-gray-700 font-bold mb-2 text-sm uppercase tracking-wide">Nama Lengkap</label>
                <input type="text" name="name" class="w-full border-gray-200 rounded-2xl px-4 py-3 focus:ring-red-500 focus:border-red-500 @error('name') border-red-500 @enderror" value="{{ old('name') }}" required placeholder="Contoh: Dr. John Doe, M.Kom">
                @error('name') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 font-bold mb-2 text-sm uppercase tracking-wide">Email</label>
                <input type="email" name="email" class="w-full border-gray-200 rounded-2xl px-4 py-3 focus:ring-red-500 focus:border-red-500 @error('email') border-red-500 @enderror" value="{{ old('email') }}" placeholder="johndoe@politala.ac.id">
                @error('email') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 font-bold mb-2 text-sm uppercase tracking-wide">NIP</label>
                <input type="text" name="nip" class="w-full border-gray-200 rounded-2xl px-4 py-3 focus:ring-red-500 focus:border-red-500 @error('nip') border-red-500 @enderror" value="{{ old('nip') }}" placeholder="19XXXXXXXXXXXXXX">
                @error('nip') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 font-bold mb-2 text-sm uppercase tracking-wide">NIDN</label>
                <input type="text" name="nidn" class="w-full border-gray-200 rounded-2xl px-4 py-3 focus:ring-red-500 focus:border-red-500 @error('nidn') border-red-500 @enderror" value="{{ old('nidn') }}" placeholder="11XXXXXXXX">
                @error('nidn') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 font-bold mb-2 text-sm uppercase tracking-wide">Jabatan Fungsional</label>
                <input type="text" name="position" class="w-full border-gray-200 rounded-2xl px-4 py-3 focus:ring-red-500 focus:border-red-500 @error('position') border-red-500 @enderror" value="{{ old('position') }}" placeholder="Contoh: Lektor / Asisten Ahli">
                @error('position') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 font-bold mb-2 text-sm uppercase tracking-wide">Bidang Keahlian</label>
                <input type="text" name="expertise" class="w-full border-gray-200 rounded-2xl px-4 py-3 focus:ring-red-500 focus:border-red-500 @error('expertise') border-red-500 @enderror" value="{{ old('expertise') }}" placeholder="Contoh: Software Engineering">
                @error('expertise') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 font-bold mb-2 text-sm uppercase tracking-wide">Program Studi</label>
                <select name="study_program_id" class="w-full border-gray-200 rounded-2xl px-4 py-3 focus:ring-red-500 focus:border-red-500 @error('study_program_id') border-red-500 @enderror">
                    <option value="">Semua Prodi / Staf Jurusan</option>
                    @foreach($studyPrograms as $prodi)
                        <option value="{{ $prodi->id }}" {{ old('study_program_id') == $prodi->id ? 'selected' : '' }}>{{ $prodi->name }}</option>
                    @endforeach
                </select>
                @error('study_program_id') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 font-bold mb-2 text-sm uppercase tracking-wide">Foto</label>
                <input type="file" name="photo" class="w-full border-gray-200 rounded-2xl px-4 py-3 @error('photo') border-red-500 @enderror">
                <p class="text-[10px] text-gray-400 mt-1 italic">Format: JPG, PNG, JPEG. Max: 2MB.</p>
                @error('photo') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 font-bold mb-2 text-sm uppercase tracking-wide">Google Scholar URL</label>
                <input type="url" name="google_scholar_url" class="w-full border-gray-200 rounded-2xl px-4 py-3 focus:ring-red-500 focus:border-red-500 @error('google_scholar_url') border-red-500 @enderror" value="{{ old('google_scholar_url') }}" placeholder="https://scholar.google.com/citations?user=...">
                @error('google_scholar_url') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 font-bold mb-2 text-sm uppercase tracking-wide">Sinta URL</label>
                <input type="url" name="sinta_url" class="w-full border-gray-200 rounded-2xl px-4 py-3 focus:ring-red-500 focus:border-red-500 @error('sinta_url') border-red-500 @enderror" value="{{ old('sinta_url') }}" placeholder="https://sinta.kemdikbud.go.id/authors/profile/...">
                @error('sinta_url') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 font-bold mb-2 text-sm uppercase tracking-wide">Urutan Tampil</label>
                <input type="number" name="order" class="w-full border-gray-200 rounded-2xl px-4 py-3 focus:ring-red-500 focus:border-red-500 @error('order') border-red-500 @enderror" value="{{ old('order', 0) }}">
                @error('order') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
            </div>

            <div class="mb-4 flex items-center h-full">
                <label class="flex items-center cursor-pointer">
                    <input type="checkbox" name="is_active" value="1" class="hidden peer" {{ old('is_active', true) ? 'checked' : '' }}>
                    <div class="w-12 h-6 bg-gray-200 peer-checked:bg-green-500 rounded-full transition-all relative after:content-[''] after:absolute after:top-1 after:left-1 after:bg-white after:w-4 after:h-4 after:rounded-full after:transition-all peer-checked:after:translate-x-6"></div>
                    <span class="ml-3 text-gray-700 font-bold text-sm uppercase tracking-wide">Aktif</span>
                </label>
            </div>
        </div>

        <div class="mt-12 flex justify-end gap-4">
            <a href="{{ route('lecturers.index') }}" class="bg-gray-100 text-gray-600 px-8 py-4 rounded-[2rem] font-black text-xs uppercase tracking-[0.2em] hover:bg-gray-200 transition-all">
                Batal
            </a>
            <button type="submit" class="bg-red-700 text-white px-8 py-4 rounded-[2rem] font-black text-xs uppercase tracking-[0.2em] hover:scale-[1.02] transition-all shadow-xl shadow-red-200 flex items-center">
                <i class="fas fa-save mr-3"></i>
                Simpan Data
            </button>
        </div>
    </form>
</div>
@endsection
