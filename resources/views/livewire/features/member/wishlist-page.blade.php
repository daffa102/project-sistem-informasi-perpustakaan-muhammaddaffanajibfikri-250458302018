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

    <!-- Header -->
    <div class="flex items-center justify-between mb-8">
        <div>
            <h1 class="text-3xl font-extrabold text-gray-900 mb-2">💝 Wishlist Saya</h1>
            <p class="text-gray-600">Koleksi buku yang Anda simpan untuk dibaca nanti</p>
        </div>

        @if($wishlists->count() > 0)
            <button wire:click="clearAllWishlist"
                    wire:confirm="Apakah Anda yakin ingin menghapus semua wishlist?"
                    class="px-4 py-2 bg-red-500 hover:bg-red-600 text-white rounded-xl transition font-semibold shadow text-sm">
                Hapus Semua
            </button>
        @endif
    </div>

    <!-- Wishlist Content -->
    @if($wishlists->count() > 0)
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
            @foreach($wishlists as $wishlist)
                <div class="bg-white border border-gray-100 rounded-xl shadow-md hover:shadow-xl transition-all duration-300 overflow-hidden group">

                    <!-- Book Cover -->
                    <div class="relative">
                        <div class="bg-gradient-to-br from-blue-50 to-blue-100 h-64 flex items-center justify-center p-4">
                            @if($wishlist->book->image)
                                <img src="{{ asset('storage/' . $wishlist->book->image) }}"
                                     alt="{{ $wishlist->book->title }}"
                                     class="w-full h-full object-contain rounded-lg">
                            @else
                                <svg xmlns="http://www.w3.org/2000/svg"
                                     class="w-24 h-24 text-blue-400"
                                     fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"
                                          d="M3 5a2 2 0 012-2h10a4 4 0 014 4v12a2 2 0 01-2 2H9a4 4 0 00-4-4H5V5z" />
                                    <path stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"
                                          d="M9 17h10" />
                                </svg>
                            @endif
                        </div>

                        <!-- Remove Button Overlay -->
                        <button wire:click="removeFromWishlist({{ $wishlist->id }})"
                                class="absolute top-3 right-3 bg-red-500 hover:bg-red-600 text-white p-2 rounded-full shadow-lg opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                            </svg>
                        </button>

                        <!-- Stock Badge -->
                        @if($wishlist->book->stock > 0 && $wishlist->book->status === 'available')
                            <span class="absolute top-3 left-3 bg-green-500 text-white text-xs px-3 py-1 rounded-full font-semibold shadow">
                                Tersedia
                            </span>
                        @else
                            <span class="absolute top-3 left-3 bg-red-500 text-white text-xs px-3 py-1 rounded-full font-semibold shadow">
                                Tidak Tersedia
                            </span>
                        @endif
                    </div>

                    <!-- Book Info -->
                    <div class="p-4">
                        <h3 class="font-bold text-gray-900 text-lg mb-1 line-clamp-2 leading-tight">
                            {{ $wishlist->book->title }}
                        </h3>
                        <p class="text-sm text-gray-600 mb-2">{{ $wishlist->book->author }}</p>

                        <div class="flex items-center gap-2 text-xs text-gray-500 mb-3">
                            <span class="bg-blue-100 text-blue-700 px-2 py-1 rounded">
                                {{ $wishlist->book->category->name ?? 'Tanpa Kategori' }}
                            </span>
                            @if($wishlist->book->year)
                                <span>{{ $wishlist->book->year }}</span>
                            @endif
                        </div>

                        <!-- Action Buttons -->
                        <div class="flex gap-2">
                            <a href="{{ route('member.book.detail', $wishlist->book->id) }}" wire:navigate
                               class="flex-1 text-center px-3 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg transition text-sm font-semibold">
                                Lihat Detail
                            </a>
                        </div>

                        <p class="text-xs text-gray-400 mt-3 text-center">
                            Ditambahkan {{ $wishlist->created_at->diffForHumans() }}
                        </p>
                    </div>

                </div>
            @endforeach
        </div>

        <!-- Pagination -->
        <div class="mt-8">
            {{ $wishlists->links() }}
        </div>

    @else
        <!-- Empty State -->
        <div class="bg-white rounded-2xl shadow-lg p-12 text-center">
            <div class="mb-6">
                <svg xmlns="http://www.w3.org/2000/svg"
                     class="w-32 h-32 mx-auto text-gray-300"
                     fill="none"
                     viewBox="0 0 24 24"
                     stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                          d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                </svg>
            </div>

            <h3 class="text-2xl font-bold text-gray-700 mb-3">Wishlist Masih Kosong</h3>
            <p class="text-gray-500 mb-6 max-w-md mx-auto">
                Anda belum menambahkan buku apapun ke wishlist. Mulai jelajahi katalog dan simpan buku favorit Anda!
            </p>

            <a href="{{ route('member.dashboard') }}" wire:navigate
               class="inline-block px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white rounded-xl transition font-semibold shadow">
                Jelajahi Buku
            </a>
        </div>
    @endif

</div>
