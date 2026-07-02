<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    // Tampilkan Form Login
    public function showLogin() {
        return view('auth.login');
    }

    // Proses Login
    public function login(Request $request) {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            
            // Redirect sesuai role masing-masing aktor
            $role = Auth::user()->role;
            if ($role === 'Admin') return redirect()->intended('/admin/dashboard');
            if ($role === 'Pengurus') return redirect()->intended('/pengurus/dashboard');
            return redirect()->intended('/petani/dashboard');
        }

        return back()->withErrors(['email' => 'Email atau password salah.']);
    }

    // Tampilkan Form Register
    public function showRegister() {
        return view('auth.register');
    }

    // Proses Register
    public function register(Request $request) {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
            'role' => 'required|in:Petani,Pengurus'
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
        ]);

        return redirect()->route('login')->with('success', 'Pendaftaran berhasil! Silakan login.');
    }

    // Proses Logout
    public function logout(Request $request) {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
}