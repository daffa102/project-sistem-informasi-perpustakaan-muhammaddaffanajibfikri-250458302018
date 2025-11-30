<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistem Informasi Perpustakaan</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-white">
    <!-- Header Navigation -->
    <header class="sticky top-0 z-50 bg-white shadow-md">
        <nav class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4 flex justify-between items-center">
            <div class="flex items-center gap-2">
                <div class="w-10 h-10 bg-gradient-to-br from-blue-600 to-teal-600 rounded-lg flex items-center justify-center">
                    <span class="text-white font-bold text-lg">📚</span>
                </div>
                <span class="text-xl font-bold text-gray-900">LibraryHub</span>
            </div>
            <div class="hidden md:flex gap-8">
                <a href="#home" class="text-gray-700 hover:text-blue-600 transition">Beranda</a>
                <a href="#visitors" class="text-gray-700 hover:text-blue-600 transition">Pengunjung</a>
                <a href="#about" class="text-gray-700 hover:text-blue-600 transition">Tentang</a>
                <a href="#contact" class="text-gray-700 hover:text-blue-600 transition">Kontak</a>
            </div>
            <div class="flex gap-3">
                @auth
                    <a href="{{ Auth::user()->role == 'admin' ? route('admin.dashboard') : route('member.dashboard') }}" wire:navigate class="px-4 py-2 bg-gradient-to-r from-blue-600 to-teal-600 text-white rounded-lg hover:shadow-lg transition">Dashboard</a>
                @else
                    <a href="{{ route('login') }}" wire:navigate class="px-4 py-2 text-blue-600 border border-blue-600 rounded-lg hover:bg-blue-50 transition">Login</a>
                    <a href="{{ route('register') }}" wire:navigate class="px-4 py-2 bg-gradient-to-r from-blue-600 to-teal-600 text-white rounded-lg hover:shadow-lg transition">Daftar</a>
                @endauth
            </div>
        </nav>
    </header>

    <!-- Hero Section -->
    <section id="home" class="bg-gradient-to-br from-blue-50 to-teal-50 py-20 px-4">
        <div class="max-w-7xl mx-auto">
            <div class="grid md:grid-cols-2 gap-12 items-center">
                <div>
                    <h1 class="text-5xl font-bold text-gray-900 mb-6 leading-tight">
                        Akses Ribuan Buku <span class="bg-gradient-to-r from-blue-600 to-teal-600 bg-clip-text text-transparent">Kapan Saja</span>
                    </h1>
                    <p class="text-xl text-gray-600 mb-8">Sistem informasi perpustakaan modern yang memudahkan Anda menemukan, meminjam, dan mengelola koleksi buku favorit.</p>
                    <div class="flex gap-4">
                        <a href="{{ route('register') }}" wire:navigate class="px-8 py-3 bg-gradient-to-r from-blue-600 to-teal-600 text-white rounded-lg hover:shadow-lg transition font-semibold">Mulai Sekarang</a>
                        <a href="#about" class="px-8 py-3 border-2 border-blue-600 text-blue-600 rounded-lg hover:bg-blue-50 transition font-semibold">Pelajari Lebih</a>
                    </div>
                </div>
                <div class="bg-gradient-to-br from-blue-400 to-teal-400 rounded-2xl h-96 flex items-center justify-center">
                    <span class="text-8xl">📖</span>
                </div>
            </div>
        </div>
    </section>

    <!-- Visitor Statistics Section -->
    <section id="visitors" class="py-20 px-4 bg-white">
        <div class="max-w-7xl mx-auto">
            <div class="text-center mb-16">
                <h2 class="text-4xl font-bold text-gray-900 mb-4">Statistik Pengunjung</h2>
                <p class="text-xl text-gray-600">Bergabunglah dengan ribuan pengguna yang telah mempercayai sistem kami</p>
            </div>
            <div class="grid md:grid-cols-4 gap-8">
                <div class="bg-gradient-to-br from-blue-50 to-blue-100 p-8 rounded-xl text-center hover:shadow-lg transition">
                    <div class="text-5xl font-bold bg-gradient-to-r from-blue-600 to-teal-600 bg-clip-text text-transparent mb-2">
                        15.2K
                    </div>
                    <p class="text-gray-700 font-semibold">Pengunjung Hari Ini</p>
                </div>
                <div class="bg-gradient-to-br from-teal-50 to-teal-100 p-8 rounded-xl text-center hover:shadow-lg transition">
                    <div class="text-5xl font-bold bg-gradient-to-r from-blue-600 to-teal-600 bg-clip-text text-transparent mb-2">
                        248.5K
                    </div>
                    <p class="text-gray-700 font-semibold">Total Pengunjung Bulan Ini</p>
                </div>
                <div class="bg-gradient-to-br from-cyan-50 to-cyan-100 p-8 rounded-xl text-center hover:shadow-lg transition">
                    <div class="text-5xl font-bold bg-gradient-to-r from-blue-600 to-teal-600 bg-clip-text text-transparent mb-2">
                        1.8M
                    </div>
                    <p class="text-gray-700 font-semibold">Total Pengunjung Tahun Ini</p>
                </div>
                <div class="bg-gradient-to-br from-blue-100 to-teal-50 p-8 rounded-xl text-center hover:shadow-lg transition">
                    <div class="text-5xl font-bold bg-gradient-to-r from-blue-600 to-teal-600 bg-clip-text text-transparent mb-2">
                        42.3K
                    </div>
                    <p class="text-gray-700 font-semibold">Pengguna Aktif</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Collections Section -->
    <section class="py-20 px-4 bg-gray-50">
        <div class="max-w-7xl mx-auto">
            <div class="text-center mb-16">
                <h2 class="text-4xl font-bold text-gray-900 mb-4">Kategori Koleksi</h2>
                <p class="text-xl text-gray-600">Jelajahi berbagai kategori buku yang tersedia</p>
            </div>
            <div class="grid md:grid-cols-3 gap-8">
                <div class="bg-gradient-to-br from-blue-500 to-blue-600 p-8 rounded-xl text-white hover:shadow-xl transition cursor-pointer">
                    <div class="text-5xl mb-4">📚</div>
                    <h3 class="text-2xl font-bold mb-2">Fiksi</h3>
                    <p class="text-blue-100">2,450 judul buku fiksi dari penulis terbaik</p>
                </div>
                <div class="bg-gradient-to-br from-teal-500 to-teal-600 p-8 rounded-xl text-white hover:shadow-xl transition cursor-pointer">
                    <div class="text-5xl mb-4">🔬</div>
                    <h3 class="text-2xl font-bold mb-2">Sains & Teknologi</h3>
                    <p class="text-teal-100">1,890 judul buku sains dan teknologi</p>
                </div>
                <div class="bg-gradient-to-br from-cyan-500 to-cyan-600 p-8 rounded-xl text-white hover:shadow-xl transition cursor-pointer">
                    <div class="text-5xl mb-4">🎓</div>
                    <h3 class="text-2xl font-bold mb-2">Pendidikan</h3>
                    <p class="text-cyan-100">3,120 judul buku pendidikan dan referensi</p>
                </div>
            </div>
        </div>
    </section>

    <!-- About Section -->
    <section id="about" class="py-20 px-4 bg-white">
        <div class="max-w-7xl mx-auto">
            <div class="grid md:grid-cols-2 gap-12 items-center">
                <div class="bg-gradient-to-br from-blue-400 to-teal-400 rounded-2xl h-96 flex items-center justify-center">
                    <span class="text-8xl">🏛️</span>
                </div>
                <div>
                    <h2 class="text-4xl font-bold text-gray-900 mb-6">Tentang Kami</h2>
                    <p class="text-lg text-gray-600 mb-4">Sistem Informasi Perpustakaan kami dirancang untuk memberikan pengalaman terbaik dalam mencari dan meminjam buku.</p>
                    <p class="text-lg text-gray-600 mb-6">Dengan teknologi terkini, kami menyediakan platform yang mudah digunakan, aman, dan dapat diandalkan untuk semua kebutuhan perpustakaan Anda.</p>
                    <ul class="space-y-3">
                        <li class="flex items-center gap-3">
                            <span class="w-6 h-6 bg-gradient-to-r from-blue-600 to-teal-600 rounded-full flex items-center justify-center text-white text-sm">✓</span>
                            <span class="text-gray-700">Katalog lengkap dengan ribuan judul buku</span>
                        </li>
                        <li class="flex items-center gap-3">
                            <span class="w-6 h-6 bg-gradient-to-r from-blue-600 to-teal-600 rounded-full flex items-center justify-center text-white text-sm">✓</span>
                            <span class="text-gray-700">Sistem reservasi dan peminjaman yang mudah</span>
                        </li>
                        <li class="flex items-center gap-3">
                            <span class="w-6 h-6 bg-gradient-to-r from-blue-600 to-teal-600 rounded-full flex items-center justify-center text-white text-sm">✓</span>
                            <span class="text-gray-700">Notifikasi real-time untuk status peminjaman</span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="py-20 px-4 bg-gradient-to-r from-blue-600 to-teal-600">
        <div class="max-w-4xl mx-auto text-center">
            <h2 class="text-4xl font-bold text-white mb-6">Siap Memulai?</h2>
            <p class="text-xl text-blue-100 mb-8">Daftar sekarang dan nikmati akses unlimited ke koleksi buku kami</p>
            <a href="{{ route('register') }}" wire:navigate class="inline-block px-8 py-4 bg-white text-blue-600 rounded-lg hover:shadow-xl transition font-bold text-lg">Daftar Gratis Sekarang</a>
        </div>
    </section>

    <!-- Footer -->
    <footer id="contact" class="bg-gray-900 text-gray-300 py-12 px-4">
        <div class="max-w-7xl mx-auto">
            <div class="grid md:grid-cols-4 gap-8 mb-8">
                <div>
                    <h3 class="text-white font-bold mb-4">LibraryHub</h3>
                    <p class="text-sm">Sistem informasi perpustakaan modern untuk semua kalangan</p>
                </div>
                <div>
                    <h4 class="text-white font-bold mb-4">Navigasi</h4>
                    <ul class="space-y-2 text-sm">
                        <li><a href="#home" class="hover:text-white transition">Beranda</a></li>
                        <li><a href="#visitors" class="hover:text-white transition">Pengunjung</a></li>
                        <li><a href="#about" class="hover:text-white transition">Tentang</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="text-white font-bold mb-4">Layanan</h4>
                    <ul class="space-y-2 text-sm">
                        <li><a href="#" class="hover:text-white transition">Pencarian Buku</a></li>
                        <li><a href="#" class="hover:text-white transition">Peminjaman</a></li>
                        <li><a href="#" class="hover:text-white transition">Reservasi</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="text-white font-bold mb-4">Kontak</h4>
                    <ul class="space-y-2 text-sm">
                        <li>Email: info@libraryhub.com</li>
                        <li>Telepon: (021) 1234-5678</li>
                        <li>Alamat: Jakarta, Indonesia</li>
                    </ul>
                </div>
            </div>
            <div class="border-t border-gray-700 pt-8 text-center text-sm">
                <p>&copy; 2025 LibraryHub. Semua hak dilindungi.</p>
            </div>
        </div>
    </footer>
</body>
</html>
