<!DOCTYPE html>
<html>
<head>
    <title>Selamat Datang</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 600px;
            margin: 20px auto;
            background: #ffffff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        .header {
            text-align: center;
            padding-bottom: 20px;
            border-bottom: 1px solid #eeeeee;
        }
        .header h1 {
            color: #333333;
        }
        .content {
            padding: 20px 0;
            color: #555555;
            line-height: 1.6;
        }
        .footer {
            text-align: center;
            padding-top: 20px;
            border-top: 1px solid #eeeeee;
            font-size: 12px;
            color: #999999;
        }
        .button {
            display: inline-block;
            padding: 10px 20px;
            background-color: #007bff;
            color: #ffffff;
            text-decoration: none;
            border-radius: 5px;
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Selamat Datang di Perpustakaan!</h1>
        </div>
        <div class="content">
            <p>Halo, <strong>{{ $user->name }}</strong>!</p>
            <p>Terima kasih telah mendaftar di sistem perpustakaan kami. Akun Anda telah berhasil dibuat.</p>
            <p>Sekarang Anda dapat meminjam buku, melihat koleksi, dan menikmati layanan kami lainnya.</p>
            <p style="text-align: center;">
                <a href="{{ route('login') }}" class="button">Login Sekarang</a>
            </p>
        </div>
        <div class="footer">
            <p>&copy; {{ date('Y') }} Perpustakaan Kami. All rights reserved.</p>
        </div>
    </div>
</body>
</html>
