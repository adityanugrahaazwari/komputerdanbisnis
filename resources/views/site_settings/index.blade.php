@extends('layouts.app')

@section('header', 'Pengaturan Identitas Situs')

@section('content')
<div class="bg-white dark:bg-slate-900 rounded-[2.5rem] p-8 shadow-sm border border-gray-100 dark:border-slate-800">
    <div class="mb-8">
        <h3 class="text-xl font-black text-gray-900 dark:text-white uppercase tracking-tight">Kustomisasi Situs</h3>
        <p class="text-gray-500 dark:text-gray-400 text-sm font-medium">Atur identitas dasar, konten landing page, hingga informasi kontak dan footer.</p>
    </div>

    <form action="{{ route('site-settings.update') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="space-y-12">
            <!-- GROUP 1: IDENTITAS DASAR -->
            <section class="space-y-6">
                <div class="border-l-4 border-red-600 pl-4">
                    <h4 class="text-sm font-black text-gray-900 dark:text-white uppercase tracking-widest">1. Identitas Dasar</h4>
                    <p class="text-[10px] text-gray-500 font-bold uppercase tracking-tight">Nama instansi dan branding utama situs.</p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <div class="space-y-2 md:col-span-2">
                        <label for="site_name" class="text-[10px] font-black text-gray-400 uppercase tracking-[0.2em] ml-4">Nama Situs / Instansi</label>
                        <input type="text" name="site_name" id="site_name" value="{{ $settings['site_name'] }}" class="w-full bg-gray-50 dark:bg-slate-800 border-none rounded-2xl px-6 py-4 focus:ring-2 focus:ring-red-600 transition-all font-bold text-gray-900 dark:text-white" placeholder="Masukkan nama situs...">
                    </div>

                    <div class="space-y-2">
                        <label class="text-[10px] font-black text-gray-400 uppercase tracking-[0.2em] ml-4">Logo Situs</label>
                        <div class="bg-gray-50 dark:bg-slate-800 rounded-3xl p-6 border-2 border-dashed border-gray-200 dark:border-slate-700">
                            <div class="flex flex-col items-center gap-4">
                                @if($settings['site_logo'])
                                    <img src="{{ asset('storage/' . $settings['site_logo']) }}" alt="Logo" class="h-16 object-contain">
                                @else
                                    <div class="h-16 w-16 bg-gray-200 dark:bg-slate-700 rounded-2xl flex items-center justify-center">
                                        <i class="fas fa-image text-gray-400 text-xl"></i>
                                    </div>
                                @endif
                                <input type="file" name="site_logo" class="text-[10px] text-gray-500 file:mr-4 file:py-1.5 file:px-3 file:rounded-full file:border-0 file:text-[10px] file:font-black file:bg-red-50 file:text-red-700 hover:file:bg-red-100">
                                <p class="text-[9px] text-gray-400 font-bold uppercase tracking-tight text-center">PNG transparan, maks 2MB</p>
                            </div>
                        </div>
                    </div>

                    <div class="space-y-2">
                        <label class="text-[10px] font-black text-gray-400 uppercase tracking-[0.2em] ml-4">Favicon</label>
                        <div class="bg-gray-50 dark:bg-slate-800 rounded-3xl p-6 border-2 border-dashed border-gray-200 dark:border-slate-700">
                            <div class="flex flex-col items-center gap-4">
                                @if($settings['site_favicon'])
                                    <img src="{{ asset('storage/' . $settings['site_favicon']) }}" alt="Favicon" class="h-10 w-10 object-contain">
                                @else
                                    <div class="h-10 w-10 bg-gray-200 dark:bg-slate-700 rounded-xl flex items-center justify-center">
                                        <i class="fas fa-star text-gray-400"></i>
                                    </div>
                                @endif
                                <input type="file" name="site_favicon" class="text-[10px] text-gray-500 file:mr-4 file:py-1.5 file:px-3 file:rounded-full file:border-0 file:text-[10px] file:font-black file:bg-red-50 file:text-red-700 hover:file:bg-red-100">
                                <p class="text-[9px] text-gray-400 font-bold uppercase tracking-tight text-center">ICO/PNG 32x32, maks 1MB</p>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <!-- GROUP 2: HERO SECTION -->
            <section class="space-y-6 pt-8 border-t border-gray-100 dark:border-slate-800">
                <div class="border-l-4 border-red-600 pl-4">
                    <h4 class="text-sm font-black text-gray-900 dark:text-white uppercase tracking-widest">2. Bagian Hero (Halaman Depan)</h4>
                    <p class="text-[10px] text-gray-500 font-bold uppercase tracking-tight">Atur teks utama yang muncul di bagian paling atas situs.</p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <div class="space-y-2">
                        <label for="hero_badge" class="text-[10px] font-black text-gray-400 uppercase tracking-[0.2em] ml-4">Teks Badge (Kecil)</label>
                        <input type="text" name="hero_badge" id="hero_badge" value="{{ $settings['hero_badge'] }}" class="w-full bg-gray-50 dark:bg-slate-800 border-none rounded-2xl px-6 py-4 focus:ring-2 focus:ring-red-600 transition-all font-bold text-gray-900 dark:text-white" placeholder="Contoh: POLITEKNIK NEGERI TANAH LAUT">
                    </div>

                    <div class="space-y-2">
                        <label for="hero_title" class="text-[10px] font-black text-gray-400 uppercase tracking-[0.2em] ml-4">Judul Utama (Besar)</label>
                        <input type="text" name="hero_title" id="hero_title" value="{{ $settings['hero_title'] }}" class="w-full bg-gray-50 dark:bg-slate-800 border-none rounded-2xl px-6 py-4 focus:ring-2 focus:ring-red-600 transition-all font-bold text-gray-900 dark:text-white" placeholder="Masukkan judul utama...">
                    </div>

                    <div class="space-y-2 md:col-span-2">
                        <label for="hero_subtitle" class="text-[10px] font-black text-gray-400 uppercase tracking-[0.2em] ml-4">Subtitle / Deskripsi Hero</label>
                        <textarea name="hero_subtitle" id="hero_subtitle" rows="3" class="w-full bg-gray-50 dark:bg-slate-800 border-none rounded-2xl px-6 py-4 focus:ring-2 focus:ring-red-600 transition-all font-bold text-gray-900 dark:text-white" placeholder="Masukkan deskripsi singkat...">{{ $settings['hero_subtitle'] }}</textarea>
                    </div>

                    <div class="space-y-2">
                        <label class="text-[10px] font-black text-gray-400 uppercase tracking-[0.2em] ml-4">Tombol Utama (Teks & Link)</label>
                        <div class="flex gap-2">
                            <input type="text" name="hero_btn1_text" value="{{ $settings['hero_btn1_text'] }}" class="w-1/3 bg-gray-50 dark:bg-slate-800 border-none rounded-2xl px-4 py-4 focus:ring-2 focus:ring-red-600 transition-all font-bold text-gray-900 dark:text-white text-xs" placeholder="Teks">
                            <input type="text" name="hero_btn1_url" value="{{ $settings['hero_btn1_url'] }}" class="w-2/3 bg-gray-50 dark:bg-slate-800 border-none rounded-2xl px-4 py-4 focus:ring-2 focus:ring-red-600 transition-all font-bold text-gray-900 dark:text-white text-xs" placeholder="URL">
                        </div>
                    </div>

                    <div class="space-y-2">
                        <label class="text-[10px] font-black text-gray-400 uppercase tracking-[0.2em] ml-4">Tombol Sekunder (Teks & Link)</label>
                        <div class="flex gap-2">
                            <input type="text" name="hero_btn2_text" value="{{ $settings['hero_btn2_text'] }}" class="w-1/3 bg-gray-50 dark:bg-slate-800 border-none rounded-2xl px-4 py-4 focus:ring-2 focus:ring-red-600 transition-all font-bold text-gray-900 dark:text-white text-xs" placeholder="Teks">
                            <input type="text" name="hero_btn2_url" value="{{ $settings['hero_btn2_url'] }}" class="w-2/3 bg-gray-50 dark:bg-slate-800 border-none rounded-2xl px-4 py-4 focus:ring-2 focus:ring-red-600 transition-all font-bold text-gray-900 dark:text-white text-xs" placeholder="URL">
                        </div>
                    </div>
                </div>
            </section>

            <!-- GROUP 3: CONTACT SECTION -->
            <section class="space-y-6 pt-8 border-t border-gray-100 dark:border-slate-800">
                <div class="border-l-4 border-red-600 pl-4">
                    <h4 class="text-sm font-black text-gray-900 dark:text-white uppercase tracking-widest">3. Bagian Kontak (Halaman Depan)</h4>
                    <p class="text-[10px] text-gray-500 font-bold uppercase tracking-tight">Atur teks pengantar untuk formulir kontak.</p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <div class="space-y-2">
                        <label for="contact_title" class="text-[10px] font-black text-gray-400 uppercase tracking-[0.2em] ml-4">Judul Bagian Kontak</label>
                        <input type="text" name="contact_title" id="contact_title" value="{{ $settings['contact_title'] }}" class="w-full bg-gray-50 dark:bg-slate-800 border-none rounded-2xl px-6 py-4 focus:ring-2 focus:ring-red-600 transition-all font-bold text-gray-900 dark:text-white" placeholder="Contoh: Kontak Kami">
                    </div>

                    <div class="space-y-2 md:col-span-2">
                        <label for="contact_description" class="text-[10px] font-black text-gray-400 uppercase tracking-[0.2em] ml-4">Deskripsi Bagian Kontak</label>
                        <textarea name="contact_description" id="contact_description" rows="3" class="w-full bg-gray-50 dark:bg-slate-800 border-none rounded-2xl px-6 py-4 focus:ring-2 focus:ring-red-600 transition-all font-bold text-gray-900 dark:text-white" placeholder="Masukkan deskripsi kontak...">{{ $settings['contact_description'] }}</textarea>
                    </div>
                </div>
            </section>

            <!-- GROUP 4: INFO KONTAK & FOOTER -->
            <section class="space-y-6 pt-8 border-t border-gray-100 dark:border-slate-800">
                <div class="border-l-4 border-red-600 pl-4">
                    <h4 class="text-sm font-black text-gray-900 dark:text-white uppercase tracking-widest">4. Info Kontak & Footer</h4>
                    <p class="text-[10px] text-gray-500 font-bold uppercase tracking-tight">Informasi kontak resmi yang muncul di footer dan halaman kontak.</p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <div class="space-y-2 md:col-span-2">
                        <label for="site_address" class="text-[10px] font-black text-gray-400 uppercase tracking-[0.2em] ml-4">Alamat Kantor</label>
                        <input type="text" name="site_address" id="site_address" value="{{ $settings['site_address'] }}" class="w-full bg-gray-50 dark:bg-slate-800 border-none rounded-2xl px-6 py-4 focus:ring-2 focus:ring-red-600 transition-all font-bold text-gray-900 dark:text-white" placeholder="Masukkan alamat lengkap...">
                    </div>

                    <div class="space-y-2">
                        <label for="site_phone" class="text-[10px] font-black text-gray-400 uppercase tracking-[0.2em] ml-4">Nomor Telepon</label>
                        <input type="text" name="site_phone" id="site_phone" value="{{ $settings['site_phone'] }}" class="w-full bg-gray-50 dark:bg-slate-800 border-none rounded-2xl px-6 py-4 focus:ring-2 focus:ring-red-600 transition-all font-bold text-gray-900 dark:text-white" placeholder="Contoh: (0512) 2021065">
                    </div>

                    <div class="space-y-2">
                        <label for="site_email" class="text-[10px] font-black text-gray-400 uppercase tracking-[0.2em] ml-4">Email Instansi</label>
                        <input type="email" name="site_email" id="site_email" value="{{ $settings['site_email'] }}" class="w-full bg-gray-50 dark:bg-slate-800 border-none rounded-2xl px-6 py-4 focus:ring-2 focus:ring-red-600 transition-all font-bold text-gray-900 dark:text-white" placeholder="Contoh: jkb@politala.ac.id">
                    </div>

                    <div class="space-y-2 md:col-span-2">
                        <label for="site_description" class="text-[10px] font-black text-gray-400 uppercase tracking-[0.2em] ml-4">Deskripsi Singkat (Footer)</label>
                        <textarea name="site_description" id="site_description" rows="3" class="w-full bg-gray-50 dark:bg-slate-800 border-none rounded-2xl px-6 py-4 focus:ring-2 focus:ring-red-600 transition-all font-bold text-gray-900 dark:text-white" placeholder="Teks yang muncul di kolom pertama footer...">{{ $settings['site_description'] }}</textarea>
                    </div>

                    <div class="space-y-2 md:col-span-2">
                        <label for="footer_text" class="text-[10px] font-black text-gray-400 uppercase tracking-[0.2em] ml-4">Teks Copyright (Baris Terakhir Footer)</label>
                        <input type="text" name="footer_text" id="footer_text" value="{{ $settings['footer_text'] }}" class="w-full bg-gray-50 dark:bg-slate-800 border-none rounded-2xl px-6 py-4 focus:ring-2 focus:ring-red-600 transition-all font-bold text-gray-900 dark:text-white" placeholder="Contoh: © 2026 Jurusan Komputer dan Bisnis">
                    </div>
                </div>
            </section>
        </div>

        <div class="mt-16 flex justify-end">
            <button type="submit" class="bg-gray-900 dark:bg-red-700 text-white px-10 py-5 rounded-[2rem] font-black text-xs uppercase tracking-[0.2em] hover:scale-[1.02] transition-all shadow-xl flex items-center group">
                <i class="fas fa-save mr-3 group-hover:rotate-12 transition-transform"></i>
                Simpan Semua Perubahan
            </button>
        </div>
    </form>
</div>
@endsection
