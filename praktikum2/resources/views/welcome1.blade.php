<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Selamat Datang di LaraPress</title>
    <!-- Tailwind CSS & Font Awesome -->
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
</head>
<body class="bg-gray-50 text-gray-800 min-h-screen flex flex-col justify-between font-sans">

    <!-- Header Navbar -->
    <header class="bg-white shadow-sm border-b border-gray-100 sticky top-0 z-50">
        <div class="max-w-5xl mx-auto px-8 py-5 flex justify-between items-center">
            <a href="/" class="text-2xl font-bold text-indigo-600 flex items-center gap-3">
                <i class="fa-solid fa-newspaper text-3xl"></i> LaraPress
            </a>
            <nav class="flex gap-8 font-semibold text-base text-gray-600">
                <a href="/" class="text-indigo-600 font-bold border-b-2 border-indigo-600 pb-1">Beranda</a>
                <a href="/tentang-kami" class="hover:text-indigo-600 transition">Tentang Kami</a>
                <a href="/kontak" class="hover:text-indigo-600 transition">Kontak</a>
            </nav>
        </div>
    </header>

    <!-- Main Content -->
    <main class="max-w-4xl mx-auto px-8 py-12 w-full my-auto space-y-8">
        
        <!-- Hero Section Utama -->
        <div class="bg-white p-10 md:p-14 rounded-3xl shadow-sm border border-gray-100 text-center">
            <span class="inline-block bg-indigo-50 text-indigo-600 text-sm font-bold px-4 py-2 rounded-full mb-6 border border-indigo-100">
                <i class="fa-solid fa-bolt mr-1.5"></i> Praktikum - Pemrograman Berbasis Web
            </span>
            
            <h1 class="text-4xl md:text-5xl font-extrabold text-gray-900 mb-5 leading-tight">
                Selamat Datang di Blog <span class="text-indigo-600">LaraPress</span>
            </h1>
            
            <p class="text-gray-600 text-lg md:text-xl mb-10 leading-relaxed max-w-2xl mx-auto">
                Ini adalah halaman utama dari blog kita. Silakan jelajahi halaman lain untuk melihat informasi lebih lanjut.
            </p>

            <div class="flex flex-col sm:flex-row justify-center gap-4">
                <a href="/tentang-kami" class="px-7 py-3.5 bg-indigo-600 text-white font-semibold text-base rounded-2xl hover:bg-indigo-700 transition flex items-center justify-center gap-2.5 shadow-md shadow-indigo-200">
                    <i class="fa-solid fa-circle-info text-lg"></i> Lihat Halaman Tentang Kami
                </a>
                <a href="/kontak" class="px-7 py-3.5 bg-gray-100 text-gray-700 font-semibold text-base rounded-2xl hover:bg-gray-200 transition flex items-center justify-center gap-2.5">
                    <i class="fa-solid fa-envelope text-lg"></i> Buka Halaman Kontak
                </a>
            </div>
        </div>

        <!-- Fitur Tambahan (3 Kartu di Bawah) -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm flex items-start gap-4">
                <div class="p-3.5 bg-indigo-50 text-indigo-600 rounded-2xl shrink-0">
                    <i class="fa-solid fa-rocket text-2xl"></i>
                </div>
                <div>
                    <h3 class="text-base font-bold text-gray-900">Performa Tinggi</h3>
                    <p class="text-sm text-gray-500 mt-1 leading-normal">Ditenagai oleh framework modern Laravel versi 12.</p>
                </div>
            </div>

            <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm flex items-start gap-4">
                <div class="p-3.5 bg-indigo-50 text-indigo-600 rounded-2xl shrink-0">
                    <i class="fa-solid fa-compass text-2xl"></i>
                </div>
                <div>
                    <h3 class="text-base font-bold text-gray-900">Rute Fleksibel</h3>
                    <p class="text-sm text-gray-500 mt-1 leading-normal">Sistem navigasi URL terstruktur dan mudah diakses.</p>
                </div>
            </div>

            <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm flex items-start gap-4">
                <div class="p-3.5 bg-indigo-50 text-indigo-600 rounded-2xl shrink-0">
                    <i class="fa-solid fa-code text-2xl"></i>
                </div>
                <div>
                    <h3 class="text-base font-bold text-gray-900">Blade Templating</h3>
                    <p class="text-sm text-gray-500 mt-1 leading-normal">Tampilan dinamis, bersih, dan mudah dikelola.</p>
                </div>
            </div>
        </div>

    </main>

    <!-- Footer -->
    <footer class="bg-white border-t border-gray-100 py-5 text-center text-sm font-medium text-gray-400">
        <p>&copy; {{ date('Y') }} LaraPress. All rights reserved.</p>
    </footer>

</body>
</html>