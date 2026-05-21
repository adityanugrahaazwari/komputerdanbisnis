@extends('layouts.app')

@section('header', 'Dashboard')

@section('content')
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
    <!-- Stat Card: Users -->
    <div class="bg-white p-8 rounded-[2rem] shadow-sm border border-gray-100 relative overflow-hidden group hover:shadow-xl transition-all duration-300">
        <div class="absolute top-0 right-0 w-32 h-32 bg-red-50 rounded-full -mr-16 -mt-16 transition-transform group-hover:scale-110"></div>
        <div class="relative z-10">
            <div class="w-14 h-14 bg-red-100 rounded-2xl flex items-center justify-center text-red-600 mb-6 shadow-sm">
                <i class="fas fa-users text-2xl"></i>
            </div>
            <p class="text-gray-500 text-xs font-black uppercase tracking-[0.2em] mb-1">Total Pengguna</p>
            <h3 class="text-4xl font-black text-gray-900 tracking-tighter">{{ \App\Models\User::count() }}</h3>
        </div>
    </div>

    <!-- Stat Card: Posts -->
    <div class="bg-white p-8 rounded-[2rem] shadow-sm border border-gray-100 relative overflow-hidden group hover:shadow-xl transition-all duration-300">
        <div class="absolute top-0 right-0 w-32 h-32 bg-orange-50 rounded-full -mr-16 -mt-16 transition-transform group-hover:scale-110"></div>
        <div class="relative z-10">
            <div class="w-14 h-14 bg-orange-100 rounded-2xl flex items-center justify-center text-orange-600 mb-6 shadow-sm">
                <i class="fas fa-newspaper text-2xl"></i>
            </div>
            <p class="text-gray-500 text-xs font-black uppercase tracking-[0.2em] mb-1">Berita Terbit</p>
            <h3 class="text-4xl font-black text-gray-900 tracking-tighter">{{ \App\Models\Post::where('status', 'published')->count() }}</h3>
        </div>
    </div>

    <!-- Stat Card: Study Programs -->
    <div class="bg-white p-8 rounded-[2rem] shadow-sm border border-gray-100 relative overflow-hidden group hover:shadow-xl transition-all duration-300">
        <div class="absolute top-0 right-0 w-32 h-32 bg-blue-50 rounded-full -mr-16 -mt-16 transition-transform group-hover:scale-110"></div>
        <div class="relative z-10">
            <div class="w-14 h-14 bg-blue-100 rounded-2xl flex items-center justify-center text-blue-600 mb-6 shadow-sm">
                <i class="fas fa-graduation-cap text-2xl"></i>
            </div>
            <p class="text-gray-500 text-xs font-black uppercase tracking-[0.2em] mb-1">Program Studi</p>
            <h3 class="text-4xl font-black text-gray-900 tracking-tighter">{{ \App\Models\StudyProgram::count() }}</h3>
        </div>
    </div>

    <!-- Stat Card: Pending Review -->
    <div class="bg-white p-8 rounded-[2rem] shadow-sm border border-gray-100 relative overflow-hidden group hover:shadow-xl transition-all duration-300">
        <div class="absolute top-0 right-0 w-32 h-32 bg-yellow-50 rounded-full -mr-16 -mt-16 transition-transform group-hover:scale-110"></div>
        <div class="relative z-10">
            <div class="w-14 h-14 bg-yellow-100 rounded-2xl flex items-center justify-center text-yellow-600 mb-6 shadow-sm">
                <i class="fas fa-clock text-2xl"></i>
            </div>
            <p class="text-gray-500 text-xs font-black uppercase tracking-[0.2em] mb-1">Butuh Review</p>
            <h3 class="text-4xl font-black text-gray-900 tracking-tighter">{{ \App\Models\Post::where('status', 'pending')->count() }}</h3>
        </div>
    </div>
</div>

<div class="mt-12 bg-white rounded-[2.5rem] p-10 shadow-sm border border-gray-100">
    <div class="flex items-center justify-between mb-10">
        <h4 class="text-xl font-black text-gray-900 uppercase tracking-tight">Selamat Datang, {{ auth()->user()->name }}!</h4>
        <span class="bg-red-700 text-white text-[10px] font-black px-4 py-1.5 rounded-full uppercase tracking-widest shadow-lg shadow-red-200 italic">POLITALA Management System</span>
    </div>
    
    <div class="grid md:grid-cols-2 gap-10">
        <div class="space-y-6">
            <p class="text-gray-600 leading-relaxed">
                Anda login sebagai <strong class="text-red-700 uppercase">{{ auth()->user()->roles->first()->name }}</strong>. Gunakan sidebar di sebelah kiri untuk mengelola konten website, profil jurusan, program studi, dan akun pengguna.
            </p>
            <div class="flex gap-4">
                <a href="{{ route('posts.create') }}" class="bg-gray-900 text-white px-6 py-3 rounded-2xl font-bold text-sm hover:bg-black transition flex items-center shadow-lg">
                    <i class="fas fa-plus mr-2 text-red-500"></i> Buat Berita Baru
                </a>
                <a href="{{ url('/') }}" target="_blank" class="bg-white text-gray-700 border border-gray-200 px-6 py-3 rounded-2xl font-bold text-sm hover:bg-gray-50 transition flex items-center shadow-sm">
                    <i class="fas fa-external-link-alt mr-2 text-red-600"></i> Lihat Website
                </a>
            </div>
        </div>
        <div class="bg-red-50 rounded-3xl p-8 border border-red-100 flex items-center gap-6">
            <div class="w-20 h-20 bg-white rounded-2xl shadow-sm flex items-center justify-center text-red-600">
                <i class="fas fa-info-circle text-4xl"></i>
            </div>
            <div>
                <h5 class="text-red-900 font-black uppercase text-sm mb-2">Pemberitahuan Sistem</h5>
                <p class="text-red-700 text-sm opacity-80 leading-relaxed">
                    Pastikan untuk selalu mengecek tab "Berita" jika ada pengajuan baru dari operator yang membutuhkan persetujuan.
                </p>
            </div>
        </div>
    </div>
</div>
@endsection
