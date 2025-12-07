<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menfess Angkatan</title>
    @vite('resources/css/app.css')
</head>
<body class="bg-slate-100 text-slate-800 font-sans">

    <div class="max-w-md mx-auto min-h-screen bg-white shadow-2xl relative">
        
        {{-- Header Baru --}}
        <div class="bg-indigo-600 p-5 text-white rounded-b-3xl shadow-lg relative z-10 flex justify-between items-start">
            <div>
                <h1 class="text-2xl font-bold tracking-tight">💬 VEXFESS</h1>
                <p class="text-indigo-200 text-xs mt-1 mb-3 ">Halo, {{ Auth::user()->name }} 👋</p>
            </div>

            <div class="flex gap-2 items-center">
                {{-- Tombol Edit Profile --}}
                <a href="{{ route('profile.edit') }}" class="bg-indigo-500 hover:bg-indigo-400 text-white text-[10px] px-3 py-1.5 rounded-full transition font-semibold border border-indigo-400 flex items-center shadow-sm">
                    👤 Profil
                </a>

                @if(Auth::user()->is_admin)
                    <a href="{{ route('admin.index') }}" class="bg-yellow-400 hover:bg-yellow-500 text-yellow-900 text-[10px] px-3 py-1.5 rounded-full transition font-bold shadow-sm flex items-center">
                        👑 Admin
                    </a>
                @endif

                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button class="bg-indigo-700 hover:bg-indigo-800 text-[10px] px-3 py-1.5 rounded-full transition font-semibold border border-indigo-500 shadow-sm">
                        Logout
                    </button>
                </form>
            </div>
        </div>

        {{-- Form Input --}}
        <div class="px-5 -mt-6 relative z-20">
            <div class="bg-white p-4 rounded-xl shadow-md border border-slate-100">
                <form action="{{ route('menfess.store') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label class="text-xs font-bold text-slate-500 uppercase">To:</label>
                        <input type="text" name="recipient" placeholder="Nama / Inisial (Opsional)" class="w-full border-b-2 border-slate-200 focus:border-indigo-500 outline-none py-1 text-sm">
                    </div>
                    
                    <div class="mb-3">
                        <textarea name="message" rows="3" placeholder="Tulis pesanmu disini..." required class="w-full bg-slate-50 rounded-lg p-2 text-sm outline-none focus:ring-2 focus:ring-indigo-200"></textarea>
                    </div>

                    <div class="flex justify-between items-center">
                        <select name="tag" class="text-xs bg-slate-100 border-none rounded-lg py-1 px-2">
                            <option value="Curhat">Curhat</option>
                            <option value="Spill">Spill</option>
                            <option value="Confess">Confess</option>
                            <option value="Random">Random</option>
                        </select>
                        <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white text-sm px-4 py-2 rounded-full font-bold transition shadow-lg shadow-indigo-200">
                            Kirim 🚀
                        </button>
                    </div>
                </form>
            </div>
            
            @if(session('success'))
                <div class="mt-4 bg-green-100 text-green-700 p-3 rounded-lg text-xs font-bold text-center border border-green-200">
                    {{ session('success') }}
                </div>
            @endif
        </div>

        {{-- Search & Sort Bar --}}
        <div class="px-5 mt-4 mb-2">
            <form action="{{ route('home') }}" method="GET" class="flex flex-col gap-3">
                
                {{-- Search Input --}}
                <div class="relative">
                    <input type="text" name="search" value="{{ request('search') }}" 
                        placeholder="Cari..." 
                        class="w-full bg-slate-50 border border-slate-200 text-sm rounded-full px-4 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                    <button type="submit" class="absolute right-3 top-2.5 text-gray-400 hover:text-indigo-600">🔍</button>
                </div>

                {{-- Filter & Sort Options --}}
                <div class="flex justify-between items-center text-xs">
                    {{-- Tombol Sort --}}
                    <div class="flex bg-slate-100 p-1 rounded-lg">
                        <button type="submit" name="sort" value="latest" 
                            class="px-3 py-1 rounded-md transition {{ request('sort', 'latest') == 'latest' ? 'bg-white text-indigo-600 shadow-sm font-bold' : 'text-slate-500 hover:text-slate-700' }}">
                            Terbaru
                        </button>
                        <button type="submit" name="sort" value="oldest" 
                            class="px-3 py-1 rounded-md transition {{ request('sort') == 'oldest' ? 'bg-white text-indigo-600 shadow-sm font-bold' : 'text-slate-500 hover:text-slate-700' }}">
                            Terlama
                        </button>
                        <button type="submit" name="sort" value="popular" 
                            class="px-3 py-1 rounded-md transition {{ request('sort') == 'popular' ? 'bg-white text-indigo-600 shadow-sm font-bold' : 'text-slate-500 hover:text-slate-700' }}">
                            🔥 Populer
                        </button>
                    </div>

                    {{-- Pertahankan filter tag saat sorting --}}
                    @if(request('tag'))
                        <input type="hidden" name="tag" value="{{ request('tag') }}">
                        <span class="bg-indigo-100 text-indigo-600 px-2 py-1 rounded-md font-bold">
                            #{{ request('tag') }}
                            <a href="{{ route('home', ['sort' => request('sort')]) }}" class="ml-1 text-indigo-400 hover:text-indigo-700">✕</a>
                        </span>
                    @endif
                </div>

                @if(request('search'))
                    <div class="text-center mt-2 flex justify-center">
                        <a href="{{ route('home') }}" class="inline-flex items-center gap-1 bg-red-100 text-red-600 text-xs px-3 py-1.5 rounded-full font-bold hover:bg-red-200 transition shadow-sm border border-red-200">
                            <span>✕</span> Reset Pencarian
                        </a>
                    </div>
                @endif
            </form>
        </div>

        {{-- Feed Pesan --}}
        <div class="p-5 pb-20 space-y-4">
            <h3 class="text-slate-400 text-xs font-bold uppercase tracking-wider">
                @if(request('sort') == 'popular')
                    Timeline Terpopuler 🔥
                @elseif(request('sort') == 'oldest')
                    Timeline Terlama ⏳
                @else
                    Timeline Terbaru 🕒
                @endif
            </h3>
            
            @foreach($menfesses as $item)
            <div class="border p-4 rounded-xl shadow-sm hover:shadow-md transition bg-white relative">
                
                {{-- Header Card: Avatar + Info --}}
                <div class="flex items-start gap-3 mb-3">
                    {{-- Avatar Logic --}}
                    <img src="https://api.dicebear.com/9.x/lorelei-neutral/svg?seed={{ $item->user->avatar ?? $item->user->name }}" 
                         alt="avatar" 
                         class="w-10 h-10 rounded-full bg-indigo-50 border border-indigo-100 p-0.5 object-cover">
                    
                    <div class="flex-1">
                        <div class="flex justify-between items-start">
                            <span class="text-sm font-bold text-gray-800">{{ $item->user->name }}</span>
                            <span class="text-[10px] text-slate-400">{{ $item->created_at->diffForHumans() }}</span>
                        </div>
                        <p class="text-xs font-bold text-slate-500 mt-0.5">To: {{ $item->recipient }}</p>
                    </div>
                </div>

                {{-- Isi Pesan --}}
                <p class="text-sm text-slate-800 leading-relaxed mb-3 pl-[3.25rem]">
                    {{ $item->message }}
                </p>

                {{-- Footer: Tombol Like --}}
                <div class="flex justify-end items-center border-t pt-2 mt-2 border-dashed border-gray-100">
                    <form action="{{ route('menfess.like', $item->id) }}" method="POST">
                        @csrf
                        @php
                            $isLiked = in_array($item->id, $likedMenfessIds ?? []);
                        @endphp

                        <button type="submit" class="flex items-center text-xs transition group {{ $isLiked ? 'text-red-500' : 'text-gray-400 hover:text-red-400' }}">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="{{ $isLiked ? 'currentColor' : 'none' }}" stroke="currentColor" stroke-width="2" class="w-5 h-5 group-hover:scale-110 transition transform duration-200">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12z" />
                            </svg>
                            <span class="ml-1.5 font-bold">{{ $item->likes }}</span>
                        </button>
                    </form>
                </div>
            </div>
            @endforeach

            {{-- Custom Pagination Rapi --}}
            <div class="mt-6 pt-4 border-t border-slate-100">
                {{-- Penting: appends() agar filter tidak hilang --}}
                @php
                    $menfesses->appends(request()->query());
                @endphp
                
                @if ($menfesses->hasPages())
                    <nav role="navigation" aria-label="Pagination Navigation" class="flex flex-col items-center">
                        
                        {{-- Info Halaman (Showing X to Y of Z) --}}
                        <div class="mb-3 text-xs text-slate-400 text-center">
                            Menampilkan <span class="font-bold text-slate-600">{{ $menfesses->firstItem() }}</span> 
                            sampai <span class="font-bold text-slate-600">{{ $menfesses->lastItem() }}</span> 
                            dari <span class="font-bold text-slate-600">{{ $menfesses->total() }}</span> pesan
                        </div>

                        {{-- Controls Container --}}
                        <div class="flex justify-center items-center gap-1 w-full px-2">
                            
                            {{-- Previous Page Link --}}
                            @if ($menfesses->onFirstPage())
                                <span class="px-3 py-1.5 text-slate-300 bg-slate-50 border border-slate-200 rounded-md cursor-not-allowed text-xs font-bold text-center">
                                    ← Prev
                                </span>
                            @else
                                <a href="{{ $menfesses->previousPageUrl() }}" rel="prev" class="px-3 py-1.5 text-indigo-600 bg-white border border-indigo-200 rounded-md hover:bg-indigo-50 hover:border-indigo-300 transition text-xs font-bold shadow-sm text-center">
                                    ← Prev
                                </a>
                            @endif

                            {{-- Pagination Numbers (Logic windowing agar rapi di mobile) --}}
                            <div class="flex gap-1 px-1">
                                @php
                                    $currentPage = $menfesses->currentPage();
                                    $lastPage = $menfesses->lastPage();
                                    
                                    // Logika: Tampilkan 3 halaman di sekitar halaman aktif (biar ga kepanjangan di HP)
                                    $start = max(1, $currentPage - 1);
                                    $end = min($lastPage, $currentPage + 1);
                                    
                                    // Koreksi jika di ujung agar tetap minimal 3 item (jika ada)
                                    if ($lastPage >= 3) {
                                        if ($currentPage == 1) $end = 3;
                                        if ($currentPage == $lastPage) $start = $lastPage - 2;
                                    }
                                @endphp

                                @foreach ($menfesses->getUrlRange(1, $lastPage) as $page => $url)
                                    @php
                                        // Hanya tampilkan jika masuk range window
                                        $isVisible = ($page >= $start && $page <= $end);
                                    @endphp

                                    <div class="{{ $isVisible ? 'block' : 'hidden' }}">
                                        @if ($page == $menfesses->currentPage())
                                            <span class="w-8 h-8 flex items-center justify-center bg-indigo-600 text-white rounded-md text-xs font-bold shadow-md">
                                                {{ $page }}
                                            </span>
                                        @else
                                            <a href="{{ $url }}" class="w-8 h-8 flex items-center justify-center text-slate-500 bg-white border border-slate-200 rounded-md hover:bg-slate-50 hover:text-indigo-600 hover:border-indigo-200 transition text-xs font-semibold">
                                                {{ $page }}
                                            </a>
                                        @endif
                                    </div>
                                @endforeach
                            </div>

                            {{-- Next Page Link --}}
                            @if ($menfesses->hasMorePages())
                                <a href="{{ $menfesses->nextPageUrl() }}" rel="next" class="px-3 py-1.5 text-indigo-600 bg-white border border-indigo-200 rounded-md hover:bg-indigo-50 hover:border-indigo-300 transition text-xs font-bold shadow-sm text-center">
                                    Next →
                                </a>
                            @else
                                <span class="px-3 py-1.5 text-slate-300 bg-slate-50 border border-slate-200 rounded-md cursor-not-allowed text-xs font-bold text-center">
                                    Next →
                                </span>
                            @endif
                        </div>
                    </nav>
                @endif
            </div>
        </div>
    </div>
</body>
</html>