<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    // Tampilkan halaman login
    public function showLogin()
    {
        return view('auth.login');
    }

    // Tampilkan halaman register
    public function showRegister()
    {
        return view('auth.register');
    }

    // Proses Register
    public function register(Request $request)
    {
        $request->validate([
            // Validasi kunci: harus berakhiran @menfess.com
            'email' => ['required', 'email', 'unique:users', 'ends_with:@menfess.com'],
            'password' => 'required|min:4|confirmed'
        ], [
            'email.ends_with' => 'Email wajib menggunakan domain @menfess.com',
            'email.unique' => 'Email ini sudah terdaftar.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.'
        ]);

        // Ambil username dari email (misal: budi@menfess.com -> budi)
        $username = explode('@', $request->email)[0];

        User::create([
            'name' => $username,
            'email' => $request->email,
            'password' => Hash::make($request->password)
        ]);

        // Auto login setelah daftar
        if (Auth::attempt($request->only('email', 'password'))) {
            return redirect()->route('home')->with('success', 'Selamat datang, ' . $username . '!');
        }

        return redirect()->route('login');
    }

    // Proses Login
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email', 'ends_with:@menfess.com'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->route('home');
        }

        return back()->withErrors([
            'email' => 'Email atau password salah.',
        ])->onlyInput('email');
    }

    // Proses Logout
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login');
    }
}