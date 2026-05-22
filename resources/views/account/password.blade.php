@extends('layouts.app')

@section('header', 'Ubah Password')

@section('content')
<div class="max-w-2xl">
    <div class="bg-white dark:bg-slate-900 rounded-[2.5rem] p-8 shadow-sm border border-gray-100 dark:border-slate-800">
        <div class="flex items-center gap-4 mb-8">
            <div class="w-12 h-12 bg-red-100 dark:bg-red-900/30 rounded-2xl flex items-center justify-center text-red-600">
                <i class="fas fa-key text-xl"></i>
            </div>
            <div>
                <h3 class="text-xl font-black text-gray-900 dark:text-white uppercase tracking-tight">Ganti Kata Sandi</h3>
                <p class="text-gray-500 dark:text-gray-400 text-sm font-medium">Pastikan kata sandi Anda kuat dan aman.</p>
            </div>
        </div>

        <form action="{{ route('account.password.update') }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')

            <div>
                <label for="current_password" class="block text-[10px] font-black text-gray-400 uppercase tracking-[0.2em] mb-2 ml-1">Kata Sandi Saat Ini</label>
                <div class="relative">
                    <span class="absolute inset-y-0 left-0 pl-4 flex items-center text-gray-400">
                        <i class="fas fa-lock text-sm"></i>
                    </span>
                    <input type="password" name="current_password" id="current_password" 
                           class="w-full pl-11 pr-4 py-3 bg-gray-50 dark:bg-slate-800 border border-gray-100 dark:border-slate-700 rounded-2xl focus:ring-2 focus:ring-red-600 focus:bg-white dark:focus:bg-slate-700 transition-all outline-none text-gray-700 dark:text-gray-200 font-bold @error('current_password') border-red-500 @enderror" 
                           placeholder="••••••••" required>
                </div>
                @error('current_password')
                    <p class="mt-1 text-xs text-red-500 font-bold ml-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="password" class="block text-[10px] font-black text-gray-400 uppercase tracking-[0.2em] mb-2 ml-1">Kata Sandi Baru</label>
                <div class="relative">
                    <span class="absolute inset-y-0 left-0 pl-4 flex items-center text-gray-400">
                        <i class="fas fa-shield-alt text-sm"></i>
                    </span>
                    <input type="password" name="password" id="password" 
                           class="w-full pl-11 pr-4 py-3 bg-gray-50 dark:bg-slate-800 border border-gray-100 dark:border-slate-700 rounded-2xl focus:ring-2 focus:ring-red-600 focus:bg-white dark:focus:bg-slate-700 transition-all outline-none text-gray-700 dark:text-gray-200 font-bold @error('password') border-red-500 @enderror" 
                           placeholder="••••••••" required>
                </div>
                @error('password')
                    <p class="mt-1 text-xs text-red-500 font-bold ml-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="password_confirmation" class="block text-[10px] font-black text-gray-400 uppercase tracking-[0.2em] mb-2 ml-1">Konfirmasi Kata Sandi Baru</label>
                <div class="relative">
                    <span class="absolute inset-y-0 left-0 pl-4 flex items-center text-gray-400">
                        <i class="fas fa-check-circle text-sm"></i>
                    </span>
                    <input type="password" name="password_confirmation" id="password_confirmation" 
                           class="w-full pl-11 pr-4 py-3 bg-gray-50 dark:bg-slate-800 border border-gray-100 dark:border-slate-700 rounded-2xl focus:ring-2 focus:ring-red-600 focus:bg-white dark:focus:bg-slate-700 transition-all outline-none text-gray-700 dark:text-gray-200 font-bold" 
                           placeholder="••••••••" required>
                </div>
            </div>

            <div class="pt-4">
                <button type="submit" class="w-full bg-gray-900 dark:bg-red-700 text-white px-8 py-4 rounded-2xl font-black text-xs uppercase tracking-[0.2em] hover:scale-[1.02] transition-all shadow-lg shadow-gray-200 dark:shadow-none flex items-center justify-center group">
                    <i class="fas fa-save mr-3 group-hover:rotate-12 transition-transform"></i>
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>

    <div class="mt-8 bg-blue-50 dark:bg-blue-900/20 border border-blue-100 dark:border-blue-800 rounded-2xl p-6">
        <div class="flex gap-4">
            <i class="fas fa-info-circle text-blue-600 mt-1"></i>
            <div>
                <h4 class="text-sm font-black text-blue-900 dark:text-blue-300 uppercase tracking-tight mb-1">Tips Keamanan</h4>
                <p class="text-xs text-blue-700 dark:text-blue-400 leading-relaxed font-medium">
                    Gunakan minimal 8 karakter dengan kombinasi huruf besar, huruf kecil, angka, dan simbol untuk keamanan maksimal. Jangan gunakan kata sandi yang mudah ditebak seperti tanggal lahir atau nama.
                </p>
            </div>
        </div>
    </div>
</div>
@endsection
