<header class="relative bg-gradient-to-r from-indigo-600 via-purple-600 to-pink-500 text-white overflow-hidden">
    <!-- Decorative Pattern -->
    <div class="absolute inset-0 opacity-10">
        <div class="absolute transform rotate-45 -left-32 -top-32 w-64 h-64 bg-white rounded-full"></div>
        <div class="absolute transform -rotate-12 right-0 top-20 w-96 h-96 bg-white rounded-full"></div>
    </div>

    <div class="container mx-auto px-6 py-10 relative z-10">
        <div class="flex flex-col lg:flex-row justify-between items-center gap-8">

            <!-- Welcome Section -->
            <div class="flex-1 text-center lg:text-left">
                <div
                    class="inline-flex items-center bg-white/20 backdrop-blur-sm px-4 py-2 rounded-full mb-4 border border-white/30">
                    <span class="text-sm font-medium">✨ Selamat Datang di SIP IDN</span>
                </div>

                <h1 class="text-4xl lg:text-5xl font-bold mb-3 drop-shadow-lg">
                    Temukan Buku <span class="text-yellow-300">Favorit</span> Anda
                </h1>

                <p class="text-lg text-white/90 mb-6 max-w-2xl">
                    Jelajahi ribuan koleksi buku berkualitas dan pinjam dengan mudah.
                </p>

                <!-- Stats Cards -->
                <div class="flex flex-wrap gap-4 justify-center lg:justify-start">
                    <div class="bg-white/20 backdrop-blur-sm border border-white/30 rounded-2xl px-6 py-3">
                        <div class="text-3xl font-bold">{{ $totalBooks ?? 0 }}</div>
                        <div class="text-sm text-white/80">Total Buku</div>
                    </div>

                    <div class="bg-white/20 backdrop-blur-sm border border-white/30 rounded-2xl px-6 py-3">
                        <div class="text-3xl font-bold">{{ $availableBooks ?? 0 }}</div>
                        <div class="text-sm text-white/80">Tersedia</div>
                    </div>

                    <div class="bg-white/20 backdrop-blur-sm border border-white/30 rounded-2xl px-6 py-3">
                        <div class="text-3xl font-bold">{{ $categoriesCount ?? 0 }}</div>
                        <div class="text-sm text-white/80">Kategori</div>
                    </div>
                </div>
            </div>

            <!-- Search Box -->
            <div class="w-full lg:w-96">
                <div class="bg-white rounded-3xl shadow-2xl p-6 backdrop-blur-sm border border-white/50">
                    <h3 class="text-gray-800 font-bold text-xl mb-4 flex items-center gap-2">
                        🔍 Cari Buku
                    </h3>

                    <div class="relative">
                        <input type="text" wire:model.live="search" placeholder="Ketik judul buku, penulis..."
                            class="w-full px-5 py-4 pr-12 text-gray-800 bg-gray-50 rounded-2xl
                                   focus:outline-none focus:ring-4 focus:ring-purple-300 transition-all border border-gray-200">
                        <button
                            class="absolute right-4 top-1/2 -translate-y-1/2 text-purple-600 hover:scale-110 transition-transform">
                            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z"
                                    clip-rule="evenodd" />
                            </svg>
                        </button>
                    </div>

                    <!-- Quick Tags -->
                    <div class="flex gap-2 mt-3 flex-wrap">

                        <!-- Reset Filter -->
                        @if ($filterCategory)
                        <span wire:click="resetFilter"
                            class="text-xs bg-gradient-to-r from-purple-500 to-blue-500 text-white px-3 py-1 rounded-full
                            hover:opacity-90 cursor-pointer">
                            Show All
                        </span>
                        @endif

                        @foreach ($categories as $category)
                            <span wire:click="setCategory({{ $category->id }})"
                                class="text-xs px-3 py-1 rounded-full cursor-pointer
                @if ($filterCategory == $category->id) bg-purple-600 text-white
                @else
                    bg-purple-100 text-purple-700 hover:bg-purple-200 @endif
            ">
                                {{ $category->name }}
                            </span>
                        @endforeach
                    </div>



                </div>
            </div>

        </div>
    </div>

    <!-- Wave Decoration -->
    <div class="absolute bottom-0 left-0 w-full overflow-hidden leading-none">
        <svg class="relative block w-full h-12" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1200 120">
            <path d="M321.39,56.44c58-10.79,114.16-30.13,172-41.86c82.39-16.72,168.19-17.73,250.45-0.39
                     C823.78,31,906.67,72,985.66,92.83c70.05,18.48,146.53,26.09,214.34,3V0H0V27.35
                     C107.13,49.53,214.26,62.7,321.39,56.44Z" class="fill-slate-50" />
        </svg>
    </div>
</header>
