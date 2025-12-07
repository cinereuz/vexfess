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
        
        {{-- Header Baru (Background di Belakang) --}}
        <div id="main-header" class="bg-indigo-600 dark:bg-indigo-900 text-white rounded-b-[2.5rem] shadow-lg relative z-10 transition-all duration-300 pb-24 pt-4">
            <div class="px-6 flex flex-col gap-6">
                
                {{-- Baris 1: Tombol Navigasi (Kanan Atas) --}}
                <div class="flex justify-between items-center w-full">
                    {{-- Logo Kecil (Opsional, atau biarkan kosong di kiri untuk balance) --}}
                    <div class="text-indigo-300 text-xs font-bold tracking-widest opacity-0">VEXFESS</div> 

                    <div class="flex gap-3 items-center">
                        {{-- Tombol Dark Mode --}}
                        <button id="theme-toggle" class="text-white hover:text-indigo-200 transition p-1 rounded-full hover:bg-white/10">
                            <svg id="theme-toggle-light-icon" class="hidden w-6 h-6" fill="currentColor" viewBox="0 0 20 20"><path d="M10 2a1 1 0 011 1v1a1 1 0 11-2 0V3a1 1 0 011-1zm4 8a4 4 0 11-8 0 4 4 0 018 0zm-.464 4.95l.707.707a1 1 0 001.414-1.414l-.707-.707a1 1 0 00-1.414 1.414zm2.12-10.607a1 1 0 010 1.414l-.706.707a1 1 0 11-1.414-1.414l.707-.707a1 1 0 011.414 0zM17 11a1 1 0 100-2h-1a1 1 0 100 2h1zm-7 4a1 1 0 011 1v1a1 1 0 11-2 0v-1a1 1 0 011-1zM5.05 6.464A1 1 0 106.465 5.05l-.708-.707a1 1 0 00-1.414 1.414l.707.707zm1.414 8.486l-.707.707a1 1 0 01-1.414-1.414l.707-.707a1 1 0 011.414 1.414zM4 11a1 1 0 100-2H3a1 1 0 000 2h1z" fill-rule="evenodd" clip-rule="evenodd"></path></svg>
                            <svg id="theme-toggle-dark-icon" class="hidden w-6 h-6" fill="currentColor" viewBox="0 0 20 20"><path d="M17.293 13.293A8 8 0 016.707 2.707a8.001 8.001 0 1010.586 10.586z"></path></svg>
                        </button>

                        {{-- Hamburger Button (Mobile Only) --}}
                        <button id="menu-btn" class="md:hidden text-white focus:outline-none p-1 transition-transform active:scale-95 rounded-full hover:bg-white/10 relative w-8 h-8">
                            <svg id="icon-menu-open" class="w-7 h-7 drop-shadow-sm absolute inset-0 transition-opacity duration-300 ease-in-out opacity-100" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                            </svg>
                            <svg id="icon-menu-close" class="w-7 h-7 drop-shadow-sm absolute inset-0 transition-opacity duration-300 ease-in-out opacity-0 pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>

                        {{-- Menu Desktop --}}
                        <div class="hidden md:flex gap-2 items-center">
                            <a href="{{ route('profile.edit') }}" class="bg-white/20 hover:bg-white/30 text-white text-[11px] px-4 py-2 rounded-full transition font-bold border border-white/30 backdrop-blur-sm whitespace-nowrap flex items-center gap-1.5">
                                <span>👤</span> Profil
                            </a>
                            @if(Auth::user()->is_admin)
                                <a href="{{ route('admin.index') }}" class="bg-yellow-400 hover:bg-yellow-500 text-yellow-900 text-[11px] px-4 py-2 rounded-full transition font-bold shadow-sm whitespace-nowrap flex items-center gap-1.5">
                                    <span>👑</span> Admin
                                </a>
                            @endif
                            <form action="{{ route('logout') }}" method="POST">
                                @csrf
                                <button class="bg-indigo-800 hover:bg-indigo-950 text-white text-[11px] px-4 py-2 rounded-full transition font-bold border border-indigo-500 shadow-sm whitespace-nowrap flex items-center gap-1.5">
                                    <span>🚪</span> Logout
                                </button>
                            </form>
                        </div>
                    </div>
                </div>

                {{-- Baris 2: Judul Besar & Sapaan (Kiri Bawah) --}}
                <div class="mt-2">
                    <p class="text-indigo-200 text-xs font-bold uppercase tracking-wider mb-1">Selamat Datang</p>
                    <h1 class="text-4xl font-black tracking-tight drop-shadow-md leading-tight">VEXFESS</h1>
                    <p class="text-indigo-100 text-sm mt-1 font-medium flex items-center gap-1 opacity-90">
                        Halo, <span class="font-bold text-white border-b-2 border-yellow-400 pb-0.5">{{ Auth::user()->name }}</span> 👋
                    </p>
                </div>
            </div>

            {{-- Mobile Menu Dropdown (Overlay) --}}
            <div id="mobile-menu" class="hidden absolute top-20 left-4 right-4 bg-white/10 dark:bg-slate-900/90 backdrop-blur-xl rounded-2xl overflow-hidden shadow-2xl transition-all duration-300 md:hidden border border-white/20 dark:border-slate-700 origin-top animate-fade-in-down transform">
                <div class="p-2 space-y-1">
                    <a href="{{ route('profile.edit') }}" class="block px-4 py-3 text-sm text-white hover:bg-white/20 rounded-xl transition flex items-center gap-3 font-semibold group">
                        <span class="bg-indigo-500 p-2 rounded-lg group-hover:scale-110 transition-transform shadow-md">👤</span> Edit Profil
                    </a>
                    @if(Auth::user()->is_admin)
                        <a href="{{ route('admin.index') }}" class="block px-4 py-3 text-sm text-yellow-300 hover:bg-white/20 rounded-xl transition flex items-center gap-3 font-bold group">
                            <span class="bg-yellow-500/80 text-yellow-900 p-2 rounded-lg group-hover:scale-110 transition-transform shadow-md">👑</span> Admin Panel
                        </a>
                    @endif
                    <div class="h-px bg-white/10 my-1 mx-2"></div>
                    <form action="{{ route('logout') }}" method="POST" class="block w-full">
                        @csrf
                        <button class="w-full text-left px-4 py-3 text-sm text-rose-200 hover:bg-rose-800 hover:text-rose-200 rounded-xl transition flex items-center gap-3 font-semibold group">
                            <span class="bg-rose-500/20 p-2 rounded-lg group-hover:scale-110 transition-transform">🚪</span> Logout
                        </button>
                    </form>
                </div>
            </div>
        </div>

        {{-- Container Utama (Form & Feed) --}}
        <div class="relative z-20 -mt-12 px-5 flex-grow pb-10">
            
            {{-- Form Input (Floating Card) --}}
            <div class="bg-white dark:bg-slate-800 p-5 rounded-2xl shadow-xl border border-slate-100 dark:border-slate-700 transition-colors duration-300 mb-6">
                <form action="{{ route('menfess.store') }}" method="POST">
                    @csrf
                    <div class="mb-4">
                        <label class="text-[10px] font-bold text-slate-400 dark:text-slate-500 uppercase tracking-wider mb-1 block">Recipient</label>
                        <input type="text" name="recipient" placeholder="Nama / Inisial (Opsional)" class="w-full bg-slate-50 dark:bg-slate-900 dark:text-white border-b-2 border-slate-200 dark:border-slate-600 focus:border-indigo-500 dark:focus:border-indigo-400 outline-none py-2 text-sm transition-colors font-medium placeholder-slate-400">
                    </div>
                    
                    <div class="mb-4">
                        <textarea name="message" rows="3" placeholder="Tulis pesanmu disini..." required class="w-full bg-slate-50 dark:bg-slate-900 dark:text-white rounded-xl p-3 text-sm outline-none focus:ring-2 focus:ring-indigo-100 dark:focus:ring-indigo-900/50 border border-transparent focus:border-indigo-200 dark:focus:border-indigo-800 transition-all placeholder-slate-400 resize-none"></textarea>
                    </div>

                    <div class="flex justify-between items-center pt-2">
                        <div class="relative">
                            <select name="tag" class="appearance-none bg-slate-100 dark:bg-slate-900 text-xs font-bold text-slate-600 dark:text-slate-300 py-2 pl-3 pr-8 rounded-lg cursor-pointer hover:bg-slate-200 dark:hover:bg-slate-700 transition-colors focus:outline-none focus:ring-2 focus:ring-indigo-200">
                                <option value="Curhat">Curhat</option>
                                <option value="Spill">Spill</option>
                                <option value="Confess">Confess</option>
                                <option value="Random">Random</option>
                            </select>
                            <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-slate-500">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/></svg>
                            </div>
                        </div>

                        <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 dark:bg-indigo-500 dark:hover:bg-indigo-600 text-white text-sm px-6 py-2.5 rounded-full font-bold transition-all shadow-lg shadow-indigo-200 dark:shadow-none hover:shadow-xl active:scale-95 flex items-center gap-2">
                            <span>Kirim</span>
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-4 h-4">
                                <path d="M3.105 2.289a.75.75 0 00-.826.95l1.414 4.925A1.5 1.5 0 005.135 9.25h6.115a.75.75 0 010 1.5H5.135a1.5 1.5 0 00-1.442 1.086l-1.414 4.926a.75.75 0 00.826.95 28.896 28.896 0 0015.293-7.154.75.75 0 000-1.115A28.897 28.897 0 003.105 2.289z" />
                            </svg>
                        </button>
                    </div>
                </form>
            </div>
            
            @if(session('success'))
                <div class="mb-6 bg-emerald-100 dark:bg-emerald-900/30 text-emerald-700 dark:text-emerald-200 p-4 rounded-xl text-sm font-bold text-center border border-emerald-200 dark:border-emerald-800 flex items-center justify-center gap-2 shadow-sm">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.857-9.809a.75.75 0 00-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 10-1.06 1.061l2.5 2.5a.75.75 0 001.137-.089l4-5.5z" clip-rule="evenodd" /></svg>
                    {{ session('success') }}
                </div>
            @endif

            {{-- Search & Sort Bar --}}
            <div class="mb-6">
                <form action="{{ route('home') }}" method="GET" class="flex flex-col gap-4">
                    <div class="relative group">
                        <input type="text" name="search" value="{{ request('search') }}" 
                            placeholder="Cari pesan atau nama..." 
                            class="w-full bg-white dark:bg-slate-800 dark:text-white border border-slate-200 dark:border-slate-700 text-sm rounded-full pl-12 pr-4 py-3 focus:outline-none focus:ring-2 focus:ring-indigo-500 dark:focus:ring-indigo-400 transition-all shadow-sm group-hover:shadow-md">
                        <div class="absolute left-4 top-3 text-slate-400 group-hover:text-indigo-500 transition-colors">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5"><path fill-rule="evenodd" d="M9 3.5a5.5 5.5 0 100 11 5.5 5.5 0 000-11zM2 9a7 7 0 1112.452 4.391l3.328 3.329a.75.75 0 11-1.06 1.06l-3.329-3.328A7 7 0 012 9z" clip-rule="evenodd" /></svg>
                        </div>
                    </div>

                    <div class="flex justify-between items-center text-xs">
                        <div class="flex bg-white dark:bg-slate-800 p-1.5 rounded-xl shadow-sm border border-slate-100 dark:border-slate-700 gap-1">
                            <button type="submit" name="sort" value="latest" 
                                class="px-3 py-1.5 rounded-lg transition-all {{ request('sort', 'latest') == 'latest' ? 'bg-indigo-100 dark:bg-indigo-900/50 text-indigo-700 dark:text-indigo-300 font-bold' : 'text-slate-500 dark:text-slate-400 hover:bg-slate-50 dark:hover:bg-slate-700' }}">
                                Baru
                            </button>
                            <button type="submit" name="sort" value="oldest" 
                                class="px-3 py-1.5 rounded-lg transition-all {{ request('sort') == 'oldest' ? 'bg-indigo-100 dark:bg-indigo-900/50 text-indigo-700 dark:text-indigo-300 font-bold' : 'text-slate-500 dark:text-slate-400 hover:bg-slate-50 dark:hover:bg-slate-700' }}">
                                Lama
                            </button>
                            <button type="submit" name="sort" value="popular" 
                                class="px-3 py-1.5 rounded-lg transition-all {{ request('sort') == 'popular' ? 'bg-indigo-100 dark:bg-indigo-900/50 text-indigo-700 dark:text-indigo-300 font-bold' : 'text-slate-500 dark:text-slate-400 hover:bg-slate-50 dark:hover:bg-slate-700' }}">
                                🔥 Hits
                            </button>
                        </div>

                        @if(request('tag'))
                            <input type="hidden" name="tag" value="{{ request('tag') }}">
                            <span class="inline-flex items-center gap-1 bg-indigo-600 text-white px-3 py-1.5 rounded-lg text-xs font-bold shadow-md shadow-indigo-200 dark:shadow-none">
                                #{{ request('tag') }}
                                <a href="{{ route('home', ['sort' => request('sort')]) }}" class="hover:text-indigo-200 bg-white/20 rounded-full p-0.5 ml-1">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-3 h-3"><path d="M6.28 5.22a.75.75 0 00-1.06 1.06L8.94 10l-3.72 3.72a.75.75 0 101.06 1.06L10 11.06l3.72 3.72a.75.75 0 101.06-1.06L11.06 10l3.72-3.72a.75.75 0 00-1.06-1.06L10 8.94 6.28 5.22z" /></svg>
                                </a>
                            </span>
                        @endif
                    </div>

                    @if(request('search'))
                        <div class="text-center">
                            <a href="{{ route('home') }}" class="inline-flex items-center gap-2 bg-slate-200 dark:bg-slate-700 text-slate-600 dark:text-slate-300 text-xs px-4 py-2 rounded-full font-bold hover:bg-slate-300 dark:hover:bg-slate-600 transition">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-3 h-3"><path d="M6.28 5.22a.75.75 0 00-1.06 1.06L8.94 10l-3.72 3.72a.75.75 0 101.06 1.06L10 11.06l3.72 3.72a.75.75 0 101.06-1.06L11.06 10l3.72-3.72a.75.75 0 00-1.06-1.06L10 8.94 6.28 5.22z" /></svg>
                                Hapus Pencarian
                            </a>
                        </div>
                    @endif
                </form>
            </div>

            {{-- Feed Pesan --}}
            <div class="space-y-5">
                <div class="flex items-center gap-4 mb-2">
                    <h3 class="text-slate-400 dark:text-slate-500 text-xs font-bold uppercase tracking-wider transition-colors">
                        @if(request('sort') == 'popular')
                            Timeline Terpopuler
                        @elseif(request('sort') == 'oldest')
                            Timeline Terlama
                        @else
                            Timeline Terbaru
                        @endif
                    </h3>
                    <div class="h-px bg-slate-200 dark:bg-slate-700 flex-grow"></div>
                </div>
                
                @foreach($menfesses as $item)
                <div class="bg-white dark:bg-slate-800 p-5 rounded-2xl shadow-sm border border-slate-100 dark:border-slate-700 hover:shadow-md hover:border-indigo-100 dark:hover:border-slate-600 transition-all duration-300 group">
                    <div class="flex items-start gap-3 mb-3">
                        <img src="https://api.dicebear.com/9.x/lorelei-neutral/svg?seed={{ $item->user->avatar ?? $item->user->name }}" 
                             alt="avatar" 
                             class="w-10 h-10 rounded-full bg-indigo-50 dark:bg-slate-700 border border-indigo-100 dark:border-slate-600 p-0.5 object-cover group-hover:scale-105 transition-transform">
                        
                        <div class="flex-1">
                            <div class="flex justify-between items-start">
                                <span class="text-sm font-bold text-gray-800 dark:text-slate-200 transition-colors">{{ $item->user->name }}</span>
                                <span class="text-[10px] text-slate-400 dark:text-slate-500">{{ $item->created_at->diffForHumans() }}</span>
                            </div>
                            <div class="flex items-center gap-2 mt-0.5">
                                <span class="text-[10px] bg-slate-100 dark:bg-slate-700 text-slate-500 dark:text-slate-400 px-2 py-0.5 rounded-full font-bold">To: {{ $item->recipient }}</span>
                                <span class="text-[10px] text-indigo-400 dark:text-indigo-300 font-medium">#{{ $item->tag }}</span>
                            </div>
                        </div>
                    </div>

                    <p class="text-sm text-slate-700 dark:text-slate-300 leading-relaxed mb-4 pl-[3.25rem] transition-colors">
                        {{ $item->message }}
                    </p>

                    <div class="flex justify-end items-center border-t border-dashed border-slate-100 dark:border-slate-700 pt-3">
                        <form action="{{ route('menfess.like', $item->id) }}" method="POST">
                            @csrf
                            @php
                                $isLiked = in_array($item->id, $likedMenfessIds ?? []);
                            @endphp

                            <button type="submit" class="flex items-center gap-1.5 text-xs transition-colors {{ $isLiked ? 'text-rose-500 font-bold' : 'text-slate-400 hover:text-rose-400 font-medium' }}">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="{{ $isLiked ? 'currentColor' : 'none' }}" stroke="currentColor" stroke-width="2" class="w-5 h-5 {{ $isLiked ? 'scale-110' : '' }}">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12z" />
                                </svg>
                                <span>{{ $item->likes }}</span>
                            </button>
                        </form>
                    </div>
                </div>
                @endforeach

                {{-- Custom Pagination --}}
                <div class="mt-8 pt-6 border-t border-slate-100 dark:border-slate-700">
                    @php $menfesses->appends(request()->query()); @endphp
                    
                    @if ($menfesses->hasPages())
                        <nav role="navigation" aria-label="Pagination Navigation" class="flex flex-col items-center">
                            <div class="mb-4 text-xs text-slate-400 dark:text-slate-500 font-medium tracking-wide transition-colors">
                                Halaman <span class="font-bold text-slate-600 dark:text-slate-300">{{ $menfesses->currentPage() }}</span> 
                                dari <span class="font-bold text-slate-600 dark:text-slate-300">{{ $menfesses->lastPage() }}</span>
                            </div>

                            <div class="flex justify-center items-center gap-2 w-full px-2">
                                @if ($menfesses->onFirstPage())
                                    <span class="px-4 py-2 text-slate-300 dark:text-slate-600 bg-white dark:bg-slate-800 border border-slate-100 dark:border-slate-700 rounded-xl cursor-not-allowed text-xs font-bold flex items-center gap-1 transition-colors shadow-sm">
                                        <span>←</span> Prev
                                    </span>
                                @else
                                    <a href="{{ $menfesses->previousPageUrl() }}" rel="prev" class="px-4 py-2 text-indigo-600 dark:text-indigo-400 bg-white dark:bg-slate-800 border border-indigo-100 dark:border-slate-700 rounded-xl hover:bg-indigo-50 dark:hover:bg-slate-700 hover:border-indigo-200 transition-all duration-200 text-xs font-bold flex items-center gap-1 group shadow-sm hover:shadow">
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

                                        <div class="{{ $isVisible ? 'flex' : 'hidden' }}">
                                            @if ($page == $menfesses->currentPage())
                                                <span class="w-9 h-9 flex items-center justify-center bg-indigo-600 dark:bg-indigo-500 text-white rounded-xl text-xs font-bold shadow-md transform scale-105 ring-2 ring-indigo-100 dark:ring-slate-700 ring-offset-1 dark:ring-offset-slate-800 transition-all">
                                                    {{ $page }}
                                                </span>
                                            @else
                                                <a href="{{ $url }}" class="w-9 h-9 flex items-center justify-center text-slate-500 dark:text-slate-400 bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl hover:bg-slate-50 dark:hover:bg-slate-700 hover:text-indigo-600 dark:hover:text-indigo-400 hover:border-indigo-200 transition-all duration-200 text-xs font-semibold shadow-sm hover:shadow cursor-pointer block">
                                                    {{ $page }}
                                                </a>
                                            @endif
                                        </div>
                                    @endforeach
                                </div>

                                @if ($menfesses->hasMorePages())
                                    <a href="{{ $menfesses->nextPageUrl() }}" rel="next" class="px-4 py-2 text-indigo-600 dark:text-indigo-400 bg-white dark:bg-slate-800 border border-indigo-100 dark:border-slate-700 rounded-xl hover:bg-indigo-50 dark:hover:bg-slate-700 hover:border-indigo-200 transition-all duration-200 text-xs font-bold flex items-center gap-1 group shadow-sm hover:shadow">
                                        Next <span class="group-hover:translate-x-0.5 transition-transform">→</span>
                                    </a>
                                @else
                                    <span class="px-4 py-2 text-slate-300 dark:text-slate-600 bg-white dark:bg-slate-800 border border-slate-100 dark:border-slate-700 rounded-xl cursor-not-allowed text-xs font-bold flex items-center gap-1 transition-colors shadow-sm">
                                        Next <span>→</span>
                                    </span>
                                @endif
                            </div>
                        </nav>
                    @endif
                </div>
            </div>
        </div>
    </div>

    {{-- Script --}}
    <script>
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

        const menuBtn = document.getElementById('menu-btn');
        const mobileMenu = document.getElementById('mobile-menu');
        const mainHeader = document.getElementById('main-header'); 
        
        // Ikon hamburger & close
        const iconMenuOpen = document.getElementById('icon-menu-open');
        const iconMenuClose = document.getElementById('icon-menu-close');

        menuBtn.addEventListener('click', () => {
            mobileMenu.classList.toggle('hidden');
            
            // Toggle ikon hamburger / silang dengan efek opacity
            if (mobileMenu.classList.contains('hidden')) {
                iconMenuOpen.classList.remove('opacity-0');
                iconMenuOpen.classList.add('opacity-100');
                iconMenuClose.classList.remove('opacity-100', 'pointer-events-auto');
                iconMenuClose.classList.add('opacity-0', 'pointer-events-none');
                
                mainHeader.classList.remove('z-50');
                mainHeader.classList.add('z-10');
            } else {
                iconMenuOpen.classList.remove('opacity-100');
                iconMenuOpen.classList.add('opacity-0');
                iconMenuClose.classList.remove('opacity-0', 'pointer-events-none');
                iconMenuClose.classList.add('opacity-100', 'pointer-events-auto');
                
                mainHeader.classList.remove('z-10');
                mainHeader.classList.add('z-50');
            }
        });
    </script>
</body>
</html>