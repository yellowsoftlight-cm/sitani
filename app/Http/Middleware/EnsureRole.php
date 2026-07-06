<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureRole
{
    /**
     * Pastikan user yang login memiliki role yang sesuai untuk mengakses panel ini.
     * Jika role tidak cocok, user akan diarahkan otomatis ke dashboard sesuai rolenya
     * sendiri, alih-alih melihat halaman terlarang.
     */
    public function handle(Request $request, Closure $next, string ...$roles): Response
    {
        $user = $request->user();

        if ($user && ! in_array($user->role, $roles, true)) {
            return redirect()->to($this->dashboardFor($user->role))
                ->with('error', 'Anda tidak memiliki akses ke halaman tersebut.');
        }

        return $next($request);
    }

    /**
     * Tentukan URL dashboard yang tepat berdasarkan role user.
     */
    private function dashboardFor(string $role): string
    {
        return match ($role) {
            'Admin' => '/admin/dashboard',
            'Pengurus' => '/pengurus/dashboard',
            default => '/petani/dashboard',
        };
    }
}
