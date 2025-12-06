<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function edit()
    {
        // Daftar pilihan avatar (Seed Dicebear)
        $avatars = [
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
        
        return view('profile', compact('avatars'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'avatar' => 'required|string',
        ]);

        /** @var \App\Models\User $user */
        $user = Auth::user(); // Editor sekarang tau ini adalah Model User

        $user->avatar = $request->avatar;
        $user->save(); // Garis merah harusnya hilang

        return back()->with('success', 'Avatar berhasil diganti!');
    }
}