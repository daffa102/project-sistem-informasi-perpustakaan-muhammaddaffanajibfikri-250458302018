<div>
    <main class="container mx-auto px-6 py-10 flex-grow relative z-10">

        <!-- QUICK BORROW SECTION -->
        <section class="bg-white/80 backdrop-blur-sm shadow-xl rounded-3xl p-8 mb-10 border border-white/50 hover:shadow-2xl transition-all duration-300">
            <div class="flex items-center gap-3 mb-6">
                <div class="w-12 h-12 bg-gradient-to-br from-blue-500 to-purple-500 rounded-2xl flex items-center justify-center text-white text-2xl shadow-lg">
                    ⚡
                </div>
                <div>
                    <h2 class="text-2xl font-bold text-gray-800">Pinjam Cepat</h2>
                    <p class="text-sm text-gray-600">Masukkan kode buku atau scan QR Code untuk meminjam langsung</p>
                </div>
            </div>

            <form wire:submit.prevent="submitQRCode" class="flex flex-col sm:flex-row gap-4">
                <div class="flex-1 relative">
                    <input
                        type="text"
                        wire:model="qrcode"
                        placeholder="Masukkan UUID atau Kode QR Buku"
                        class="w-full px-6 py-4 border-2 border-gray-200 rounded-2xl focus:outline-none focus:ring-4 focus:ring-purple-300 focus:border-purple-400 transition-all text-gray-800 font-medium"
                    >
                    <div class="absolute right-4 top-1/2 transform -translate-y-1/2 text-gray-400">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M3 4a1 1 0 011-1h3a1 1 0 011 1v3a1 1 0 01-1 1H4a1 1 0 01-1-1V4zm2 2V5h1v1H5zM3 13a1 1 0 011-1h3a1 1 0 011 1v3a1 1 0 01-1 1H4a1 1 0 01-1-1v-3zm2 2v-1h1v1H5zM13 3a1 1 0 00-1 1v3a1 1 0 001 1h3a1 1 0 001-1V4a1 1 0 00-1-1h-3zm1 2v1h1V5h-1z" clip-rule="evenodd"/>
                        </svg>
                    </div>
                </div>

                <button
                    type="submit"
                    class="bg-gradient-to-r from-blue-600 to-purple-600 text-white px-8 py-4 rounded-2xl hover:from-blue-700 hover:to-purple-700 transition-all shadow-lg hover:shadow-xl font-semibold flex items-center justify-center gap-2 active:scale-95">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M9 4.804A7.968 7.968 0 005.5 4c-1.255 0-2.443.29-3.5.804v10A7.969 7.969 0 015.5 14c1.669 0 3.218.51 4.5 1.385A7.962 7.962 0 0114.5 14c1.255 0 2.443.29 3.5.804v-10A7.968 7.968 0 0014.5 4c-1.255 0-2.443.29-3.5.804V12a1 1 0 11-2 0V4.804z"/>
                    </svg>
                    Pinjam Sekarang
                </button>
            </form>

            <!-- Pesan Flash -->
            @if (session()->has('success'))
                <div class="mt-6 px-6 py-4 bg-green-50 border-l-4 border-green-500 text-green-700 rounded-2xl shadow-sm flex items-center gap-3 animate-fadeIn">
                    <div class="w-10 h-10 bg-green-500 rounded-full flex items-center justify-center text-white text-xl">
                        ✓
                    </div>
                    <div>
                        <p class="font-semibold">Berhasil!</p>
                        <p class="text-sm">{{ session('success') }}</p>
                    </div>
                </div>
            @endif

            @if (session()->has('error'))
                <div class="mt-6 px-6 py-4 bg-red-50 border-l-4 border-red-500 text-red-700 rounded-2xl shadow-sm flex items-center gap-3 animate-fadeIn">
                    <div class="w-10 h-10 bg-red-500 rounded-full flex items-center justify-center text-white text-xl">
                        ✗
                    </div>
                    <div>
                        <p class="font-semibold">Gagal!</p>
                        <p class="text-sm">{{ session('error') }}</p>
                    </div>
                </div>
            @endif
        </section>

        <!-- KATALOG BUKU -->
        <section>
            <div class="flex items-center justify-between mb-8">
                <div class="flex items-center gap-3">
                    <div class="w-12 h-12 bg-gradient-to-br from-purple-500 to-pink-500 rounded-2xl flex items-center justify-center text-white text-2xl shadow-lg">
                        📚
                    </div>
                    <div>
                        <h2 class="text-3xl font-bold text-gray-800">Katalog Buku</h2>
                        <p class="text-sm text-gray-600">Koleksi terbaik untuk Anda</p>
                    </div>
                </div>

                <!-- Filter Buttons -->
                <div class="hidden md:flex gap-2">
                    <button
                        wire:click="resetFilter"
                        class="px-4 py-2 {{ is_null($filterCategory) ? 'bg-purple-600 text-white' : 'bg-white text-gray-700' }} rounded-xl hover:bg-purple-700 hover:text-white transition-all shadow-md text-sm font-medium">
                        Semua
                    </button>
                    @foreach($categories as $cat)
                        <button
                            wire:click="setCategory({{ $cat->id }})"
                            class="px-4 py-2 {{ $filterCategory == $cat->id ? 'bg-purple-600 text-white' : 'bg-white text-gray-700' }} rounded-xl hover:bg-purple-700 hover:text-white transition-all shadow-md text-sm font-medium">
                            {{ $cat->name }}
                        </button>
                    @endforeach
                </div>
            </div>

            <!-- Book Grid -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                @forelse($books as $book)
                    <div class="group bg-white rounded-3xl overflow-hidden shadow-lg hover:shadow-2xl transition-all duration-500 border border-gray-100 hover:-translate-y-2">
                        <div class="relative overflow-hidden">
                            @if ($book->image)
                                <img src="{{ asset('storage/' . $book->image) }}" class="w-full h-64 object-cover group-hover:scale-110 transition-all duration-500" alt="{{ $book->title }}">
                            @else
                                <div class="w-full h-64 bg-gradient-to-br from-indigo-100 via-purple-100 to-pink-100 flex items-center justify-center text-7xl group-hover:scale-110 transition-transform duration-500">
                                    📖
                                </div>
                            @endif

                            <div class="absolute top-3 right-3 {{ $book->is_available ? 'bg-green-500' : 'bg-red-500' }} text-white text-xs font-bold px-3 py-1.5 rounded-full shadow-lg flex items-center gap-1">
                                <div class="w-2 h-2 bg-white rounded-full {{ $book->is_available ? 'animate-pulse' : '' }}"></div>
                                {{ $book->is_available ? 'Tersedia' : 'Dipinjam' }}
                            </div>

                            <div class="absolute top-3 left-3 bg-white/90 backdrop-blur-sm text-purple-700 text-xs font-semibold px-3 py-1.5 rounded-full shadow-md">
                                {{ $book->category->name ?? 'Umum' }}
                            </div>
                        </div>

                        <div class="p-6">
                            <h3 class="text-lg font-bold text-gray-800 mb-2 line-clamp-2 group-hover:text-purple-600 transition-colors">
                                {{ $book->title }}
                            </h3>

                            <div class="flex items-center gap-2 text-sm text-gray-600 mb-3">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"/>
                                </svg>
                                <span class="truncate">{{ $book->author }}</span>
                            </div>

                            <p class="text-sm text-gray-600 mb-4 line-clamp-3 leading-relaxed">
                                {{ $book->description ?? 'Buku ini berisi pengetahuan yang sangat bermanfaat untuk menambah wawasan dan pemahaman Anda.' }}
                            </p>

                            <div class="flex items-center gap-2 mb-4 bg-gray-50 px-3 py-2 rounded-xl">
                                <svg class="w-4 h-4 text-gray-500" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M3 4a1 1 0 011-1h3a1 1 0 011 1v3a1 1 0 01-1 1H4a1 1 0 01-1-1V4zm2 2V5h1v1H5zM3 13a1 1 0 011-1h3a1 1 0 011 1v3a1 1 0 01-1 1H4a1 1 0 01-1-1v-3zm2 2v-1h1v1H5zM13 3a1 1 0 00-1 1v3a1 1 0 001 1h3a1 1 0 001-1V4a1 1 0 00-1-1h-3zm1 2v1h1V5h-1z" clip-rule="evenodd"/>
                                </svg>

                                <span class="text-sm font-mono font-semibold text-gray-700">
        {{ pathinfo($book->qrcode, PATHINFO_FILENAME) }}
                                </span>
                            </div>


                            <!-- ✅ Tombol Pinjam atau Lihat Detail -->
                            @if($book->is_available)
                                <div class="flex gap-2">
                                    <button
                                        wire:click="quickBorrow({{ $book->id }})"
                                        class="flex-1 bg-gradient-to-r from-green-600 to-emerald-600 text-white py-3 rounded-2xl hover:from-green-700 hover:to-emerald-700 transition-all shadow-md hover:shadow-xl font-semibold flex items-center justify-center gap-2 active:scale-95">
                                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M9 4.804A7.968 7.968 0 005.5 4c-1.255 0-2.443.29-3.5.804v10A7.969 7.969 0 015.5 14c1.669 0 3.218.51 4.5 1.385A7.962 7.962 0 0114.5 14c1.255 0 2.443.29 3.5.804v-10A7.968 7.968 0 0014.5 4c-1.255 0-2.443.29-3.5.804V12a1 1 0 11-2 0V4.804z"/>
                                        </svg>
                                        Pinjam
                                    </button>
                                    <a
                                        href="{{ route('member.book.detail', $book->id) }}" wire:navigate
                                        class="flex-1 bg-gradient-to-r from-purple-600 to-pink-600 text-white py-3 rounded-2xl hover:from-purple-700 hover:to-pink-700 transition-all shadow-md hover:shadow-xl font-semibold flex items-center justify-center gap-2 active:scale-95">
                                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M10 12a2 2 0 100-4 2 2 0 000 4z"/>
                                            <path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd"/>
                                        </svg>
                                        Detail
                                    </a>
                                </div>
                            @else
                                <a
                                    href="{{ route('member.book.detail', $book->id) }}" wire:navigate
                                    class="w-full bg-gradient-to-r from-purple-600 to-pink-600 text-white py-3 rounded-2xl hover:from-purple-700 hover:to-pink-700 transition-all shadow-md hover:shadow-xl font-semibold flex items-center justify-center gap-2 active:scale-95">
                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M10 12a2 2 0 100-4 2 2 0 000 4z"/>
                                        <path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd"/>
                                    </svg>
                                    Lihat Detail
                                </a>
                            @endif
                        </div>
                    </div>
                @empty
                    <div class="col-span-full">
                        <div class="bg-white/80 backdrop-blur-sm rounded-3xl p-16 text-center border border-gray-200">
                            <div class="text-8xl mb-6 opacity-50">📚</div>
                            <h3 class="text-2xl font-bold text-gray-800 mb-2">Tidak Ada Buku Ditemukan</h3>
                            <p class="text-gray-600 mb-6">Coba gunakan kata kunci lain atau jelajahi kategori berbeda</p>
                            <button wire:click="resetFilter" class="bg-gradient-to-r from-purple-600 to-pink-600 text-white px-8 py-3 rounded-2xl hover:from-purple-700 hover:to-pink-700 transition-all shadow-lg font-semibold">
                                Lihat Semua Buku
                            </button>
                        </div>
                    </div>
                @endforelse
            </div>

            <div class="mt-8">
                {{ $books->links() }}
            </div>
        </section>
    </main>
</div>
