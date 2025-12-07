<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Pagination\Paginator;
use Illuminate\Pagination\LengthAwarePaginator;
use App\Models\User;

class ProfileController extends Controller
{
    public function edit(Request $request)
    {
        // Daftar 36 pilihan avatar standar
        $allAvatars = [
            'Felix', 'Aneka', 'Zoe', 'Midnight', 
            'Luna', 'Max', 'Oliver', 'Bella',
            'Leo', 'Milo', 'Shadow', 'Jasper',
            'Abby', 'Coco', 'Daisy', 'Jack',
            'Loki', 'Misty', 'Oscar', 'Rocky',
            'Simba', 'Toby', 'Ginger', 'Peanut',
            'Sasha', 'Bear', 'Teddy', 'Rusty',
            'Kali', 'Rex', 'Bandit', 'Willow',
            'Buster', 'Gizmo', 'Harley', 'Nala'
        ];

        // LOGIKA ADMIN: Tambahkan avatar spesial
        if (Auth::user()->is_admin) {
            array_unshift($allAvatars, 'King Admin', 'Admin Magang', 'Atmint', 'Rahasia');
        }

        // --- LOGIKA PAGINASI ---
        // KEMBALIKAN KE 10 ITEM PER HALAMAN (Mobile & Desktop Sama)
        $perPage = 10; 
        
        $currentPage = Paginator::resolveCurrentPage('page');
        $currentItems = array_slice($allAvatars, ($currentPage - 1) * $perPage, $perPage);
        
        $avatars = new LengthAwarePaginator(
            $currentItems, 
            count($allAvatars), 
            $perPage, 
            $currentPage, 
            [
                'path' => $request->url(), 
                'query' => $request->query() 
            ]
        );
        
        return view('profile', compact('avatars'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'avatar' => 'required|string',
        ]);

        /** @var User $user */
        $user = Auth::user(); 

        if (!Auth::user()->is_admin && $request->avatar === 'AdminKing') {
            return back()->with('error', 'Avatar tersebut khusus untuk Admin!');
        }

        $user->avatar = $request->avatar;
        $user->save(); 

        return back()->with('success', 'Avatar berhasil diganti!');
    }
}