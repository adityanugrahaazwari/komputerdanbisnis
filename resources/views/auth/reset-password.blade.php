<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password - JKB POLITALA</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" />
    <style>
        :root {
            --primary-color: {{ $siteSettings['primary_color'] ?? '#ef4444' }};
        }
        .login-gradient {
            background: linear-gradient(135deg, var(--primary-color) 0%, #450a0a 100%);
        }
    </style>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: 'var(--primary-color)',
                        red: {
                            50: '#fef2f2', 100: '#fee2e2', 200: '#fecaca', 300: '#fca5a5', 400: '#f87171',
                            500: 'var(--primary-color)', 600: 'var(--primary-color)', 700: 'var(--primary-color)', 800: 'var(--primary-color)', 900: 'var(--primary-color)',
                        }
                    }
                }
            }
        }
    </script>
</head>
<body class="login-gradient flex items-center justify-center min-h-screen p-4">

    <div class="max-w-md w-full">
        <div class="text-center mb-10">
            <div class="inline-flex items-center justify-center w-20 h-20 bg-white rounded-3xl shadow-2xl mb-6 transform -rotate-12">
                <i class="fas fa-university text-4xl text-primary"></i>
            </div>
            <h1 class="text-3xl font-black text-white tracking-tighter uppercase">JKB POLITALA</h1>
            <p class="text-white/70 font-medium">Sistem Informasi Manajemen Jurusan</p>
        </div>

        <div class="bg-white/95 backdrop-blur-md p-10 rounded-[2.5rem] shadow-2xl relative overflow-hidden">
            <div class="absolute top-0 left-0 w-full h-2 bg-primary"></div>
            
            <h2 class="text-2xl font-black text-gray-900 mb-4">Reset Password</h2>
            <p class="text-gray-500 text-sm mb-8">Silakan masukkan kata sandi baru Anda.</p>

            @if($errors->any())
                <div class="bg-red-50 border-l-4 border-red-600 text-red-700 p-4 mb-8 rounded-r-lg" role="alert">
                    <p class="font-bold text-sm uppercase mb-1">Terjadi Kesalahan</p>
                    <ul class="text-sm opacity-90">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('password.update') }}" method="POST" class="space-y-6">
                @csrf
                <input type="hidden" name="token" value="{{ $token }}">
                
                <div>
                    <label class="block text-gray-700 text-xs font-black uppercase tracking-widest mb-2 ml-1">Alamat Email</label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 pl-4 flex items-center text-gray-400">
                            <i class="fas fa-envelope"></i>
                        </span>
                        <input type="email" name="email" value="{{ $email ?? old('email') }}" required class="w-full pl-11 pr-4 py-4 bg-gray-50 border border-gray-100 rounded-2xl focus:ring-2 focus:ring-primary focus:bg-white transition-all outline-none text-gray-700 font-medium" placeholder="nama@email.com">
                    </div>
                </div>

                <div>
                    <label class="block text-gray-700 text-xs font-black uppercase tracking-widest mb-2 ml-1">Kata Sandi Baru</label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 pl-4 flex items-center text-gray-400">
                            <i class="fas fa-lock"></i>
                        </span>
                        <input type="password" name="password" required autofocus class="w-full pl-11 pr-4 py-4 bg-gray-50 border border-gray-100 rounded-2xl focus:ring-2 focus:ring-primary focus:bg-white transition-all outline-none text-gray-700 font-medium" placeholder="••••••••">
                    </div>
                </div>

                <div>
                    <label class="block text-gray-700 text-xs font-black uppercase tracking-widest mb-2 ml-1">Konfirmasi Kata Sandi</label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 pl-4 flex items-center text-gray-400">
                            <i class="fas fa-check-double"></i>
                        </span>
                        <input type="password" name="password_confirmation" required class="w-full pl-11 pr-4 py-4 bg-gray-50 border border-gray-100 rounded-2xl focus:ring-2 focus:ring-primary focus:bg-white transition-all outline-none text-gray-700 font-medium" placeholder="••••••••">
                    </div>
                </div>

                <button type="submit" class="w-full bg-primary hover:bg-primary/90 text-white font-black py-4 rounded-2xl transition transform active:scale-[0.98] shadow-xl shadow-primary/20 uppercase tracking-widest">
                    Simpan Kata Sandi
                </button>
            </form>
        </div>
    </div>

</body>
</html>
