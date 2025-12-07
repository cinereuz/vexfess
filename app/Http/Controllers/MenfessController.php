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
        $sort = $request->get('sort', 'latest'); 
        
        switch ($sort) {
            case 'oldest':
                $query->oldest();
                break;
            case 'popular':
                $query->orderByDesc('likes');
                break;
            case 'latest':
            default:
                $query->latest();
                break;
        }

        // Paginasi 3 item per halaman
        $menfesses = $query->paginate(3);

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

        // LOGIKA BARU: Cek apakah pengirim adalah Admin
        $isAdmin = Auth::user()->is_admin;
        
        // Jika Admin -> Langsung 'approved', Jika User Biasa -> 'pending'
        $status = $isAdmin ? 'approved' : 'pending';

        Menfess::create([
            'user_id' => Auth::id(),
            'recipient' => $request->recipient ?? 'Anonim',
            'message' => $request->message,
            'tag' => $request->tag,
            'status' => $status
        ]);

        // Pesan notifikasi yang berbeda
        $notificationMessage = $isAdmin 
            ? 'Pesan admin berhasil diposting!' 
            : 'Pesan terkirim! Menunggu moderasi.';

        return back()->with('success', $notificationMessage);
    }

    public function like($id)
    {
        $menfess = Menfess::findOrFail($id);
        $userId = Auth::id();

        $existingLike = MenfessLike::where('menfess_id', $id)
                                   ->where('user_id', $userId)
                                   ->first();

        if ($existingLike) {
            $existingLike->delete();
            $menfess->decrement('likes');
        } else {
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