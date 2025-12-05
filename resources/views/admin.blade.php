<!DOCTYPE html>
<html lang="id">
<head>
    <title>Admin Dashboard</title>
    @vite('resources/css/app.css')
</head>
<body class="bg-gray-100 p-5">
    <div class="max-w-2xl mx-auto">
        <h1 class="text-2xl font-bold mb-5">🛡️ Admin Moderasi</h1>
        
        @if(session('success')) <div class="bg-green-200 text-green-800 p-2 mb-4 rounded">{{ session('success') }}</div> @endif
        @if(session('error')) <div class="bg-red-200 text-red-800 p-2 mb-4 rounded">{{ session('error') }}</div> @endif

        @if($pendingMessages->isEmpty())
            <div class="bg-white p-10 rounded shadow text-center text-gray-500">
                Tidak ada pesan baru yang perlu dimoderasi.
            </div>
        @else
            <div class="space-y-4">
                @foreach($pendingMessages as $msg)
                <div class="bg-white p-4 rounded shadow border-l-4 border-yellow-400">
                    <div class="flex justify-between text-xs text-gray-500 mb-2">
                        <span>Tag: {{ $msg->tag }}</span>
                        <span>IP: {{ $msg->ip_address }}</span>
                    </div>
                    <p class="font-bold text-sm text-gray-700 mb-1">To: {{ $msg->recipient }}</p>
                    <p class="mb-4 text-gray-900 bg-gray-50 p-2 rounded">{{ $msg->message }}</p>
                    
                    <div class="flex gap-2">
                        <form action="{{ route('admin.approve', $msg->id) }}" method="POST">
                            @csrf @method('PATCH')
                            <button class="bg-green-500 text-white px-4 py-1 rounded hover:bg-green-600 text-sm">✅ Approve</button>
                        </form>
                        <form action="{{ route('admin.reject', $msg->id) }}" method="POST">
                            @csrf @method('DELETE')
                            <button class="bg-red-500 text-white px-4 py-1 rounded hover:bg-red-600 text-sm">❌ Reject</button>
                        </form>
                    </div>
                </div>
                @endforeach
            </div>
        @endif
    </div>
</body>
</html>