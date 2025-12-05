<?php

namespace App\Http\Controllers;

use App\Models\Menfess;
use Illuminate\Http\Request;

class MenfessController extends Controller
{
    // 1. Halaman Depan (Public) - Cuma tampilkan yang sudah APPROVED
    public function index(Request $request)
    {
        $query = Menfess::where('status', 'approved');

        // Jika ada input pencarian
        if ($request->has('search')) {
            $query->where(function($q) use ($request) {
                $q->where('message', 'like', '%' . $request->search . '%')
                ->orWhere('recipient', 'like', '%' . $request->search . '%');
            });
        }

        // Jika ada filter tag
        if ($request->has('tag')) {
            $query->where('tag', $request->tag);
        }

        $menfesses = $query->latest()->paginate(10);
        
        return view('welcome', compact('menfesses'));
    }

    // 2. Proses Simpan Pesan
    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'message' => 'required|max:500', // Jangan terlalu panjang
            'tag' => 'required',
        ]);

        Menfess::create([
            'recipient' => $request->recipient ?? 'Anonim', // Jika kosong, set Anonim
            'message' => $request->message,
            'tag' => $request->tag,
            'status' => 'pending', // Default pending (wajib moderasi)
            'ip_address' => $request->ip() // Simpan IP untuk cegah spam
        ]);

        return back()->with('success', 'Pesan berhasil dikirim! Menunggu persetujuan admin.');
    }

    // 3. Halaman Admin - Tampilkan yang PENDING
    public function admin()
    {
        $pendingMessages = Menfess::where('status', 'pending')->latest()->get();
        return view('admin', compact('pendingMessages'));
    }

    // 4. Aksi Approve (Setujui)
    public function approve($id)
    {
        $menfess = Menfess::findOrFail($id);
        $menfess->update(['status' => 'approved']);
        return back()->with('success', 'Pesan disetujui & tayang.');
    }

    // 5. Aksi Reject (Hapus)
    public function reject($id)
    {
        $menfess = Menfess::findOrFail($id);
        $menfess->delete();
        return back()->with('error', 'Pesan dihapus.');
    }

    public function like($id)
    {
        $menfess = Menfess::findOrFail($id);
        $menfess->increment('likes'); // Otomatis nambah +1
        return back(); // Kembali ke halaman sebelumnya (reload)
    }
}