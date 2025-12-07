<?php

namespace App\Http\Controllers;

use App\Models\Menfess;
use App\Models\MenfessLike;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MenfessController extends Controller
{
    public function index(Request $request)
    {
        $query = Menfess::with('user')->where('status', 'approved');

        // Fitur Pencarian
        if ($request->has('search')) {
            $query->where(function($q) use ($request) {
                $q->where('message', 'like', '%' . $request->search . '%')
                  ->orWhere('recipient', 'like', '%' . $request->search . '%');
            });
        }

        // Fitur Filter Tag
        if ($request->has('tag')) {
            $query->where('tag', $request->tag);
        }

        // Fitur Sorting
        $sort = $request->get('sort', 'latest'); // Default 'latest'
        
        switch ($sort) {
            case 'oldest':
                $query->oldest(); // Urutkan terlama (ASC)
                break;
            case 'popular':
                $query->orderByDesc('likes'); // Urutkan like terbanyak
                break;
            case 'latest':
            default:
                $query->latest(); // Urutkan terbaru (DESC)
                break;
        }

        $menfesses = $query->paginate(10);

        // Ambil daftar ID pesan yang sudah di-like user login
        $likedMenfessIds = [];
        if (Auth::check()) {
            $likedMenfessIds = MenfessLike::where('user_id', Auth::id())
                                          ->pluck('menfess_id')
                                          ->toArray();
        }
        
        return view('welcome', compact('menfesses', 'likedMenfessIds'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'message' => 'required|max:500',
            'tag' => 'required',
        ]);

        Menfess::create([
            'user_id' => Auth::id(), // Simpan ID user yang sedang login
            'recipient' => $request->recipient ?? 'Anonim',
            'message' => $request->message,
            'tag' => $request->tag,
            'status' => 'pending'
        ]);

        return back()->with('success', 'Pesan terkirim! Menunggu moderasi.');
    }

    public function like($id)
    {
        $menfess = Menfess::findOrFail($id);
        $userId = Auth::id();

        // Cek apakah user sudah pernah like pesan ini?
        $existingLike = MenfessLike::where('menfess_id', $id)
                                   ->where('user_id', $userId)
                                   ->first();

        if ($existingLike) {
            // Jika sudah -> UNLIKE (Hapus data like & kurangi counter)
            $existingLike->delete();
            $menfess->decrement('likes');
        } else {
            // Jika belum -> LIKE (Buat data like & tambah counter)
            MenfessLike::create([
                'menfess_id' => $id,
                'user_id' => $userId
            ]);
            $menfess->increment('likes');
        }

        return back();
    }

    // --- FITUR ADMIN ---
    
    public function admin()
    {
        $pendingMessages = Menfess::where('status', 'pending')->latest()->get();
        return view('admin', compact('pendingMessages'));
    }

    public function approve($id)
    {
        $menfess = Menfess::findOrFail($id);
        $menfess->update(['status' => 'approved']);
        return back()->with('success', 'Pesan disetujui.');
    }

    public function reject($id)
    {
        $menfess = Menfess::findOrFail($id);
        $menfess->delete();
        return back()->with('error', 'Pesan dihapus.');
    }
}