<!DOCTYPE html>
<html lang="id">
<head>
    <title>Pilih Avatar</title>
    @vite('resources/css/app.css')
</head>
<body class="bg-slate-100 flex items-center justify-center min-h-screen p-4">
    <div class="bg-white p-8 rounded-2xl shadow-xl w-full max-w-2xl relative">
        {{-- Tombol Kembali --}}
        <a href="{{ route('home') }}" class="absolute top-6 left-6 text-slate-400 hover:text-indigo-600 transition font-bold flex items-center gap-1">
            <span>⬅</span> Kembali
        </a>

        <h1 class="text-2xl font-bold text-center text-indigo-600 mb-2 mt-2">Pilih Avatar Kamu</h1>
        <p class="text-center text-slate-400 text-sm mb-8">Pilih salah satu karakter di bawah ini untuk menyembunyikan identitasmu.</p>

        @if(session('success'))
            <div class="bg-green-100 text-green-700 p-3 rounded mb-6 text-center font-bold border border-green-200">
                {{ session('success') }}
            </div>
        @endif

        <form action="{{ route('profile.update') }}" method="POST">
            @csrf
            @method('PATCH')
            
            {{-- Grid Pilihan Avatar --}}
            <div class="grid grid-cols-3 sm:grid-cols-4 md:grid-cols-6 gap-4 mb-8">
                @foreach($avatars as $seed)
                    <label class="cursor-pointer group relative">
                        <input type="radio" name="avatar" value="{{ $seed }}" class="peer sr-only" {{ Auth::user()->avatar == $seed ? 'checked' : '' }}>
                        
                        <div class="p-2 rounded-xl border-2 transition-all duration-200 
                                    peer-checked:border-indigo-500 peer-checked:bg-indigo-50 peer-checked:scale-105
                                    border-slate-100 hover:border-indigo-200 bg-slate-50">
                            <img src="https://api.dicebear.com/9.x/notionists/svg?seed={{ $seed }}" 
                                 class="w-full h-auto rounded-full transition-transform group-hover:rotate-6">
                        </div>
                        
                        {{-- Indikator Terpilih --}}
                        <div class="absolute -top-2 -right-2 bg-indigo-600 text-white rounded-full p-1 opacity-0 peer-checked:opacity-100 transition-opacity">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                            </svg>
                        </div>
                    </label>
                @endforeach
            </div>

            <div class="flex justify-center">
                <button class="bg-indigo-600 text-white px-8 py-3 rounded-full font-bold hover:bg-indigo-700 transition shadow-lg shadow-indigo-200 w-full sm:w-auto">
                    Simpan Avatar
                </button>
            </div>
        </form>
    </div>
</body>
</html>