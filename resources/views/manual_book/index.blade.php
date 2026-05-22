@extends('layouts.app')

@section('header', 'Panduan Penggunaan (Manual Book)')

@section('content')
<div class="flex flex-col lg:flex-row gap-8" x-data="{ tab: 'intro' }">
    <!-- Sidebar Navigation -->
    <div class="lg:w-1/4">
        <div class="bg-white dark:bg-slate-900 rounded-[2.5rem] p-6 shadow-sm border border-gray-100 dark:border-slate-800 sticky top-32">
            <h4 class="text-[10px] font-black text-gray-400 uppercase tracking-[0.2em] mb-6 ml-4">Daftar Isi</h4>
            <nav class="space-y-2">
                <button @click="tab = 'intro'" :class="tab === 'intro' ? 'bg-red-50 text-red-700 dark:bg-red-900/20 dark:text-red-400' : 'text-gray-600 dark:text-gray-400 hover:bg-gray-50 dark:hover:bg-slate-800'" class="w-full flex items-center px-6 py-4 rounded-2xl transition-all font-bold text-sm text-left group">
                    <i class="fas fa-rocket mr-3 w-5 text-center group-hover:scale-110 transition"></i>
                    Pendahuluan
                </button>
                <button @click="tab = 'identity'" :class="tab === 'identity' ? 'bg-red-50 text-red-700 dark:bg-red-900/20 dark:text-red-400' : 'text-gray-600 dark:text-gray-400 hover:bg-gray-50 dark:hover:bg-slate-800'" class="w-full flex items-center px-6 py-4 rounded-2xl transition-all font-bold text-sm text-left group">
                    <i class="fas fa-id-card mr-3 w-5 text-center group-hover:scale-110 transition"></i>
                    Identitas & Hero
                </button>
                <button @click="tab = 'posts'" :class="tab === 'posts' ? 'bg-red-50 text-red-700 dark:bg-red-900/20 dark:text-red-400' : 'text-gray-600 dark:text-gray-400 hover:bg-gray-50 dark:hover:bg-slate-800'" class="w-full flex items-center px-6 py-4 rounded-2xl transition-all font-bold text-sm text-left group">
                    <i class="fas fa-newspaper mr-3 w-5 text-center group-hover:scale-110 transition"></i>
                    Berita & Konten
                </button>
                <button @click="tab = 'backup'" :class="tab === 'backup' ? 'bg-red-50 text-red-700 dark:bg-red-900/20 dark:text-red-400' : 'text-gray-600 dark:text-gray-400 hover:bg-gray-50 dark:hover:bg-slate-800'" class="w-full flex items-center px-6 py-4 rounded-2xl transition-all font-bold text-sm text-left group">
                    <i class="fas fa-hdd mr-3 w-5 text-center group-hover:scale-110 transition"></i>
                    Backup & Restore
                </button>
                <button @click="tab = 'rbac'" :class="tab === 'rbac' ? 'bg-red-50 text-red-700 dark:bg-red-900/20 dark:text-red-400' : 'text-gray-600 dark:text-gray-400 hover:bg-gray-50 dark:hover:bg-slate-800'" class="w-full flex items-center px-6 py-4 rounded-2xl transition-all font-bold text-sm text-left group">
                    <i class="fas fa-user-shield mr-3 w-5 text-center group-hover:scale-110 transition"></i>
                    User & Hak Akses
                </button>
            </nav>
        </div>
    </div>

    <!-- Content Area -->
    <div class="lg:w-3/4">
        <div class="bg-white dark:bg-slate-900 rounded-[2.5rem] p-8 md:p-12 shadow-sm border border-gray-100 dark:border-slate-800 min-h-[600px]">
            
            <!-- Pendahuluan -->
            <div x-show="tab === 'intro'" x-cloak class="space-y-8 animate-fadeIn">
                <div class="border-l-8 border-red-600 pl-6">
                    <h2 class="text-3xl font-black text-gray-900 dark:text-white uppercase tracking-tight">Selamat Datang</h2>
                    <p class="text-gray-500 dark:text-gray-400 font-bold uppercase tracking-widest text-xs mt-2">Sistem Administrasi JKB Politala</p>
                </div>
                <p class="text-gray-600 dark:text-gray-300 leading-relaxed text-lg italic">
                    Manual Book ini dirancang untuk membantu Anda memahami cara kerja sistem manajemen konten (CMS) Jurusan Komputer dan Bisnis. Sistem ini menggunakan teknologi modern untuk memastikan pengelolaan data yang cepat, aman, dan efisien.
                </p>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 pt-8">
                    <div class="p-8 bg-slate-50 dark:bg-slate-800/50 rounded-3xl border border-gray-100 dark:border-slate-700 shadow-sm">
                        <i class="fas fa-check-circle text-green-500 text-3xl mb-4"></i>
                        <h5 class="font-black text-gray-900 dark:text-white uppercase text-sm mb-2">Mudah Digunakan</h5>
                        <p class="text-xs text-gray-500 leading-relaxed">Antarmuka yang bersih dan responsif memudahkan pengelolaan dari perangkat apa pun.</p>
                    </div>
                    <div class="p-8 bg-slate-50 dark:bg-slate-800/50 rounded-3xl border border-gray-100 dark:border-slate-700 shadow-sm">
                        <i class="fas fa-shield-alt text-blue-500 text-3xl mb-4"></i>
                        <h5 class="font-black text-gray-900 dark:text-white uppercase text-sm mb-2">Keamanan Terjamin</h5>
                        <p class="text-xs text-gray-500 leading-relaxed">Sistem dilengkapi dengan Role-Based Access Control (RBAC) yang ketat.</p>
                    </div>
                </div>
            </div>

            <!-- Identitas & Hero -->
            <div x-show="tab === 'identity'" x-cloak class="space-y-8 animate-fadeIn">
                <h3 class="text-2xl font-black text-gray-900 dark:text-white uppercase tracking-tight border-b border-gray-100 dark:border-slate-800 pb-4">Identitas Situs & Landing Page</h3>
                <div class="space-y-6">
                    <div class="bg-gray-50 dark:bg-slate-800/50 p-6 rounded-2xl">
                        <h5 class="font-bold text-red-700 dark:text-red-400 mb-2">A. Mengubah Logo & Nama</h5>
                        <p class="text-sm text-gray-600 dark:text-gray-400 leading-relaxed">Buka menu <strong>Pengaturan Sistem > Identitas Situs</strong>. Perubahan nama dan logo akan langsung berdampak pada seluruh halaman website dan sidebar admin.</p>
                    </div>
                    <div class="bg-gray-50 dark:bg-slate-800/50 p-6 rounded-2xl">
                        <h5 class="font-bold text-red-700 dark:text-red-400 mb-2">B. Bagian Hero (Sambutan)</h5>
                        <p class="text-sm text-gray-600 dark:text-gray-400 leading-relaxed">Anda dapat mengubah judul besar, deskripsi, dan teks tombol di bagian paling atas beranda melalui grup pengaturan <strong>"Bagian Hero"</strong>.</p>
                    </div>
                    <div class="bg-gray-50 dark:bg-slate-800/50 p-6 rounded-2xl">
                        <h5 class="font-bold text-red-700 dark:text-red-400 mb-2">C. Informasi Footer</h5>
                        <p class="text-sm text-gray-600 dark:text-gray-400 leading-relaxed">Alamat, nomor telepon, dan email yang diisi di grup <strong>"Info Kontak & Footer"</strong> akan muncul secara otomatis di bagian bawah website dan section kontak.</p>
                    </div>
                </div>
            </div>

            <!-- Berita & Konten -->
            <div x-show="tab === 'posts'" x-cloak class="space-y-8 animate-fadeIn">
                <h3 class="text-2xl font-black text-gray-900 dark:text-white uppercase tracking-tight border-b border-gray-100 dark:border-slate-800 pb-4">Manajemen Berita & Konten</h3>
                <div class="space-y-6">
                    <p class="text-gray-600 dark:text-gray-400 italic">Gunakan menu <strong>Berita > Kelola Berita</strong> untuk mempublikasikan informasi terbaru.</p>
                    <ul class="list-disc ml-6 space-y-4 text-sm text-gray-600 dark:text-gray-400">
                        <li><strong>Draf vs Publish:</strong> Berita yang masih dalam pengerjaan dapat disimpan sebagai draf sebelum dipublikasikan.</li>
                        <li><strong>Gambar Utama:</strong> Pastikan mengunggah gambar dengan rasio 16:9 untuk tampilan terbaik di beranda.</li>
                        <li><strong>Kategori:</strong> Kelompokkan berita (misal: Akademik, Event, Pengumuman) melalui menu <strong>Kategori</strong>.</li>
                        <li><strong>Website Prodi:</strong> Pada menu <strong>Program Studi</strong>, Anda dapat menambahkan URL website resmi masing-masing prodi agar pengunjung dapat langsung menuju website prodi terkait dari halaman landing.</li>
                        <li><strong>SEO:</strong> Isi deskripsi SEO agar berita lebih mudah ditemukan di mesin pencari seperti Google.</li>
                    </ul>
                </div>
            </div>

            <!-- Backup & Restore -->
            <div x-show="tab === 'backup'" x-cloak class="space-y-8 animate-fadeIn">
                <h3 class="text-2xl font-black text-gray-900 dark:text-white uppercase tracking-tight border-b border-gray-100 dark:border-slate-800 pb-4">Keamanan Data: Backup & Restore</h3>
                
                <div class="bg-amber-50 dark:bg-amber-900/20 border-l-4 border-amber-500 p-6 rounded-r-2xl">
                    <h5 class="font-black text-amber-900 dark:text-amber-400 uppercase text-xs mb-2">Penting!</h5>
                    <p class="text-xs text-amber-700 dark:text-amber-500 italic">Pencadangan rutin adalah satu-satunya cara untuk menjamin data Anda tidak hilang jika terjadi kerusakan server atau kesalahan manusia.</p>
                </div>

                <div class="space-y-6">
                    <div>
                        <h5 class="font-bold text-gray-900 dark:text-white mb-3">Cara Melakukan Backup:</h5>
                        <ol class="list-decimal ml-6 space-y-2 text-sm text-gray-600 dark:text-gray-400">
                            <li>Buka menu <strong>Pengaturan Sistem > Pencadangan Data</strong>.</li>
                            <li>Klik tombol <strong>"Buat Backup Baru"</strong>.</li>
                            <li>Setelah file muncul di tabel, klik ikon <strong>Download</strong> untuk menyimpan file ke komputer Anda.</li>
                        </ol>
                    </div>

                    <div class="pt-4">
                        <h5 class="font-bold text-gray-900 dark:text-white mb-3">Cara Melakukan Restore (Pemulihan):</h5>
                        <p class="text-sm text-gray-600 dark:text-gray-400 leading-relaxed mb-4">
                            Untuk alasan keamanan, pemulihan data dilakukan secara manual oleh tim IT melalui panel database:
                        </p>
                        <ul class="list-disc ml-6 space-y-2 text-sm text-gray-600 dark:text-gray-400">
                            <li>Buka <strong>phpMyAdmin</strong>.</li>
                            <li>Pilih database yang bersangkutan.</li>
                            <li>Gunakan fitur <strong>Import</strong> dan pilih file <code>.sql</code> yang telah Anda unduh sebelumnya.</li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- RBAC -->
            <div x-show="tab === 'rbac'" x-cloak class="space-y-8 animate-fadeIn">
                <h3 class="text-2xl font-black text-gray-900 dark:text-white uppercase tracking-tight border-b border-gray-100 dark:border-slate-800 pb-4">Pengguna & Hak Akses (RBAC)</h3>
                <p class="text-sm text-gray-600 dark:text-gray-400 leading-relaxed">
                    Sistem ini menggunakan struktur <strong>Role-Based Access Control</strong> yang memungkinkan pembagian tugas secara spesifik:
                </p>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="p-6 border border-gray-100 dark:border-slate-800 rounded-2xl">
                        <span class="px-3 py-1 bg-red-100 text-red-700 rounded-full text-[10px] font-black uppercase tracking-widest mb-3 inline-block">Role: Admin</span>
                        <p class="text-xs text-gray-500 leading-relaxed">Memiliki akses penuh ke seluruh sistem, termasuk pengaturan keamanan dan backup.</p>
                    </div>
                    <div class="p-6 border border-gray-100 dark:border-slate-800 rounded-2xl">
                        <span class="px-3 py-1 bg-blue-100 text-blue-700 rounded-full text-[10px] font-black uppercase tracking-widest mb-3 inline-block">Role: Operator</span>
                        <p class="text-xs text-gray-500 leading-relaxed">Fokus pada pengelolaan konten berita, galeri, dan dokumen tanpa akses ke pengaturan sistem.</p>
                    </div>
                </div>
                <div class="bg-gray-50 dark:bg-slate-800/50 p-6 rounded-2xl">
                    <p class="text-xs text-gray-500 leading-relaxed italic">
                        <i class="fas fa-exclamation-circle mr-2 text-red-600"></i>
                        Gunakan menu <strong>Manajemen User</strong> untuk menambah staf baru dan <strong>Role & Permission</strong> untuk mengatur detail hak aksesnya.
                    </p>
                </div>
            </div>

        </div>
    </div>
</div>

<style>
    .animate-fadeIn {
        animation: fadeIn 0.4s ease-out;
    }
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(10px); }
        to { opacity: 1; transform: translateY(0); }
    }
</style>
@endsection
