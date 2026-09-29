<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Halaman Kontak - LaraPress</title>
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
                <a href="/tentang-kami" class="hover:text-indigo-600 transition">Tentang Kami</a>
                <a href="/kontak" class="text-indigo-600 font-bold border-b-2 border-indigo-600 pb-1">Kontak</a>
            </nav>
        </div>
    </header>

    <!-- Main Content -->
    <main class="max-w-4xl mx-auto px-8 py-12 w-full my-auto space-y-8">
        <div class="bg-white p-10 md:p-12 rounded-3xl shadow-sm border border-gray-100">
            <h1 class="text-3xl md:text-4xl font-extrabold text-gray-900 mb-8">Halaman Kontak</h1>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-10">
                
                <!-- Sisi Kiri: Informasi Kontak Utama -->
                <div class="space-y-4">
                    <p class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-2">Informasi Kontak</p>
                    
                    <div class="flex items-center gap-4 p-4 bg-gray-50 rounded-2xl border border-gray-100">
                        <div class="w-12 h-12 bg-indigo-100 text-indigo-600 rounded-xl flex items-center justify-center shrink-0">
                            <i class="fa-solid fa-envelope text-xl"></i>
                        </div>
                        <div>
                            <p class="text-xs text-gray-400 font-semibold">Email</p>
                            <p class="text-sm md:text-base font-bold text-gray-800">jevrene09@gmail.com</p>
                        </div>
                    </div>

                    <div class="flex items-center gap-4 p-4 bg-gray-50 rounded-2xl border border-gray-100">
                        <div class="w-12 h-12 bg-indigo-100 text-indigo-600 rounded-xl flex items-center justify-center shrink-0">
                            <i class="fa-solid fa-phone text-xl"></i>
                        </div>
                        <div>
                            <p class="text-xs text-gray-400 font-semibold">Telepon</p>
                            <p class="text-sm md:text-base font-bold text-gray-800">+62 859-3288-2150</p>
                        </div>
                    </div>

                    <div class="flex items-center gap-4 p-4 bg-gray-50 rounded-2xl border border-gray-100">
                        <div class="w-12 h-12 bg-indigo-100 text-indigo-600 rounded-xl flex items-center justify-center shrink-0">
                            <i class="fa-solid fa-location-dot text-xl"></i>
                        </div>
                        <div>
                            <p class="text-xs text-gray-400 font-semibold">Alamat</p>
                            <p class="text-sm md:text-base font-bold text-gray-800">Perum. Ciriung Cemerlang, Cibinong, Kab. Bogor</p>
                        </div>
                    </div>
                </div>

                <!-- Sisi Kanan: Form Kirim Pesan Cepat -->
                <div class="bg-gray-50/80 p-6 rounded-2xl border border-gray-100 flex flex-col justify-between">
                    <div>
                        <p class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-4">Kirim Pesan Cepat</p>
                        
                        <div class="space-y-3.5">
                            <input type="text" placeholder="Nama Anda" class="w-full px-4 py-2.5 text-sm bg-white border border-gray-200 rounded-xl focus:outline-none focus:border-indigo-500">
                            <textarea placeholder="Pesan Anda..." rows="3" class="w-full px-4 py-2.5 text-sm bg-white border border-gray-200 rounded-xl focus:outline-none focus:border-indigo-500 resize-none"></textarea>
                        </div>
                    </div>
                    
                    <button type="button" onclick="alert('Pesan berhasil dikirim (Simulasi)')" class="w-full mt-4 py-3 bg-indigo-600 text-white text-sm font-semibold rounded-xl hover:bg-indigo-700 transition flex items-center justify-center gap-2 shadow-sm">
                        <i class="fa-solid fa-paper-plane"></i> Kirim Pesan
                    </button>
                </div>

            </div>

            <!-- Navigasi Kembali -->
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