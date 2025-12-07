<!DOCTYPE html>
<html lang="id">
<head>
    <title>Login VEXFESS</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite('resources/css/app.css')
</head>
<body class="bg-slate-100 flex items-center justify-center min-h-screen p-4">
    <div class="bg-white p-6 sm:p-8 rounded-2xl shadow-xl w-full max-w-sm">
        <h1 class="text-2xl font-bold text-center text-indigo-600 mb-2">VEXFESS Login</h1>
        <p class="text-center text-slate-400 text-xs sm:text-sm mb-6">Masuk menggunakan email angkatan.</p>
        
        <form action="{{ route('login') }}" method="POST">
            @csrf
            <div class="mb-4">
                <label class="block text-xs font-bold text-gray-500 mb-1">Email (@menfess.com)</label>
                <input type="email" name="email" class="w-full border border-gray-300 p-2.5 rounded-lg text-sm outline-none focus:ring-2 focus:ring-indigo-500 transition" placeholder="nama@menfess.com" required value="{{ old('email') }}">
                @error('email') <span class="text-red-500 text-[10px] mt-1 block">{{ $message }}</span> @enderror
            </div>
            <div class="mb-6">
                <label class="block text-xs font-bold text-gray-500 mb-1">Password</label>
                <input type="password" name="password" class="w-full border border-gray-300 p-2.5 rounded-lg text-sm outline-none focus:ring-2 focus:ring-indigo-500 transition" required>
            </div>
            <button class="w-full bg-indigo-600 text-white py-2.5 rounded-lg font-bold hover:bg-indigo-700 transition shadow-lg shadow-indigo-200 active:scale-95 transform">Masuk</button>
        </form>

        <p class="text-center text-xs mt-6 text-gray-500">
            Belum punya akun? <a href="{{ route('register') }}" class="text-indigo-600 font-bold hover:underline">Daftar</a>
        </p>
    </div>
</body>
</html>