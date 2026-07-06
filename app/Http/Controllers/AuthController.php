<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Services\NotifikasiService;
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
            // PENTING: akun berrole Admin sengaja TIDAK boleh masuk lewat
            // form login publik ini. Panel admin hanya dapat diakses lewat
            // jalur login khusus yang tidak ditautkan di halaman manapun,
            // sehingga hanya admin yang mengetahui URL-nya yang bisa login.
            if (Auth::user()->role === 'Admin') {
                Auth::logout();
                $request->session()->invalidate();
                $request->session()->regenerateToken();

                return back()->withErrors([
                    'email' => 'Akun ini tidak dapat masuk melalui halaman ini.',
                ]);
            }

            $request->session()->regenerate();

            // PENTING: redirect selalu berdasarkan role pengguna yang login,
            // bukan redirect()->intended(), karena intended() bisa mengarahkan
            // ke URL panel lain yang sempat dicoba diakses sebelumnya (mis. akun
            // Petani yang tadinya mencoba membuka /pengurus/dashboard tanpa izin),
            // sehingga panel yang terbuka tidak sinkron dengan role akun tersebut.
            $role = Auth::user()->role;

            return match ($role) {
                'Pengurus' => redirect('/pengurus/dashboard'),
                default => redirect('/petani/dashboard'),
            };
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

        if ($request->role === 'Petani') {
            NotifikasiService::kirimKeRole(
                'Pengurus',
                'anggota_baru',
                'Anggota baru mendaftar',
                "{$request->name} mendaftar sebagai anggota Petani baru.",
            );
        }

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