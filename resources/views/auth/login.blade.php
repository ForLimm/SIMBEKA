<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - SIMBEKA</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>body { font-family: 'Inter', sans-serif; }</style>
</head>
<body class="bg-gray-100 min-h-screen flex items-center justify-center p-4">
    <div class="w-full max-w-md">
        <div class="text-center mb-6">
            <h1 class="text-2xl font-bold text-blue-700">SIMBEKA</h1>
            <p class="text-sm text-gray-500">Sistem Informasi Bimbingan & Konseling</p>
        </div>

        <div class="bg-white border border-gray-200 rounded-lg shadow-sm p-6">
            <h2 class="text-lg font-semibold text-gray-800 mb-4 border-b pb-2">Login Pengguna</h2>

            @if($errors->any())
                <div class="bg-red-50 border border-red-200 text-red-700 text-sm p-3 rounded mb-4">
                    {{ $errors->first() }}
                </div>
            @endif

            <form action="{{ route('login.post') }}" method="POST">
                @csrf
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Username / Email</label>
                    <input type="text" name="login" class="w-full border border-gray-300 rounded px-3 py-2 text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none" placeholder="Masukkan username atau email" required>
                </div>
                <div class="mb-5">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Password</label>
                    <input type="password" name="password" class="w-full border border-gray-300 rounded px-3 py-2 text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none" placeholder="Masukkan password" required>
                </div>
                <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2.5 rounded text-sm transition">Masuk</button>
            </form>
        </div>

        <div class="mt-4 grid grid-cols-2 gap-3">
            <a href="{{ route('register') }}" class="bg-white border border-gray-200 rounded-lg shadow-sm p-4 text-center hover:bg-gray-50 transition block">
                <span class="block text-sm font-semibold text-gray-700">Daftar Akun Siswa</span>
                <span class="block text-xs text-gray-400 mt-1">Buat username & password</span>
            </a>
            <form action="{{ route('guest.login') }}" method="POST">
                @csrf
                <button type="submit" class="w-full bg-white border border-gray-200 rounded-lg shadow-sm p-4 text-center hover:bg-gray-50 transition cursor-pointer">
                    <span class="block text-sm font-semibold text-gray-700">Lapor Anonim</span>
                    <span class="block text-xs text-gray-400 mt-1">Tanpa akun, langsung lapor</span>
                </button>
            </form>
        </div>
    </div>
</body>
</html>
