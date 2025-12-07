<!DOCTYPE html>
<html lang="id">
<head>
    <title>Pilih Avatar</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite('resources/css/app.css')
    <script>
        if (localStorage.theme === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark');
        } else {
            document.documentElement.classList.remove('dark');
        }
    </script>
</head>
<body class="bg-slate-100 dark:bg-slate-900 flex items-center justify-center min-h-screen p-4 transition-colors duration-300">
    <div class="bg-white dark:bg-slate-800 p-6 rounded-2xl shadow-xl w-full max-w-2xl relative flex flex-col transition-colors duration-300">
        
        {{-- Header: Tombol Kembali & Judul --}}
        <div class="flex flex-col sm:flex-row items-center justify-center relative mb-6">
            <div class="self-start sm:absolute sm:left-0 sm:top-1/2 sm:-translate-y-1/2 mb-4 sm:mb-0 z-10">
                <a href="{{ route('home') }}" class="text-slate-400 dark:text-slate-500 hover:text-indigo-600 dark:hover:text-indigo-400 transition font-bold flex items-center gap-1 text-sm cursor-pointer">
                    <span>⬅</span> <span>Kembali</span>
                </a>
            </div>

            <div class="text-center w-full">
                <h1 class="text-4xl sm:text-6xl font-black text-indigo-600 dark:text-indigo-400 tracking-tight drop-shadow-sm leading-tight mt-2 sm:mt-0">
                    Pilih Avatar
                </h1>
                <p class="text-slate-400 dark:text-slate-500 text-xs sm:text-sm mt-2 font-medium">
                    Halaman {{ $avatars->currentPage() }} dari {{ $avatars->lastPage() }}
                </p>
            </div>
        </div>

        @if(session('success'))
            <div class="bg-green-100 dark:bg-green-900 text-green-700 dark:text-green-100 p-3 rounded-xl mb-6 text-center font-bold border border-green-200 dark:border-green-800 text-xs sm:text-sm">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="bg-red-100 dark:bg-red-900 text-red-700 dark:text-red-100 p-3 rounded-xl mb-6 text-center font-bold border border-red-200 dark:border-red-800 text-xs sm:text-sm">
                {{ session('error') }}
            </div>
        @endif

        <form action="{{ route('profile.update') }}" method="POST" class="flex-1 flex flex-col">
            @csrf
            @method('PATCH')
            
            {{-- Grid Avatar --}}
            <div class="grid grid-cols-2 sm:grid-cols-5 gap-3 sm:gap-4 mb-8">
                @foreach($avatars as $seed)
                    <label class="cursor-pointer group relative flex flex-col items-center {{ $loop->index >= 6 ? 'hidden sm:flex' : 'flex' }}">
                        <input type="radio" name="avatar" value="{{ $seed }}" class="peer sr-only" {{ Auth::user()->avatar == $seed ? 'checked' : '' }}>
                        
                        <div class="p-1.5 rounded-xl border-2 transition-all duration-200 
                                    peer-checked:border-indigo-500 dark:peer-checked:border-indigo-400 peer-checked:bg-indigo-50 dark:peer-checked:bg-slate-700 peer-checked:scale-105
                                    border-slate-100 dark:border-slate-700 hover:border-indigo-200 dark:hover:border-indigo-500 bg-slate-50 dark:bg-slate-700 w-full aspect-square flex items-center justify-center">
                            <img src="https://api.dicebear.com/9.x/lorelei-neutral/svg?seed={{ $seed }}" 
                                 class="w-full h-full rounded-full bg-white dark:bg-slate-600 shadow-sm object-cover">
                        </div>
                        <div class="text-center mt-2 text-xs font-bold text-slate-400 dark:text-slate-500 group-hover:text-indigo-500 dark:group-hover:text-indigo-400 transition truncate w-full">
                            {{ $seed }}
                        </div>
                        
                        <div class="absolute top-2 right-2 bg-indigo-600 dark:bg-indigo-500 text-white rounded-full p-1 opacity-0 peer-checked:opacity-100 transition-opacity z-10 shadow-md scale-0 peer-checked:scale-100 duration-200">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                            </svg>
                        </div>
                    </label>
                @endforeach
            </div>

            {{-- Navigasi Halaman --}}
            <div class="mb-8 w-full">
                <div class="flex flex-wrap justify-between sm:justify-center items-center gap-2 w-full">
                    {{-- Tombol Previous --}}
                    @if ($avatars->onFirstPage())
                        {{-- Hapus flex-1 untuk mobile agar tidak terlalu lebar, ganti w-auto atau px-4 --}}
                        <span class="px-4 py-2 text-slate-300 dark:text-slate-600 border border-slate-200 dark:border-slate-700 rounded-lg cursor-not-allowed text-xs font-bold bg-slate-50 dark:bg-slate-800 text-center w-auto">
                            ← Prev
                        </span>
                    @else
                        <a href="{{ $avatars->previousPageUrl() }}" class="px-4 py-2 text-indigo-600 dark:text-indigo-400 border border-indigo-200 dark:border-slate-600 rounded-lg hover:bg-indigo-50 dark:hover:bg-slate-700 hover:border-indigo-300 transition text-xs font-bold shadow-sm text-center w-auto cursor-pointer block">
                            ← Prev
                        </a>
                    @endif

                    {{-- Angka Halaman --}}
                    <div class="flex gap-1 justify-center px-1">
                        @php
                            $currentPage = $avatars->currentPage();
                            $lastPage = $avatars->lastPage();
                            $start = max(1, $currentPage - 1);
                            $end = min($lastPage, $currentPage + 1);
                            if ($lastPage >= 3) {
                                if ($currentPage == 1) $end = 3;
                                if ($currentPage == $lastPage) $start = $lastPage - 2;
                            }
                        @endphp

                        @foreach ($avatars->getUrlRange(1, $lastPage) as $page => $url)
                            @php $isVisible = ($page >= $start && $page <= $end); @endphp

                            {{-- GUNAKAN FLEX, HAPUS BLOCK --}}
                            <div class="{{ $isVisible ? 'flex' : 'hidden sm:flex' }}">
                                @if ($page == $currentPage)
                                    <span class="w-9 h-9 flex items-center justify-center bg-indigo-600 dark:bg-indigo-500 text-white rounded-lg text-xs font-bold shadow-md transform scale-105">
                                        {{ $page }}
                                    </span>
                                @else
                                    {{-- Pastikan ini flex items-center justify-center --}}
                                    <a href="{{ $url }}" class="w-9 h-9 flex items-center justify-center text-slate-500 dark:text-slate-400 border border-slate-200 dark:border-slate-700 rounded-lg hover:bg-slate-50 dark:hover:bg-slate-700 hover:text-indigo-600 dark:hover:text-indigo-400 hover:border-indigo-200 transition text-xs font-semibold cursor-pointer">
                                        {{ $page }}
                                    </a>
                                @endif
                            </div>
                        @endforeach
                    </div>

                    {{-- Tombol Next --}}
                    @if ($avatars->hasMorePages())
                        <a href="{{ $avatars->nextPageUrl() }}" class="px-4 py-2 text-indigo-600 dark:text-indigo-400 border border-indigo-200 dark:border-slate-600 rounded-lg hover:bg-indigo-50 dark:hover:bg-slate-700 hover:border-indigo-300 transition text-xs font-bold shadow-sm text-center w-auto cursor-pointer block">
                            Next →
                        </a>
                    @else
                        <span class="px-4 py-2 text-slate-300 dark:text-slate-600 border border-slate-200 dark:border-slate-700 rounded-lg cursor-not-allowed text-xs font-bold bg-slate-50 dark:bg-slate-800 text-center w-auto">
                            Next →
                        </span>
                    @endif
                </div>
            </div>

            <div class="flex justify-center border-t border-slate-100 dark:border-slate-700 pt-6 mt-auto">
                <button class="bg-indigo-600 hover:bg-indigo-700 dark:bg-indigo-500 dark:hover:bg-indigo-600 text-white px-12 py-3.5 rounded-full font-bold transition shadow-lg shadow-indigo-200 dark:shadow-none w-full sm:w-auto flex items-center justify-center gap-2 transform active:scale-95 text-base sm:text-lg">
                    <span>💾</span> Simpan Avatar
                </button>
            </div>
        </form>
    </div>
</body>
</html>