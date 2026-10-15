<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">
            <!-- Konten Status Dashboard -->
            <div class="py-4">
                <div class="flex flex-col md:flex-row md:items-center justify-between gap-6">
                    <div>
                        <span class="inline-block bg-indigo-50 text-indigo-600 text-sm font-bold px-4 py-2 rounded-full mb-4 border border-indigo-100">
                            <i class="fa-solid fa-circle-check mr-1.5"></i> Dashboard LaraPress
                        </span>
                        <h1 class="text-3xl md:text-4xl font-extrabold text-gray-900 mb-2 leading-tight">
                            Halo, <span class="text-indigo-600">{{ Auth::user()->name }}</span>! 👋
                        </h1>
                        <p class="text-gray-600 text-base md:text-lg leading-relaxed">
                            {{ __("You're logged in!") }} Kamu berhasil masuk ke sistem LaraPress.
                        </p>
                    </div>

                    <div class="shrink-0 flex flex-col sm:flex-row gap-4">
                        <a href="{{ route('home') }}" class="px-7 py-3.5 bg-indigo-600 text-white font-semibold text-base rounded-2xl hover:bg-indigo-700 transition flex items-center justify-center gap-2.5 shadow-md shadow-indigo-200">
                            <i class="fa-solid fa-house text-lg"></i> Ke Halaman Beranda
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>