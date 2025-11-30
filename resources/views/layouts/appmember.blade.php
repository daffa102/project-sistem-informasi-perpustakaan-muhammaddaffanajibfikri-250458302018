<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Perpustakaan IDN')</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap"
        rel="stylesheet">

    @livewireStyles

    <style>
        * {
            font-family: 'Inter', sans-serif;
        }

        /* Smooth Scrollbar */
        ::-webkit-scrollbar {
            width: 10px;
        }

        ::-webkit-scrollbar-track {
            background: #f1f1f1;
        }

        ::-webkit-scrollbar-thumb {
            background: linear-gradient(180deg, #667eea 0%, #764ba2 100%);
            border-radius: 10px;
        }

        /* Animated Background */
        .gradient-bg {
            background: linear-gradient(-45deg, #ee7752, #e73c7e, #23a6d5, #23d5ab);
            background-size: 400% 400%;
            animation: gradientShift 15s ease infinite;
        }

        @keyframes gradientShift {
            0% {
                background-position: 0% 50%;
            }

            50% {
                background-position: 100% 50%;
            }

            100% {
                background-position: 0% 50%;
            }
        }

        /* Navbar Scroll Effect */
        .navbar-scrolled {
            background: rgba(255, 255, 255, 0.95) !important;
            backdrop-filter: blur(20px);
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            padding-top: 0.75rem !important;
            padding-bottom: 0.75rem !important;
        }

        .navbar-scrolled .nav-link {
            color: #4a5568 !important;
        }

        .navbar-scrolled .nav-link:hover {
            color: #667eea !important;
        }

        .navbar-scrolled .logo-text {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .navbar-scrolled .logo-icon {
            color: #667eea !important;
        }

        /* Glass Card Effect */
        .glass-card {
            background: rgba(255, 255, 255, 0.85);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.3);
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.08);
        }

        /* Floating Animation */
        @keyframes float {

            0%,
            100% {
                transform: translateY(0px);
            }

            50% {
                transform: translateY(-20px);
            }
        }

        .float-animation {
            animation: float 6s ease-in-out infinite;
        }

        /* Hover Effects */
        .card-hover {
            transition: all 0.4s cubic-bezier(0.165, 0.84, 0.44, 1);
        }

        .card-hover:hover {
            transform: translateY(-10px) scale(1.02);
            box-shadow: 0 20px 50px rgba(0, 0, 0, 0.15);
        }

        /* Button Gradient */
        .btn-gradient {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            transition: all 0.3s ease;
        }

        .btn-gradient:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(102, 126, 234, 0.4);
        }

        /* Decorative Shapes */
        .shape {
            position: absolute;
            opacity: 0.1;
        }

        .shape-1 {
            top: 10%;
            left: 5%;
            width: 300px;
            height: 300px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border-radius: 50%;
            filter: blur(60px);
            animation: float 8s ease-in-out infinite;
        }

        .shape-2 {
            bottom: 10%;
            right: 5%;
            width: 400px;
            height: 400px;
            background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
            border-radius: 50%;
            filter: blur(80px);
            animation: float 10s ease-in-out infinite;
            animation-delay: 2s;
        }

        .shape-3 {
            top: 50%;
            left: 50%;
            width: 350px;
            height: 350px;
            background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
            border-radius: 50%;
            filter: blur(70px);
            animation: float 9s ease-in-out infinite;
            animation-delay: 4s;
        }
    </style>
</head>

