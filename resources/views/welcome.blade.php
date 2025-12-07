<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menfess Angkatan</title>
    @vite('resources/css/app.css')
    
    <script>
        if (localStorage.theme === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark');
        } else {
            document.documentElement.classList.remove('dark');
        }
    </script>
</head>
<body class="bg-slate-100 dark:bg-slate-900 text-slate-800 dark:text-slate-200 font-sans transition-colors duration-300">

    <div class="max-w-md mx-auto min-h-screen bg-white dark:bg-slate-800 shadow-2xl relative flex flex-col transition-colors duration-300">
        
        {{-- Header Baru dengan Hamburger Menu --}}
        <div class="bg-indigo-600 dark:bg-indigo-900 text-white rounded-b-3xl shadow-lg relative z-50 transition-colors duration-300 mb-10">
            <div class="p-5 flex justify-between items-start">
                <div>
                    <h1 class="text-2xl font-bold tracking-tight">💬 VEXFESS</h1>
                    <p class="text-indigo-200 text-xs mt-1 mb-3">Halo, {{ Auth::user()->name }} 👋</p>
                </div>

                <div class="flex gap-3 items-center">
                    {{-- Tombol Dark Mode (Selalu Muncul) --}}
                    <button id="theme-toggle" class="text-white hover:text-indigo-200 transition">
                        <svg id="theme-toggle-light-icon" class="hidden w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path d="M10 2a1 1 0 011 1v1a1 1 0 11-2 0V3a1 1 0 011-1zm4 8a4 4 0 11-8 0 4 4 0 018 0zm-.464 4.95l.707.707a1 1 0 001.414-1.414l-.707-.707a1 1 0 00-1.414 1.414zm2.12-10.607a1 1 0 010 1.414l-.706.707a1 1 0 11-1.414-1.414l.707-.707a1 1 0 011.414 0zM17 11a1 1 0 100-2h-1a1 1 0 100 2h1zm-7 4a1 1 0 011 1v1a1 1 0 11-2 0v-1a1 1 0 011-1zM5.05 6.464A1 1 0 106.465 5.05l-.708-.707a1 1 0 00-1.414 1.414l.707.707zm1.414 8.486l-.707.707a1 1 0 01-1.414-1.414l.707-.707a1 1 0 011.414 1.414zM4 11a1 1 0 100-2H3a1 1 0 000 2h1z" fill-rule="evenodd" clip-rule="evenodd"></path></svg>
                        <svg id="theme-toggle-dark-icon" class="hidden w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path d="M17.293 13.293A8 8 0 016.707 2.707a8.001 8.001 0 1010.586 10.586z"></path></svg>
                    </button>

                    {{-- Hamburger Button (Mobile Only) --}}
                    <button id="menu-btn" class="block md:hidden text-white focus:outline-none">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                        </svg>
                    </button>

                    {{-- Menu Desktop (Hidden di Mobile) --}}
                    <div class="hidden md:flex gap-2 items-center">
                        <a href="{{ route('profile.edit') }}" class="bg-indigo-500 hover:bg-indigo-400 dark:bg-indigo-800 text-white text-[10px] px-3 py-1.5 rounded-full transition font-semibold border border-indigo-400 dark:border-indigo-600 shadow-sm">
                            👤 Profil
                        </a>
                        @if(Auth::user()->is_admin)
                            <a href="{{ route('admin.index') }}" class="bg-yellow-400 hover:bg-yellow-500 text-yellow-900 text-[10px] px-3 py-1.5 rounded-full transition font-bold shadow-sm">
                                👑 Admin
                            </a>
                        @endif
                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button class="bg-indigo-700 hover:bg-indigo-800 dark:bg-indigo-950 text-[10px] px-3 py-1.5 rounded-full transition font-semibold border border-indigo-500 dark:border-indigo-700 shadow-sm">
                                🚪 Logout
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            {{-- Mobile Menu Dropdown (Hidden by default) --}}
            <div id="mobile-menu" class="hidden bg-indigo-700 dark:bg-indigo-950 rounded-b-3xl overflow-hidden shadow-inner transition-all duration-300 md:hidden">
                <a href="{{ route('profile.edit') }}" class="block px-6 py-3 text-sm text-indigo-100 hover:bg-indigo-600 dark:hover:bg-indigo-900 hover:text-white transition border-b border-indigo-600 dark:border-indigo-800 flex items-center gap-2">
                    👤 Edit Profil
                </a>
                @if(Auth::user()->is_admin)
                    <a href="{{ route('admin.index') }}" class="block px-6 py-3 text-sm text-yellow-300 hover:bg-indigo-600 dark:hover:bg-indigo-900 hover:text-yellow-200 transition border-b border-indigo-600 dark:border-indigo-800 flex items-center gap-2 font-bold">
                        👑 Admin Panel
                    </a>
                @endif
                <form action="{{ route('logout') }}" method="POST" class="block w-full">
                    @csrf
                    <button class="w-full text-left px-6 py-3 text-sm text-red-300 hover:bg-indigo-600 dark:hover:bg-indigo-900 hover:text-red-200 transition flex items-center gap-2">
                        🚪 Logout
                    </button>
                </form>
            </div>
        </div>

        {{-- Form Input --}}
        <div class="px-5 -mt-6 relative z-20 flex-none">
            <div class="bg-white dark:bg-slate-700 p-4 rounded-xl shadow-md border border-slate-100 dark:border-slate-600 transition-colors duration-300">
                <form action="{{ route('menfess.store') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label class="text-xs font-bold text-slate-500 dark:text-slate-300 uppercase">To:</label>
                        <input type="text" name="recipient" placeholder="Nama / Inisial (Opsional)" class="w-full border-b-2 border-slate-200 dark:border-slate-500 dark:bg-slate-700 dark:text-white focus:border-indigo-500 dark:focus:border-indigo-400 outline-none py-1 text-sm transition-colors placeholder-slate-400 dark:placeholder-slate-500">
                    </div>
                    
                    <div class="mb-3">
                        <textarea name="message" rows="3" placeholder="Tulis pesanmu disini..." required class="w-full bg-slate-50 dark:bg-slate-800 dark:text-white rounded-lg p-2 text-sm outline-none focus:ring-2 focus:ring-indigo-200 dark:focus:ring-indigo-500 transition-colors placeholder-slate-400 dark:placeholder-slate-500"></textarea>
                    </div>

                    <div class="flex justify-between items-center">
                        <select name="tag" class="text-xs bg-slate-100 dark:bg-slate-800 dark:text-white border-none rounded-lg py-1 px-2 focus:ring-2 focus:ring-indigo-500 dark:focus:ring-indigo-400 outline-none transition-colors cursor-pointer">
                            <option value="Curhat">Curhat</option>
                            <option value="Spill">Spill</option>
                            <option value="Confess">Confess</option>
                            <option value="Random">Random</option>
                        </select>
                        <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 dark:bg-indigo-500 dark:hover:bg-indigo-600 text-white text-sm px-4 py-2 rounded-full font-bold transition shadow-lg shadow-indigo-200 dark:shadow-none">
                            Kirim 🚀
                        </button>
                    </div>
                </form>
            </div>
            
            @if(session('success'))
                <div class="mt-4 bg-green-100 dark:bg-green-900 text-green-700 dark:text-green-100 p-3 rounded-lg text-xs font-bold text-center border border-green-200 dark:border-green-800 transition-colors">
                    {{ session('success') }}
                </div>
            @endif
        </div>

        {{-- Search & Sort Bar --}}
        <div class="px-5 mt-4 mb-2 flex-none">
            <form action="{{ route('home') }}" method="GET" class="flex flex-col gap-3">
                <div class="relative">
                    <input type="text" name="search" value="{{ request('search') }}" 
                        placeholder="Cari..." 
                        class="w-full bg-slate-50 dark:bg-slate-700 dark:text-white border border-slate-200 dark:border-slate-600 text-sm rounded-full px-4 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500 dark:focus:ring-indigo-400 transition-colors placeholder-slate-400 dark:placeholder-slate-500">
                    <button type="submit" class="absolute right-3 top-2.5 text-gray-400 hover:text-indigo-600 dark:text-gray-300 dark:hover:text-indigo-400 transition-colors">🔍</button>
                </div>

                <div class="flex justify-between items-center text-xs">
                    <div class="flex bg-slate-100 dark:bg-slate-700 p-1 rounded-lg transition-colors">
                        <button type="submit" name="sort" value="latest" 
                            class="px-3 py-1 rounded-md transition {{ request('sort', 'latest') == 'latest' ? 'bg-white dark:bg-slate-600 text-indigo-600 dark:text-indigo-300 shadow-sm font-bold' : 'text-slate-500 dark:text-slate-400 hover:text-slate-700 dark:hover:text-slate-200' }}">
                            Terbaru
                        </button>
                        <button type="submit" name="sort" value="oldest" 
                            class="px-3 py-1 rounded-md transition {{ request('sort') == 'oldest' ? 'bg-white dark:bg-slate-600 text-indigo-600 dark:text-indigo-300 shadow-sm font-bold' : 'text-slate-500 dark:text-slate-400 hover:text-slate-700 dark:hover:text-slate-200' }}">
                            Terlama
                        </button>
                        <button type="submit" name="sort" value="popular" 
                            class="px-3 py-1 rounded-md transition {{ request('sort') == 'popular' ? 'bg-white dark:bg-slate-600 text-indigo-600 dark:text-indigo-300 shadow-sm font-bold' : 'text-slate-500 dark:text-slate-400 hover:text-slate-700 dark:hover:text-slate-200' }}">
                            🔥 Populer
                        </button>
                    </div>

                    @if(request('tag'))
                        <input type="hidden" name="tag" value="{{ request('tag') }}">
                        <span class="bg-indigo-100 dark:bg-indigo-900 text-indigo-600 dark:text-indigo-300 px-2 py-1 rounded-md font-bold transition-colors">
                            #{{ request('tag') }}
                            <a href="{{ route('home', ['sort' => request('sort')]) }}" class="ml-1 text-indigo-400 dark:text-indigo-500 hover:text-indigo-700 transition-colors">✕</a>
                        </span>
                    @endif
                </div>

                @if(request('search'))
                    <div class="text-center mt-2 flex justify-center">
                        <a href="{{ route('home') }}" class="inline-flex items-center gap-1 bg-red-100 dark:bg-red-900 text-red-600 dark:text-red-200 text-xs px-3 py-1.5 rounded-full font-bold hover:bg-red-200 dark:hover:bg-red-800 transition shadow-sm border border-red-200 dark:border-red-800">
                            <span>✕</span> Reset Pencarian
                        </a>
                    </div>
                @endif
            </form>
        </div>

        {{-- Feed Pesan --}}
        <div class="p-5 pb-20 space-y-4 flex-grow">
            <h3 class="text-slate-400 dark:text-slate-500 text-xs font-bold uppercase tracking-wider transition-colors">
                @if(request('sort') == 'popular')
                    Timeline Terpopuler 🔥
                @elseif(request('sort') == 'oldest')
                    Timeline Terlama ⏳
                @else
                    Timeline Terbaru 🕒
                @endif
            </h3>
            
            @foreach($menfesses as $item)
            <div class="border dark:border-slate-700 p-4 rounded-xl shadow-sm hover:shadow-md transition bg-white dark:bg-slate-700 relative duration-300">
                <div class="flex items-start gap-3 mb-3">
                    <img src="https://api.dicebear.com/9.x/lorelei-neutral/svg?seed={{ $item->user->avatar ?? $item->user->name }}" 
                         alt="avatar" 
                         class="w-10 h-10 rounded-full bg-indigo-50 dark:bg-slate-600 border border-indigo-100 dark:border-slate-500 p-0.5 object-cover transition-colors">
                    
                    <div class="flex-1">
                        <div class="flex justify-between items-start">
                            <span class="text-sm font-bold text-gray-800 dark:text-slate-200 transition-colors">{{ $item->user->name }}</span>
                            <span class="text-[10px] text-slate-400 dark:text-slate-400 transition-colors">{{ $item->created_at->diffForHumans() }}</span>
                        </div>
                        <p class="text-xs font-bold text-slate-500 dark:text-slate-400 mt-0.5 transition-colors">To: {{ $item->recipient }}</p>
                    </div>
                </div>

                <p class="text-sm text-slate-800 dark:text-slate-200 leading-relaxed mb-3 pl-[3.25rem] transition-colors">
                    {{ $item->message }}
                </p>

                <div class="flex justify-end items-center border-t dark:border-slate-600 pt-2 mt-2 border-dashed border-gray-100 transition-colors">
                    <form action="{{ route('menfess.like', $item->id) }}" method="POST">
                        @csrf
                        @php
                            $isLiked = in_array($item->id, $likedMenfessIds ?? []);
                        @endphp

                        <button type="submit" class="flex items-center text-xs transition group {{ $isLiked ? 'text-red-500' : 'text-gray-400 dark:text-slate-400 hover:text-red-400' }}">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="{{ $isLiked ? 'currentColor' : 'none' }}" stroke="currentColor" stroke-width="2" class="w-5 h-5 group-hover:scale-110 transition transform duration-200">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12z" />
                            </svg>
                            <span class="ml-1.5 font-bold">{{ $item->likes }}</span>
                        </button>
                    </form>
                </div>
            </div>
            @endforeach

            {{-- Custom Pagination --}}
            <div class="mt-8 pt-6 border-t border-slate-100 dark:border-slate-700 pb-10 transition-colors">
                @php $menfesses->appends(request()->query()); @endphp
                
                @if ($menfesses->hasPages())
                    <nav role="navigation" aria-label="Pagination Navigation" class="flex flex-col items-center">
                        <div class="mb-4 text-xs text-slate-400 dark:text-slate-500 font-medium tracking-wide transition-colors">
                            Halaman <span class="font-bold text-slate-600 dark:text-slate-300">{{ $menfesses->currentPage() }}</span> 
                            dari <span class="font-bold text-slate-600 dark:text-slate-300">{{ $menfesses->lastPage() }}</span>
                        </div>

                        <div class="flex justify-center items-center gap-2 w-full px-2">
                            @if ($menfesses->onFirstPage())
                                <span class="px-4 py-2 text-slate-300 dark:text-slate-600 bg-slate-50 dark:bg-slate-800 border border-slate-100 dark:border-slate-700 rounded-xl cursor-not-allowed text-xs font-bold flex items-center gap-1 transition-colors">
                                    <span>←</span> Prev
                                </span>
                            @else
                                <a href="{{ $menfesses->previousPageUrl() }}" rel="prev" class="px-4 py-2 text-indigo-600 dark:text-indigo-400 bg-white dark:bg-slate-700 border border-indigo-100 dark:border-slate-600 rounded-xl hover:bg-indigo-50 dark:hover:bg-slate-600 hover:border-indigo-200 transition-all duration-200 text-xs font-bold flex items-center gap-1 group">
                                    <span class="group-hover:-translate-x-0.5 transition-transform">←</span> Prev
                                </a>
                            @endif

                            <div class="flex gap-1.5 px-2 items-center">
                                @php
                                    $currentPage = $menfesses->currentPage();
                                    $lastPage = $menfesses->lastPage();
                                    $start = max(1, $currentPage - 1);
                                    $end = min($lastPage, $currentPage + 1);
                                    if ($lastPage >= 3) {
                                        if ($currentPage == 1) $end = 3;
                                        if ($currentPage == $lastPage) $start = $lastPage - 2;
                                    }
                                @endphp

                                @foreach ($menfesses->getUrlRange(1, $lastPage) as $page => $url)
                                    @php $isVisible = ($page >= $start && $page <= $end); @endphp

                                    <div class="{{ $isVisible ? 'block' : 'hidden' }}">
                                        @if ($page == $menfesses->currentPage())
                                            <span class="w-9 h-9 flex items-center justify-center bg-indigo-600 dark:bg-indigo-500 text-white rounded-xl text-xs font-bold shadow-md transform scale-105 ring-2 ring-indigo-100 dark:ring-slate-700 ring-offset-1 dark:ring-offset-slate-800 transition-all">
                                                {{ $page }}
                                            </span>
                                        @else
                                            <a href="{{ $url }}" class="w-9 h-9 flex items-center justify-center text-slate-500 dark:text-slate-400 border border-slate-200 dark:border-slate-700 rounded-lg hover:bg-slate-50 dark:hover:bg-slate-700 hover:text-indigo-600 dark:hover:text-indigo-400 hover:border-indigo-200 transition text-xs font-semibold cursor-pointer block">
                                                {{ $page }}
                                            </a>
                                        @endif
                                    </div>
                                @endforeach
                            </div>

                            @if ($menfesses->hasMorePages())
                                <a href="{{ $menfesses->nextPageUrl() }}" rel="next" class="px-4 py-2 text-indigo-600 dark:text-indigo-400 bg-white dark:bg-slate-700 border border-indigo-100 dark:border-slate-600 rounded-xl hover:bg-indigo-50 dark:hover:bg-slate-600 hover:border-indigo-200 transition-all duration-200 text-xs font-bold flex items-center gap-1 group">
                                    Next <span class="group-hover:translate-x-0.5 transition-transform">→</span>
                                </a>
                            @else
                                <span class="px-4 py-2 text-slate-300 dark:text-slate-600 bg-slate-50 dark:bg-slate-800 border border-slate-100 dark:border-slate-700 rounded-xl cursor-not-allowed text-xs font-bold flex items-center gap-1 transition-colors">
                                    Next <span>→</span>
                                </span>
                            @endif
                        </div>
                        
                        <div class="mt-4 text-[10px] text-slate-400 dark:text-slate-500 transition-colors">
                            Menampilkan hasil <span class="font-medium text-slate-500 dark:text-slate-400">{{ $menfesses->firstItem() }}-{{ $menfesses->lastItem() }}</span> dari total <span class="font-medium text-slate-500 dark:text-slate-400">{{ $menfesses->total() }}</span>
                        </div>
                    </nav>
                @endif
            </div>
        </div>
    </div>

    {{-- Script untuk Toggle Dark Mode & Hamburger Menu --}}
    <script>
        // Dark Mode Logic
        const themeToggleBtn = document.getElementById('theme-toggle');
        const themeToggleDarkIcon = document.getElementById('theme-toggle-dark-icon');
        const themeToggleLightIcon = document.getElementById('theme-toggle-light-icon');

        function setIcon(isDark) {
            if (isDark) {
                themeToggleLightIcon.classList.remove('hidden');
                themeToggleDarkIcon.classList.add('hidden');
            } else {
                themeToggleLightIcon.classList.add('hidden');
                themeToggleDarkIcon.classList.remove('hidden');
            }
        }

        if (localStorage.getItem('theme') === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            setIcon(true);
        } else {
            setIcon(false);
        }

        themeToggleBtn.addEventListener('click', function() {
            if (localStorage.getItem('theme')) {
                if (localStorage.getItem('theme') === 'light') {
                    document.documentElement.classList.add('dark');
                    localStorage.setItem('theme', 'dark');
                    setIcon(true);
                } else {
                    document.documentElement.classList.remove('dark');
                    localStorage.setItem('theme', 'light');
                    setIcon(false);
                }
            } else {
                if (document.documentElement.classList.contains('dark')) {
                    document.documentElement.classList.remove('dark');
                    localStorage.setItem('theme', 'light');
                    setIcon(false);
                } else {
                    document.documentElement.classList.add('dark');
                    localStorage.setItem('theme', 'dark');
                    setIcon(true);
                }
            }
        });

        // Hamburger Menu Logic (Vanila JS Sederhana)
        const menuBtn = document.getElementById('menu-btn');
        const mobileMenu = document.getElementById('mobile-menu');

        menuBtn.addEventListener('click', () => {
            mobileMenu.classList.toggle('hidden');
        });
    </script>
</body>
</html>