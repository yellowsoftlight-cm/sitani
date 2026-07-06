<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminAuthController extends Controller
{
    /**
     * Tampilkan form login khusus Admin.
     * Halaman ini sengaja TIDAK ditautkan di navbar/footer/halaman publik mana pun,
     * sehingga hanya bisa diakses oleh orang yang mengetahui URL-nya secara langsung.
     */
    public function showLogin()
    {
        return view('auth.admin-login');
    }

    /**
     * Proses login khusus Admin.
     * Berbeda dari login publik: endpoint ini menolak akun dengan role
     * selain Admin, sehingga jalur ini murni untuk pengelola sistem.
     */
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (! Auth::attempt($credentials)) {
            return back()
                ->withErrors(['email' => 'Email atau kata sandi salah.'])
                ->onlyInput('email');
        }

        if (Auth::user()->role !== 'Admin') {
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return back()->withErrors(['email' => 'Akun ini tidak memiliki akses admin.']);
        }

        $request->session()->regenerate();

        return redirect()->route('admin.dashboard');
    }
}
