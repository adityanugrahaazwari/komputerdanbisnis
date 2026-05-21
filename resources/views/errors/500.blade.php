<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>500 - Server Error</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" />
</head>
<body class="bg-slate-50 font-sans flex items-center justify-center min-h-screen">
    <div class="text-center p-8">
        <h1 class="text-9xl font-black text-slate-900 mb-4">500</h1>
        <p class="text-2xl font-bold text-red-700 mb-8 uppercase tracking-widest">Kesalahan Server</p>
        <p class="text-gray-500 mb-12">Terjadi kesalahan pada server kami. Kami akan segera memperbaikinya.</p>
        <a href="{{ url('/') }}" class="bg-red-700 text-white px-10 py-4 rounded-full font-black uppercase text-xs tracking-widest hover:bg-slate-900 transition shadow-xl">
            Kembali ke Beranda
        </a>
    </div>
</body>
</html>
