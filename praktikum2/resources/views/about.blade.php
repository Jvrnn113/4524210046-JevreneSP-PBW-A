<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tentang Kami - LaraPress</title>
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
                <a href="/" class="hover:text-indigo-600 transition">Beranda</a>
                <a href="/tentang-kami" class="text-indigo-600 font-bold border-b-2 border-indigo-600 pb-1">Tentang Kami</a>
                <a href="/kontak" class="hover:text-indigo-600 transition">Kontak</a>
            </nav>
        </div>
    </header>

    <!-- Main Content -->
    <main class="max-w-3xl mx-auto px-8 py-12 w-full my-auto space-y-8">
        
        <!-- Kartu Utama -->
        <div class="bg-white p-10 md:p-12 rounded-3xl shadow-sm border border-gray-100">
            <div class="flex items-center gap-3 text-indigo-600 mb-3">
                <i class="fa-solid fa-users text-2xl"></i>
                <span class="text-sm font-bold uppercase tracking-wider">Tentang Kami</span>
            </div>

            <h1 class="text-3xl md:text-4xl font-extrabold text-gray-900 mb-5">
                Tentang LaraPress
            </h1>

            <p class="text-gray-600 text-lg leading-relaxed mb-8">
                LaraPress adalah sebuah proyek blog sederhana yang dibuat untuk mempelajari dasar-dasar framework Laravel 12.
            </p>

            <!-- Kartu Statistik / Pilar Pembelajaran -->
            <div class="grid grid-cols-3 gap-4 mb-10 text-center">
                <div class="bg-indigo-50/60 p-5 rounded-2xl border border-indigo-100">
                    <p class="text-xl md:text-2xl font-extrabold text-indigo-600">v12.x</p>
                    <p class="text-xs md:text-sm text-gray-600 font-medium mt-1">Laravel Framework</p>
                </div>
                <div class="bg-indigo-50/60 p-5 rounded-2xl border border-indigo-100">
                    <p class="text-xl md:text-2xl font-extrabold text-indigo-600">Clean</p>
                    <p class="text-xs md:text-sm text-gray-600 font-medium mt-1">MVC Architecture</p>
                </div>
                <div class="bg-indigo-50/60 p-5 rounded-2xl border border-indigo-100">
                    <p class="text-xl md:text-2xl font-extrabold text-indigo-600">Tailwind</p>
                    <p class="text-xs md:text-sm text-gray-600 font-medium mt-1">Modern Styling</p>
                </div>
            </div>

            <div class="border-t border-gray-100 pt-8">
                <a href="/" class="inline-flex items-center gap-2.5 text-indigo-600 text-base font-bold hover:text-indigo-800 transition">
                    <i class="fa-solid fa-arrow-left text-lg"></i> Kembali ke Halaman Utama
                </a>
            </div>
        </div>

    </main>

    <!-- Footer -->
    <footer class="bg-white border-t border-gray-100 py-5 text-center text-sm font-medium text-gray-400">
        <p>&copy; {{ date('Y') }} LaraPress. All rights reserved.</p>
    </footer>

</body>
</html>