<body
    class="bg-linear-to-br from-slate-50 via-blue-50 to-purple-50 text-gray-800 min-h-screen flex flex-col relative overflow-x-hidden">

    <!-- Decorative Shapes -->
    <div class="shape shape-1"></div>
    <div class="shape shape-2"></div>
    <div class="shape shape-3"></div>

    <!-- NAVBAR -->
    <nav id="navbar" class="fixed w-full top-0 z-50 transition-all duration-500 ease-in-out">
        <div class="gradient-bg">
            <div class="container mx-auto px-6 py-4">
                <div class="flex justify-between items-center">
                    <!-- Logo -->
                    <div class="flex items-center space-x-3 group cursor-pointer">
                        <div class="relative">
                            <div class="absolute inset-0 bg-white/30 rounded-2xl blur-sm"></div>
                            <div
                                class="relative bg-white/20 backdrop-blur-sm p-2.5 rounded-2xl border border-white/30 group-hover:scale-110 transition-transform duration-300">
                                <svg class="w-7 h-7 text-white logo-icon" fill="currentColor" viewBox="0 0 20 20">
                                    <path
                                        d="M9 4.804A7.968 7.968 0 005.5 4c-1.255 0-2.443.29-3.5.804v10A7.969 7.969 0 015.5 14c1.669 0 3.218.51 4.5 1.385A7.962 7.962 0 0114.5 14c1.255 0 2.443.29 3.5.804v-10A7.968 7.968 0 0014.5 4c-1.255 0-2.443.29-3.5.804V12a1 1 0 11-2 0V4.804z" />
                                </svg>
                            </div>
                        </div>
                        <div>
                            <h1 class="text-2xl font-bold text-white logo-text tracking-tight">SIP IDN</h1>
                            <p class="text-xs text-white/90 font-medium">Library System</p>
                        </div>
                    </div>

                    <!-- Navigation Menu -->
                    <div class="flex items-center space-x-2">
                        <a href="{{ route('member.dashboard') }}" wire:navigate
                            class="nav-link px-5 py-2.5 rounded-xl text-white hover:bg-white/20 transition-all duration-300 font-medium flex items-center space-x-2 backdrop-blur-sm">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                <path
                                    d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z" />
                            </svg>
                            <span>Home</span>
                        </a>

                        <a href="{{ route('member.borrow.scanner') }}" wire:navigate
                            class="nav-link px-5 py-2.5 rounded-xl text-white hover:bg-white/20 transition-all duration-300 font-medium flex items-center space-x-2 backdrop-blur-sm">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                <path
                                    d="M9 4.804A7.968 7.968 0 005.5 4c-1.255 0-2.443.29-3.5.804v10A7.969 7.969 0 015.5 14c1.669 0 3.218.51 4.5 1.385A7.962 7.962 0 0114.5 14c1.255 0 2.443.29 3.5.804v-10A7.968 7.968 0 0014.5 4c-1.255 0-2.443.29-3.5.804V12a1 1 0 11-2 0V4.804z" />
                            </svg>
                            <span>Peminjaman</span>
                        </a>

                        <a href="{{ route('member.fines.payment') }}" wire:navigate
                            class="nav-link px-5 py-2.5 rounded-xl text-white hover:bg-white/20 transition-all duration-300 font-medium flex items-center space-x-2 backdrop-blur-sm">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                    d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
                            </svg>
                            <span>Pembayaran</span>
                        </a>

                        <a href="{{ route('member.profile') }}" wire:navigate
                            class="nav-link px-5 py-2.5 rounded-xl text-white hover:bg-white/20 transition-all duration-300 font-medium flex items-center space-x-2 backdrop-blur-sm">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="1.8"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 7.5a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.5
                                        20.25a8.25 8.25 0 1115 0v.75H4.5v-.75z" />
                            </svg>
                            <span>Profile</span>
                        </a>
                        <a href="{{ route('member.wishlist') }}" wire:navigate
                            class="nav-link px-5 py-2.5 rounded-xl text-white hover:bg-white/20 transition-all duration-300 font-medium flex items-center space-x-2 backdrop-blur-sm">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="1.8"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 7.5a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.5
                                        20.25a8.25 8.25 0 1115 0v.75H4.5v-.75z" />
                            </svg>
                            <span>Wishlist</span>
                        </a>


                        <div class="w-px h-8 bg-white/30 mx-2"></div>

                        <form method="POST" action="{{ route('logout') }}" class="inline">
                            @csrf
                            <button type="submit"
                                class="btn-gradient px-6 py-2.5 text-white rounded-xl font-semibold shadow-lg flex items-center space-x-2 border border-white/20">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M3 3a1 1 0 00-1 1v12a1 1 0 102 0V4a1 1 0 00-1-1zm10.293 9.293a1 1 0 001.414 1.414l3-3a1 1 0 000-1.414l-3-3a1 1 0 10-1.414 1.414L14.586 9H7a1 1 0 100 2h7.586l-1.293 1.293z"
                                        clip-rule="evenodd" />
                                </svg>
                                <span>Logout</span>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </nav>

    <!-- MAIN CONTENT (with top padding for fixed navbar) -->
    <main class="container mx-auto px-6 py-10 grow" style="margin-top: 100px;">
        <div class="glass-card rounded-3xl p-8 md:p-12 min-h-[650px] card-hover">
            <!-- Content Header with Decoration -->
            <div class="relative mb-8">
                <div
                    class="absolute -top-4 -left-4 w-20 h-20 bg-linear-to-br from-purple-400 to-pink-400 rounded-full opacity-20 blur-2xl">
                </div>
                <div class="relative">
                    <div wire:key="{{ Route::currentRouteName() }}">
                        {{ $slot }}
                    </div>
                </div>
            </div>
        </div>
    </main>

    <!-- FOOTER -->
    <footer class="relative mt-20 overflow-hidden">
        <!-- Wave Decoration -->
        <div class="absolute top-0 left-0 w-full overflow-hidden leading-none -mt-1">
            <svg class="relative block w-full h-24" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1200 120"
                preserveAspectRatio="none">
                <path
                    d="M321.39,56.44c58-10.79,114.16-30.13,172-41.86,82.39-16.72,168.19-17.73,250.45-.39C823.78,31,906.67,72,985.66,92.83c70.05,18.48,146.53,26.09,214.34,3V0H0V27.35A600.21,600.21,0,0,0,321.39,56.44Z"
                    fill="url(#gradient1)"></path>
                <defs>
                    <linearGradient id="gradient1" x1="0%" y1="0%" x2="100%" y2="0%">
                        <stop offset="0%" style="stop-color:#667eea;stop-opacity:1" />
                        <stop offset="50%" style="stop-color:#764ba2;stop-opacity:1" />
                        <stop offset="100%" style="stop-color:#f093fb;stop-opacity:1" />
                    </linearGradient>
                </defs>
            </svg>
        </div>

        <!-- Footer Content -->
        <div class="relative" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 50%, #f093fb 100%);">
            <div class="container mx-auto px-6 pt-16 pb-8 text-white">
                <div class="grid grid-cols-1 md:grid-cols-4 gap-10 mb-12">
                    <!-- About -->
                    <div class="md:col-span-2">
                        <div class="flex items-center space-x-3 mb-4">
                            <div class="bg-white/20 backdrop-blur-sm p-2 rounded-xl">
                                <svg class="w-7 h-7 text-white" fill="currentColor" viewBox="0 0 20 20">
                                    <path
                                        d="M9 4.804A7.968 7.968 0 005.5 4c-1.255 0-2.443.29-3.5.804v10A7.969 7.969 0 015.5 14c1.669 0 3.218.51 4.5 1.385A7.962 7.962 0 0114.5 14c1.255 0 2.443.29 3.5.804v-10A7.968 7.968 0 0014.5 4c-1.255 0-2.443.29-3.5.804V12a1 1 0 11-2 0V4.804z" />
                                </svg>
                            </div>
                            <h3 class="text-2xl font-bold">Perpustakaan IDN</h3>
                        </div>
                        <p class="text-white/90 text-sm leading-relaxed mb-4 max-w-md">
                            Sistem Informasi Perpustakaan modern yang memudahkan pengelolaan koleksi buku, peminjaman,
                            dan administrasi perpustakaan dengan teknologi terkini.
                        </p>
                        <div class="flex space-x-3">
                            <a href="#"
                                class="w-10 h-10 bg-white/20 backdrop-blur-sm rounded-xl flex items-center justify-center hover:bg-white/30 transition-all duration-300 hover:scale-110">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                    <path
                                        d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z" />
                                </svg>
                            </a>
                            <a href="#"
                                class="w-10 h-10 bg-white/20 backdrop-blur-sm rounded-xl flex items-center justify-center hover:bg-white/30 transition-all duration-300 hover:scale-110">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                    <path
                                        d="M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723c-.951.555-2.005.959-3.127 1.184a4.92 4.92 0 00-8.384 4.482C7.69 8.095 4.067 6.13 1.64 3.162a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.06a4.923 4.923 0 003.946 4.827 4.996 4.996 0 01-2.212.085 4.936 4.936 0 004.604 3.417 9.867 9.867 0 01-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 007.557 2.209c9.053 0 13.998-7.496 13.998-13.985 0-.21 0-.42-.015-.63A9.935 9.935 0 0024 4.59z" />
                                </svg>
                            </a>
                            <a href="#"
                                class="w-10 h-10 bg-white/20 backdrop-blur-sm rounded-xl flex items-center justify-center hover:bg-white/30 transition-all duration-300 hover:scale-110">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                    <path
                                        d="M12 0C8.74 0 8.333.015 7.053.072 5.775.132 4.905.333 4.14.63c-.789.306-1.459.717-2.126 1.384S.935 3.35.63 4.14C.333 4.905.131 5.775.072 7.053.012 8.333 0 8.74 0 12s.015 3.667.072 4.947c.06 1.277.261 2.148.558 2.913.306.788.717 1.459 1.384 2.126.667.666 1.336 1.079 2.126 1.384.766.296 1.636.499 2.913.558C8.333 23.988 8.74 24 12 24s3.667-.015 4.947-.072c1.277-.06 2.148-.262 2.913-.558.788-.306 1.459-.718 2.126-1.384.666-.667 1.079-1.335 1.384-2.126.296-.765.499-1.636.558-2.913.06-1.28.072-1.687.072-4.947s-.015-3.667-.072-4.947c-.06-1.277-.262-2.149-.558-2.913-.306-.789-.718-1.459-1.384-2.126C21.319 1.347 20.651.935 19.86.63c-.765-.297-1.636-.499-2.913-.558C15.667.012 15.26 0 12 0zm0 2.16c3.203 0 3.585.016 4.85.071 1.17.055 1.805.249 2.227.415.562.217.96.477 1.382.896.419.42.679.819.896 1.381.164.422.36 1.057.413 2.227.057 1.266.07 1.646.07 4.85s-.015 3.585-.074 4.85c-.061 1.17-.256 1.805-.421 2.227-.224.562-.479.96-.899 1.382-.419.419-.824.679-1.38.896-.42.164-1.065.36-2.235.413-1.274.057-1.649.07-4.859.07-3.211 0-3.586-.015-4.859-.074-1.171-.061-1.816-.256-2.236-.421-.569-.224-.96-.479-1.379-.899-.421-.419-.69-.824-.9-1.38-.165-.42-.359-1.065-.42-2.235-.045-1.26-.061-1.649-.061-4.844 0-3.196.016-3.586.061-4.861.061-1.17.255-1.814.42-2.234.21-.57.479-.96.9-1.381.419-.419.81-.689 1.379-.898.42-.166 1.051-.361 2.221-.421 1.275-.045 1.65-.06 4.859-.06l.045.03zm0 3.678c-3.405 0-6.162 2.76-6.162 6.162 0 3.405 2.76 6.162 6.162 6.162 3.405 0 6.162-2.76 6.162-6.162 0-3.405-2.76-6.162-6.162-6.162zM12 16c-2.21 0-4-1.79-4-4s1.79-4 4-4 4 1.79 4 4-1.79 4-4 4zm7.846-10.405c0 .795-.646 1.44-1.44 1.44-.795 0-1.44-.646-1.44-1.44 0-.794.646-1.439 1.44-1.439.793-.001 1.44.645 1.44 1.439z" />
                                </svg>
                            </a>
                        </div>
                    </div>

                    <!-- Quick Links -->
                    <div>
                        <h4 class="text-lg font-bold mb-4 flex items-center space-x-2">
                            <div class="w-1 h-6 bg-white rounded-full"></div>
                            <span>Quick Links</span>
                        </h4>
                        <ul class="space-y-3">
                            <li><a href="/"
                                    class="text-white/80 hover:text-white hover:translate-x-1 transition-all duration-200 flex items-center space-x-2 group">
                                    <span class="text-xl group-hover:scale-110 transition-transform">→</span>
                                    <span>Beranda</span>
                                </a></li>
                            <li><a href="/book"
                                    class="text-white/80 hover:text-white hover:translate-x-1 transition-all duration-200 flex items-center space-x-2 group">
                                    <span class="text-xl group-hover:scale-110 transition-transform">→</span>
                                    <span>Koleksi Buku</span>
                                </a></li>
                            <li><a href="#"
                                    class="text-white/80 hover:text-white hover:translate-x-1 transition-all duration-200 flex items-center space-x-2 group">
                                    <span class="text-xl group-hover:scale-110 transition-transform">→</span>
                                    <span>Tentang Kami</span>
                                </a></li>
                            <li><a href="#"
                                    class="text-white/80 hover:text-white hover:translate-x-1 transition-all duration-200 flex items-center space-x-2 group">
                                    <span class="text-xl group-hover:scale-110 transition-transform">→</span>
                                    <span>Kontak</span>
                                </a></li>
                        </ul>
                    </div>

                    <!-- Contact -->
                    <div>
                        <h4 class="text-lg font-bold mb-4 flex items-center space-x-2">
                            <div class="w-1 h-6 bg-white rounded-full"></div>
                            <span>Hubungi Kami</span>
                        </h4>
                        <div class="space-y-4">
                            <div
                                class="flex items-start space-x-3 text-white/90 hover:text-white transition-colors duration-200 group">
                                <div
                                    class="mt-1 bg-white/20 p-2 rounded-lg group-hover:scale-110 transition-transform">
                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                        <path
                                            d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z" />
                                        <path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z" />
                                    </svg>
                                </div>
                                <div class="text-sm">
                                    <p class="font-medium">Email</p>
                                    <p class="text-white/80">info@perpustakaanidn.ac.id</p>
                                </div>
                            </div>
                            <div
                                class="flex items-start space-x-3 text-white/90 hover:text-white transition-colors duration-200 group">
                                <div
                                    class="mt-1 bg-white/20 p-2 rounded-lg group-hover:scale-110 transition-transform">
                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                        <path
                                            d="M2 3a1 1 0 011-1h2.153a1 1 0 01.986.836l.74 4.435a1 1 0 01-.54 1.06l-1.548.773a11.037 11.037 0 006.105 6.105l.774-1.548a1 1 0 011.059-.54l4.435.74a1 1 0 01.836.986V17a1 1 0 01-1 1h-2C7.82 18 2 12.18 2 5V3z" />
                                    </svg>
                                </div>
                                <div class="text-sm">
                                    <p class="font-medium">Telepon</p>
                                    <p class="text-white/80">(021) 1234-5678</p>
                                </div>
                            </div>
                            <div
                                class="flex items-start space-x-3 text-white/90 hover:text-white transition-colors duration-200 group">
                                <div
                                    class="mt-1 bg-white/20 p-2 rounded-lg group-hover:scale-110 transition-transform">
                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z"
                                            clip-rule="evenodd" />
                                    </svg>
                                </div>
                                <div class="text-sm">
                                    <p class="font-medium">Alamat</p>
                                    <p class="text-white/80">Bekasi, West Java, ID</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Bottom Bar -->
                <div class="border-t border-white/20 pt-8 flex flex-col md:flex-row justify-between items-center">
                    <p class="text-sm text-white/90 mb-4 md:mb-0">
                        &copy; {{ date('Y') }} <span class="font-bold">Perpustakaan IDN</span>. All rights
                        reserved.
                    </p>
                    <div class="flex items-center space-x-6 text-sm text-white/80">
                        <a href="#" class="hover:text-white transition-colors duration-200">Privacy Policy</a>
                        <span>•</span>
                        <a href="#" class="hover:text-white transition-colors duration-200">Terms of Service</a>
                        <span>•</span>
                        <p>Made with <span class="text-red-400">❤</span> by SIP Team</p>
                    </div>
                </div>
            </div>
        </div>
    </footer>

    <!-- Scripts -->
    @livewireScripts
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.12.0/dist/js/cdn.min.js" defer></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Navbar Scroll Script -->
    <script>
        function initNavbarScroll() {
            const navbar = document.getElementById('navbar');
            if (!navbar) return;
            
            // Hapus listener lama jika ada (optional, tapi good practice)
            window.removeEventListener('scroll', handleScroll);
            
            function handleScroll() {
                if (window.scrollY > 50) {
                    navbar.classList.add('navbar-scrolled');
                } else {
                    navbar.classList.remove('navbar-scrolled');
                }
            }
            
            window.addEventListener('scroll', handleScroll);
            // Trigger sekali saat init untuk set state awal
            handleScroll();
        }

        document.addEventListener('DOMContentLoaded', initNavbarScroll);
        document.addEventListener('livewire:navigated', initNavbarScroll);
    </script>


</body>

</html>
