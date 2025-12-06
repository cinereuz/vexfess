<!DOCTYPE html>
<html lang="id">
<head>
    <title>Admin Dashboard - VEXFESS</title>
    @vite('resources/css/app.css')
</head>
<body class="bg-slate-100 font-sans min-h-screen">
    
    <div class="max-w-2xl mx-auto p-4">
        
        {{-- Header Admin --}}
        <div class="bg-white rounded-2xl shadow-sm p-6 mb-6 flex justify-between items-center border border-slate-200">
            <div>
                <h1 class="text-2xl font-bold text-slate-800">🛡️ Moderasi Pesan</h1>
                <p class="text-slate-500 text-sm mt-1">Review pesan sebelum tayang ke publik.</p>
            </div>
            <a href="{{ route('home') }}" class="bg-slate-100 text-slate-600 px-4 py-2 rounded-lg text-sm font-bold hover:bg-slate-200 transition">
                ← Kembali ke Home
            </a>
        </div>

        {{-- Flash Messages --}}
        @if(session('success'))
            <div class="bg-green-100 border border-green-200 text-green-800 p-4 rounded-xl mb-6 flex items-center gap-2">
                <span>✅</span> {{ session('success') }}
            </div>
        @endif
        @if(session('error'))
            <div class="bg-red-100 border border-red-200 text-red-800 p-4 rounded-xl mb-6 flex items-center gap-2">
                <span>❌</span> {{ session('error') }}
            </div>
        @endif

        {{-- List Pesan Pending --}}
        @if($pendingMessages->isEmpty())
            <div class="flex flex-col items-center justify-center bg-white rounded-2xl p-12 shadow-sm border border-dashed border-slate-300 text-center">
                <div class="text-4xl mb-4">🎉</div>
                <h3 class="text-lg font-bold text-slate-700">Semua Bersih!</h3>
                <p class="text-slate-400 text-sm">Tidak ada pesan baru yang perlu dimoderasi saat ini.</p>
            </div>
        @else
            <div class="space-y-4">
                @foreach($pendingMessages as $msg)
                <div class="bg-white p-5 rounded-2xl shadow-sm border border-slate-200 hover:shadow-md transition relative overflow-hidden">
                    {{-- Status Indicator --}}
                    <div class="absolute top-0 left-0 w-1 h-full bg-yellow-400"></div>

                    <div class="flex justify-between items-start mb-3 pl-2">
                        <div class="flex items-center gap-2">
                            <span class="bg-slate-100 text-slate-600 text-xs font-bold px-2 py-1 rounded-md border border-slate-200">
                                {{ $msg->tag }}
                            </span>
                            <span class="text-xs text-slate-400 font-mono bg-slate-50 px-2 py-1 rounded">
                                IP: {{ $msg->ip_address ?? 'Hidden' }}
                            </span>
                        </div>
                        <span class="text-[10px] text-slate-400">{{ $msg->created_at->diffForHumans() }}</span>
                    </div>

                    <div class="pl-2 mb-4">
                        <p class="text-xs font-bold text-slate-500 uppercase tracking-wide mb-1">To: {{ $msg->recipient }}</p>
                        <p class="text-slate-800 text-base leading-relaxed bg-yellow-50 p-3 rounded-lg border border-yellow-100">
                            "{{ $msg->message }}"
                        </p>
                        <p class="text-xs text-slate-400 mt-2">From User: <span class="font-semibold text-slate-600">{{ $msg->user->name ?? 'Unknown' }}</span></p>
                    </div>
                    
                    {{-- Action Buttons --}}
                    <div class="flex gap-3 pl-2 border-t pt-4 border-slate-100">
                        <form action="{{ route('admin.approve', $msg->id) }}" method="POST" class="flex-1">
                            @csrf @method('PATCH')
                            <button class="w-full bg-green-500 hover:bg-green-600 text-white font-bold py-2 px-4 rounded-lg text-sm transition flex items-center justify-center gap-2">
                                <span>✅</span> Setujui & Tayang
                            </button>
                        </form>
                        <form action="{{ route('admin.reject', $msg->id) }}" method="POST" class="flex-1">
                            @csrf @method('DELETE')
                            <button class="w-full bg-red-50 text-red-600 hover:bg-red-100 font-bold py-2 px-4 rounded-lg text-sm transition border border-red-100 flex items-center justify-center gap-2">
                                <span>🗑️</span> Tolak & Hapus
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