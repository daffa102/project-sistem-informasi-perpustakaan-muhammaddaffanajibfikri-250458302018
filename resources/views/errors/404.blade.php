<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>404 - Halaman Tidak Ditemukan | Perpustakaan IDN</title>

    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <style>
        * {
            font-family: 'Inter', sans-serif;
        }

        /* Animated Background */
        .gradient-bg {
            background: linear-gradient(-45deg, #ee7752, #e73c7e, #23a6d5, #23d5ab);
            background-size: 400% 400%;
            animation: gradientShift 15s ease infinite;
        }

        @keyframes gradientShift {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
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
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-20px); }
        }

        .float-animation {
            animation: float 6s ease-in-out infinite;
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
            z-index: -1;
        }

        .shape-1 {
            top: 10%; left: 5%; width: 300px; height: 300px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border-radius: 50%; filter: blur(60px);
            animation: float 8s ease-in-out infinite;
        }

        .shape-2 {
            bottom: 10%; right: 5%; width: 400px; height: 400px;
            background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
            border-radius: 50%; filter: blur(80px);
            animation: float 10s ease-in-out infinite; animation-delay: 2s;
        }
    </style>
</head>

<body class="bg-slate-50 text-gray-800 min-h-screen flex items-center justify-center relative overflow-hidden">

    <!-- Decorative Shapes -->
    <div class="shape shape-1"></div>
    <div class="shape shape-2"></div>

    <div class="container mx-auto px-6">
        <div class="glass-card rounded-3xl p-8 md:p-16 max-w-2xl mx-auto text-center relative overflow-hidden">
            
            <!-- Top Decoration -->
            <div class="absolute -top-10 -right-10 w-32 h-32 bg-gradient-to-br from-blue-400 to-purple-400 rounded-full opacity-20 blur-2xl"></div>
            <div class="absolute -bottom-10 -left-10 w-32 h-32 bg-gradient-to-br from-pink-400 to-orange-400 rounded-full opacity-20 blur-2xl"></div>

            <!-- 404 Content -->
            <div class="relative z-10">
                <div class="mb-6">
                    <h1 class="text-9xl font-bold text-transparent bg-clip-text bg-gradient-to-r from-blue-600 to-purple-600 float-animation">404</h1>
                </div>
                
                <h2 class="text-3xl font-bold text-gray-800 mb-4">Halaman Tidak Ditemukan</h2>
                <p class="text-gray-600 mb-8 text-lg">Maaf, sepertinya Anda tersesat di antara rak-rak buku digital kami.</p>

                <div class="flex flex-col sm:flex-row gap-4 justify-center">
                    <a href="{{ url('/') }}" class="btn-gradient px-8 py-3 text-white rounded-xl font-semibold shadow-lg flex items-center justify-center space-x-2 group">
                        <svg class="w-5 h-5 group-hover:-translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                        </svg>
                        <span>Kembali ke Beranda</span>
                    </a>
                </div>
            </div>
        </div>
        
        <div class="text-center mt-8 text-gray-500 text-sm">
            &copy; {{ date('Y') }} Perpustakaan IDN. All rights reserved.
        </div>
    </div>

</body>
</html>
