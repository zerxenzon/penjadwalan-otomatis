<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu.');
        }

        $user = Auth::user();
        if (!$user) {
            return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu.');
        }

        $userRole = $user->role?->nama;
        if (!$userRole) {
            return redirect()->route('login')->with('error', 'Role tidak ditemukan untuk user ini.');
        }

        // Check if the user's role is in the allowed roles array
        if (!in_array($userRole, $roles)) {
            // If user has dosen role and tries to access a route, redirect to dosen dashboard
            if ($userRole === 'dosen') {
                return redirect()->route('dashboard.dosen')
                    ->with('error', 'Anda tidak memiliki akses ke halaman tersebut.');
            }
            
            // For other roles, redirect to their respective dashboards
            if (Route::has("dashboard.$userRole")) {
                return redirect()->route("dashboard.$userRole")
                    ->with('error', 'Anda tidak memiliki akses ke halaman tersebut.');
            }
            
            // Fallback if no dashboard route exists
            abort(403, 'Anda tidak memiliki akses ke halaman ini.');
        }

        return $next($request);
    }
}
