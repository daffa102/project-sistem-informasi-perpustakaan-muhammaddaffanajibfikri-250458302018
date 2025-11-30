<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Masuk - LibraryHub</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&family=Playfair+Display:wght@600;700;800&display=swap');

        * {
            font-family: 'Poppins', sans-serif;
        }

        h1,
        h2,
        h3,
        h4,
        h5,
        h6 {
            font-family: 'Playfair Display', serif;
        }

        .gradient-primary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }

        .gradient-text {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .btn-primary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            transition: all 0.3s ease;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(102, 126, 234, 0.3);
        }

        .input-focus:focus {
            border-color: #667eea;
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
        }
    </style>
</head>

<body class="bg-linear-to-br from-purple-50 via-white to-purple-50">
    <!-- Navigation -->
    <nav class="fixed w-full top-0 z-50 bg-white/80 backdrop-blur-md border-b border-gray-100">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <a href="{{ route('welcome') }}" class="flex items-center gap-2">
                    <div class="w-8 h-8 gradient-primary rounded-lg flex items-center justify-center">
                        <span class="text-white font-bold text-lg">📚</span>
                    </div>
                    <span class="font-bold text-xl text-gray-900">LibraryHub</span>
                </a>
            </div>
        </div>
    </nav>

    <!-- Login Container -->
    <div class="min-h-screen flex items-center justify-center px-4 pt-20">
        <div class="w-full max-w-md">
            <!-- Card -->
            <div class="bg-white rounded-3xl shadow-2xl p-8 md:p-12">
                <!-- Header -->
                <div class="text-center mb-8">
                    <h1 class="text-4xl font-bold text-gray-900 mb-2">Selamat Datang</h1>
                    <p class="text-gray-600">Masuk ke akun LibraryHub Anda</p>
                </div>

                <!-- Form -->
                {{ $slot }}


                <!-- Footer -->
                <p class="text-center text-gray-600 mt-8">
                    Belum punya akun? <a href="{{ route('register') }}" wire:navigate
                        class="text-purple-600 font-bold hover:text-purple-700">Daftar sekarang</a>
                </p>
            </div>

            <!-- Info Box -->
            <div class="mt-8 bg-white/50 backdrop-blur rounded-2xl p-6 border border-white/50">
                <p class="text-center text-gray-600 text-sm">
                    💡 Tip: Gunakan email dan kata sandi yang aman untuk melindungi akun Anda
                </p>
            </div>
        </div>
    </div>



    <script>
        const passwordInput = document.getElementById("password");
        const togglePassword = document.getElementById("togglePassword");

        togglePassword.addEventListener("click", () => {
            const isPassword = passwordInput.type === "password";
            passwordInput.type = isPassword ? "text" : "password";
            const svg = togglePassword.querySelector("svg");
            if (isPassword) {
                svg.innerHTML = `<path d="M17.94 17.94A10.94 10.94 0 0 1 12 19
                    c-7 0-11-7-11-7
                    .81-1.38 2.01-2.75 3.45-3.93M3 3l18 18"/>`;
            } else {
                svg.innerHTML = `
        <path d="M1 12s4-7 11-7 11 7 11 7
                 -4 7-11 7S1 12 1 12z"/>
        <circle cx="12" cy="12" r="3"/>`;
            }
        });
    </script>

</body>

</html>
