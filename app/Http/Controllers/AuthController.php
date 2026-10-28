<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AuthController extends Controller
{
    // Menampilkan halaman login
    public function showLogin()
    {
        return view('auth.login'); // Nanti kamu buat view-nya sendiri
    }

    // Proses login
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            $role = Auth::user()->role;

            // Redirect berdasarkan role
        if ($role === 'admin') return redirect()->route('admin.dashboard');
        if ($role === 'teknisi') return redirect()->route('teknisi.dashboard');
        return redirect()->route('pelanggan.dashboard');
        }

        return back()->withErrors(['email' => 'Kredensial yang diberikan tidak cocok dengan data kami.']);
    }

    // Menampilkan halaman registrasi (khusus pelanggan)
    public function showRegister()
    {
        return view('auth.register'); 
    }

    // Proses registrasi
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'no_telp' => 'required|string|max:15',
            'alamat' => 'nullable|string',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'pelanggan', // Default role untuk register publik
            'no_telp' => $request->no_telp,
            'alamat' => $request->alamat,
        ]);

        Auth::login($user);
        return redirect()->route('pelanggan.dashboard');
    }

    // Proses logout
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
}