@extends('layouts.app')

@section('header', 'Edit Profil')

@section('content')
<div class="max-w-2xl">
    <div class="bg-white dark:bg-slate-900 rounded-[2.5rem] p-8 shadow-sm border border-gray-100 dark:border-slate-800">
        <div class="flex items-center gap-4 mb-8">
            <div class="w-12 h-12 bg-blue-100 dark:bg-blue-900/30 rounded-2xl flex items-center justify-center text-blue-600">
                <i class="fas fa-user-edit text-xl"></i>
            </div>
            <div>
                <h3 class="text-xl font-black text-gray-900 dark:text-white uppercase tracking-tight">Informasi Profil</h3>
                <p class="text-gray-500 dark:text-gray-400 text-sm font-medium">Perbarui informasi nama dan alamat email Anda.</p>
            </div>
        </div>

        <form action="{{ route('account.profile.update') }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')

            <div>
                <label for="name" class="block text-[10px] font-black text-gray-400 uppercase tracking-[0.2em] mb-2 ml-1">Nama Lengkap</label>
                <div class="relative">
                    <span class="absolute inset-y-0 left-0 pl-4 flex items-center text-gray-400">
                        <i class="fas fa-user text-sm"></i>
                    </span>
                    <input type="text" name="name" id="name" value="{{ old('name', $user->name) }}"
                           class="w-full pl-11 pr-4 py-3 bg-gray-50 dark:bg-slate-800 border border-gray-100 dark:border-slate-700 rounded-2xl focus:ring-2 focus:ring-blue-600 focus:bg-white dark:focus:bg-slate-700 transition-all outline-none text-gray-700 dark:text-gray-200 font-bold @error('name') border-red-500 @enderror" 
                           placeholder="Nama Anda" required>
                </div>
                @error('name')
                    <p class="mt-1 text-xs text-red-500 font-bold ml-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="email" class="block text-[10px] font-black text-gray-400 uppercase tracking-[0.2em] mb-2 ml-1">Alamat Email</label>
                <div class="relative">
                    <span class="absolute inset-y-0 left-0 pl-4 flex items-center text-gray-400">
                        <i class="fas fa-envelope text-sm"></i>
                    </span>
                    <input type="email" name="email" id="email" value="{{ old('email', $user->email) }}"
                           class="w-full pl-11 pr-4 py-3 bg-gray-50 dark:bg-slate-800 border border-gray-100 dark:border-slate-700 rounded-2xl focus:ring-2 focus:ring-blue-600 focus:bg-white dark:focus:bg-slate-700 transition-all outline-none text-gray-700 dark:text-gray-200 font-bold @error('email') border-red-500 @enderror" 
                           placeholder="email@contoh.com" required>
                </div>
                @error('email')
                    <p class="mt-1 text-xs text-red-500 font-bold ml-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="pt-4">
                <button type="submit" class="w-full bg-gray-900 dark:bg-blue-700 text-white px-8 py-4 rounded-2xl font-black text-xs uppercase tracking-[0.2em] hover:scale-[1.02] transition-all shadow-lg shadow-gray-200 dark:shadow-none flex items-center justify-center group">
                    <i class="fas fa-check-circle mr-3 group-hover:rotate-12 transition-transform"></i>
                    Perbarui Profil
                </button>
            </div>
        </form>
    </div>

    <div class="mt-8 bg-amber-50 dark:bg-amber-900/20 border border-amber-100 dark:border-amber-800 rounded-2xl p-6">
        <div class="flex gap-4">
            <i class="fas fa-exclamation-triangle text-amber-600 mt-1"></i>
            <div>
                <h4 class="text-sm font-black text-amber-900 dark:text-amber-300 uppercase tracking-tight mb-1">Perhatian</h4>
                <p class="text-xs text-amber-700 dark:text-amber-400 leading-relaxed font-medium">
                    Mengubah alamat email akan mempengaruhi kredensial login Anda. Pastikan Anda memiliki akses ke email baru tersebut.
                </p>
            </div>
        </div>
    </div>
</div>
@endsection
