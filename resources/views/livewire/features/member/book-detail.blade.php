<div class="max-w-7xl mx-auto px-6 py-10">

    <!-- Flash Messages -->
    @if (session()->has('message'))
        <div class="mb-6 p-4 bg-green-100 border border-green-400 text-green-700 rounded-xl flex items-center justify-between">
            <span>{{ session('message') }}</span>
            <button onclick="this.parentElement.style.display='none'" class="text-green-700 hover:text-green-900">
                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                </svg>
            </button>
        </div>
    @endif

    @if (session()->has('error'))
        <div class="mb-6 p-4 bg-red-100 border border-red-400 text-red-700 rounded-xl flex items-center justify-between">
            <span>{{ session('error') }}</span>
            <button onclick="this.parentElement.style.display='none'" class="text-red-700 hover:text-red-900">
                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                </svg>
            </button>
        </div>
    @endif

    <!-- Breadcrumb -->
    <nav class="text-sm text-gray-500 mb-6 flex items-center gap-2">
        <a href="/" class="hover:text-blue-600">Beranda</a>
        <span>/</span>
        <a href="/books" class="hover:text-blue-600">Katalog</a>
        <span>/</span>
        <span class="text-gray-800 font-semibold">Detail Buku</span>
    </nav>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-10 bg-white rounded-2xl shadow-xl p-8 border border-gray-100">

        <!-- Cover Buku -->
        <div class="flex justify-center">
            <div class="bg-gradient-to-br from-blue-50 to-blue-100 border border-blue-200
                        shadow-lg backdrop-blur-md rounded-xl p-8 w-full flex items-center justify-center">

                @if($book->image)
                    <img src="{{ asset('storage/' . $book->image) }}"
                         alt="{{ $book->title }}"
                         class="w-60 h-80 object-contain rounded-lg shadow-lg">
                @else
                    <svg xmlns="http://www.w3.org/2000/svg"
                         class="w-44 h-44 text-blue-500 drop-shadow-lg"
                         fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"
                              d="M3 5a2 2 0 012-2h10a4 4 0 014 4v12a2 2 0 01-2 2H9a4 4 0 00-4-4H5V5z" />
                        <path stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"
                              d="M9 17h10" />
                    </svg>
                @endif

            </div>
        </div>

        <!-- Detail Buku -->
        <div>
            <h1 class="text-3xl font-extrabold text-gray-900 mb-3 tracking-tight">
                {{ $book->title }}
            </h1>

            <p class="text-gray-700 leading-relaxed mb-6 text-justify">
                {{ $book->description ?? 'Deskripsi belum tersedia untuk buku ini.' }}
            </p>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-8 text-sm">
                <p><span class="font-semibold text-gray-800">📘 Penulis:</span> {{ $book->author ?? '-' }}</p>

                <p><span class="font-semibold text-gray-800">🏢 Penerbit:</span> {{ $book->publisher ?? '-' }}</p>

                <p><span class="font-semibold text-gray-800">📅 Tahun:</span> {{ $book->year ?? '-' }}</p>

                <p><span class="font-semibold text-gray-800">📂 Kategori:</span> {{ $book->category->name ?? '-' }}</p>

                <p>
                    <span class="font-semibold text-gray-800">📦 Stok:</span>
                    <span class="{{ $book->stock > 0 ? 'text-green-600 font-bold' : 'text-red-600 font-bold' }}">
                        {{ $book->stock > 0 ? $book->stock.' tersedia' : 'Stok habis' }}
                    </span>
                </p>
            </div>

            <!-- Action Buttons -->
            <div class="flex flex-wrap gap-3">
                <a href="{{ route('member.dashboard') }}" wire:navigate
                   class="px-5 py-2.5 bg-gray-200 hover:bg-gray-300 text-gray-800 rounded-xl transition font-semibold shadow">
                    ← Kembali
                </a>

                @if($book->stock > 0 && $book->is_available)
                    <button wire:click="borrowBook"
                            class="px-5 py-2.5 bg-blue-600 hover:bg-blue-700 text-white rounded-xl transition font-semibold shadow">
                        Pinjam Buku
                    </button>
                @else
                    <button class="px-5 py-2.5 bg-gray-400 text-white rounded-xl shadow cursor-not-allowed">
                        Tidak Tersedia
                    </button>
                @endif

                <!-- Tombol Wishlist -->
                <button wire:click="toggleWishlist"
                        class="px-5 py-2.5 {{ $isInWishlist ? 'bg-red-500 hover:bg-red-600' : 'bg-pink-500 hover:bg-pink-600' }} text-white rounded-xl transition font-semibold shadow flex items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg"
                         class="w-5 h-5"
                         fill="{{ $isInWishlist ? 'currentColor' : 'none' }}"
                         viewBox="0 0 24 24"
                         stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                    </svg>
                    <span class="hidden sm:inline">{{ $isInWishlist ? 'Hapus dari Wishlist' : 'Tambah ke Wishlist' }}</span>
                    <span class="sm:hidden">Wishlist</span>
                </button>
            </div>
        </div>

    </div>

    <!-- Buku Serupa -->
    @if($relatedBooks->isNotEmpty())
        <div class="mt-14">

            <h3 class="text-xl font-bold text-gray-900 mb-5">📚 Buku Serupa</h3>

            <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-7">

                @foreach($relatedBooks as $related)
                    <div class="bg-white border border-gray-100 rounded-xl shadow-md hover:shadow-xl transition p-4">

                        <!-- Gambar Buku Serupa -->
                        <div class="flex items-center justify-center bg-gradient-to-br
                                    from-gray-50 to-gray-100 rounded-lg h-52 mb-4 shadow-inner">

                                @if ($related->image)
                                    <img src="{{ asset('storage/' . $related->image) }}"
                                        alt="{{ $related->title }}"
                                        class="w-full h-full object-contain rounded-lg">
                                @else
                                    <svg xmlns="http://www.w3.org/2000/svg"
                                        class="w-16 h-16 text-blue-400"
                                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"
                                            d="M3 5a2 2 0 012-2h10a4 4 0 014 4v12a2 2 0 01-2 2H9a4 4 0 00-4-4H5V5z" />
                                        <path stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"
                                            d="M9 17h10" />
                                    </svg>
                                @endif

                        </div>

                        <h4 class="font-semibold text-gray-900 leading-tight truncate">{{ $related->title }}</h4>
                        <p class="text-sm text-gray-600 mb-2">{{ $related->author }}</p>

                        <a href="{{ route('member.book.detail', $related->id) }}" wire:navigate
                           class="text-blue-600 hover:text-blue-700 text-sm font-semibold">
                            Lihat Detail →
                        </a>
                    </div>
                @endforeach

            </div>
        </div>
    @endif
</div>
