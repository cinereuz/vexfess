<!DOCTYPE html>
<html lang="id">
<head>
    <title>Admin Dashboard</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite('resources/css/app.css')
</head>
<body class="bg-gray-100 p-4 sm:p-5 min-h-screen">
    <div class="max-w-2xl mx-auto">
        
        {{-- Header dengan Tombol Kembali --}}
        <div class="flex flex-col sm:flex-row justify-between items-center mb-6 gap-4">
            <h1 class="text-xl sm:text-2xl font-bold text-gray-800 flex items-center gap-2">
                🛡️ <span class="hidden sm:inline">Admin</span> Moderasi
            </h1>
            <a href="{{ route('home') }}" class="bg-slate-600 hover:bg-slate-700 text-white text-xs sm:text-sm px-4 py-2 rounded-full transition flex items-center gap-2 shadow-md w-full sm:w-auto justify-center">
                <span>⬅️</span> Kembali ke Home
            </a>
        </div>
        
        @if(session('success')) <div class="bg-green-100 text-green-800 p-3 mb-4 rounded-lg text-sm border border-green-200 font-medium">{{ session('success') }}</div> @endif
        @if(session('error')) <div class="bg-red-100 text-red-800 p-3 mb-4 rounded-lg text-sm border border-red-200 font-medium">{{ session('error') }}</div> @endif

        @if($pendingMessages->isEmpty())
            <div class="bg-white p-10 rounded-xl shadow-sm text-center text-gray-500 border border-gray-100">
                <p class="text-4xl mb-2">🎉</p>
                <p>Tidak ada pesan baru yang perlu dimoderasi.</p>
            </div>
        @else
            <div class="space-y-4">
                @foreach($pendingMessages as $msg)
                <div class="bg-white p-4 sm:p-5 rounded-xl shadow-sm border-l-4 border-yellow-400 relative">
                    <div class="flex justify-between text-[10px] sm:text-xs text-gray-400 mb-2 font-mono">
                        <span class="bg-gray-100 px-2 py-1 rounded">#{{ $msg->tag }}</span>
                        <span>{{ $msg->created_at->diffForHumans() }}</span>
                    </div>
                    
                    <div class="mb-3">
                        <p class="text-xs font-bold text-gray-500 uppercase tracking-wide">To: {{ $msg->recipient }}</p>
                        <p class="text-xs text-gray-400">From: {{ $msg->user->name ?? 'Anonim' }}</p>
                    </div>

                    <p class="mb-4 text-gray-800 bg-gray-50 p-3 rounded-lg text-sm leading-relaxed border border-gray-100">
                        {{ $msg->message }}
                    </p>
                    
                    <div class="flex gap-2 border-t pt-3 border-dashed border-gray-200">
                        <form action="{{ route('admin.approve', $msg->id) }}" method="POST" class="flex-1">
                            @csrf @method('PATCH')
                            <button class="w-full bg-green-500 text-white px-3 py-2 rounded-lg hover:bg-green-600 text-xs sm:text-sm font-bold transition shadow-sm flex justify-center items-center gap-1 active:scale-95">
                                ✅ <span class="hidden sm:inline">Setuju</span>
                            </button>
                        </form>
                        <form action="{{ route('admin.reject', $msg->id) }}" method="POST" class="flex-1">
                            @csrf @method('DELETE')
                            <button class="w-full bg-red-500 text-white px-3 py-2 rounded-lg hover:bg-red-600 text-xs sm:text-sm font-bold transition shadow-sm flex justify-center items-center gap-1 active:scale-95">
                                ❌ <span class="hidden sm:inline">Tolak</span>
                            </button>
                        </form>
                    </div>
                </div>
                @endforeach
            </div>
        @endif
    </div>
</body>
</html>