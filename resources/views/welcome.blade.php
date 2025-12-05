<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menfess Angkatan</title>
    @vite('resources/css/app.css') {{-- Load Tailwind --}}
</head>
<body class="bg-slate-100 text-slate-800 font-sans">

    {{-- Container Utama (Max lebar setara HP) --}}
    <div class="max-w-md mx-auto min-h-screen bg-white shadow-2xl relative">
        
        {{-- Header --}}
        <div class="bg-indigo-600 p-5 text-white text-center rounded-b-3xl shadow-lg">
            <h1 class="text-2xl font-bold tracking-tight">📢 VEXFESS</h1>
            <p class="text-indigo-200 text-sm mt-1 mb-3">test.</p>
        </div>

        {{-- Form Input --}}
        <div class="px-5 -mt-6">
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
            
            {{-- Flash Message --}}
            @if(session('success'))
                <div class="mt-4 bg-green-100 text-green-700 p-3 rounded-lg text-xs font-bold text-center border border-green-200">
                    {{ session('success') }}
                </div>
            @endif
        </div>
        {{-- Search Bar --}}
        <div class="px-5 mt-2 mb-2">
            <form action="{{ route('home') }}" method="GET">
                <div class="relative">
                    <input type="text" name="search" value="{{ request('search') }}" 
                        placeholder="Cari namamu atau isi pesan..." 
                        class="w-full bg-white border border-gray-200 text-sm rounded-full px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 shadow-sm">
                    <button type="submit" class="absolute right-3 top-2.5 text-gray-400 hover:text-blue-600">
                        🔍
                    </button>
                </div>
                {{-- Link Reset Filter --}}
                @if(request('search') || request('tag'))
                    <div class="text-center mt-2">
                        <a href="{{ route('home') }}" class="text-xs text-red-500 underline">Reset Pencarian</a>
                    </div>
                @endif
            </form>
        </div>

        {{-- Feed Pesan --}}
        <div class="p-5 pb-20 space-y-4">
            <h3 class="text-slate-400 text-xs font-bold uppercase tracking-wider">Timeline Terbaru</h3>
            
            @foreach($menfesses as $item)
            <div class="border p-4 rounded-xl shadow-sm hover:shadow-md transition bg-white relative">
                <div class="flex justify-between items-start mb-2">
                    <span class="bg-indigo-50 text-indigo-600 text-[10px] font-bold px-2 py-1 rounded-full uppercase tracking-wide">{{ $item->tag }}</span>
                    <span class="text-[10px] text-slate-400">{{ $item->created_at->diffForHumans() }}</span>
                </div>
                <p class="text-xs font-bold text-gray-500">To: {{ $item->recipient }}</p>
                <p class="text-sm mt-1 mb-3">{{ $item->message }}</p>
                <div class="flex justify-end items-center border-t pt-2 mt-2 border-dashed border-gray-100">
                    <form action="{{ route('menfess.like', $item->id) }}" method="POST">
                        @csrf
                        <button type="submit" class="flex items-center text-xs text-gray-400 hover:text-red-500 transition group">
                            <span class="group-hover:scale-125 transition transform duration-200">❤️</span>
                            <span class="ml-1 font-bold">{{ $item->likes }}</span>
                        </button>
                    </form>
                </div>
            </div>
            @endforeach

            {{-- Pagination --}}
            <div class="mt-4">
                {{ $menfesses->links() }}
            </div>
        </div>
    </div>
</body>
</html>