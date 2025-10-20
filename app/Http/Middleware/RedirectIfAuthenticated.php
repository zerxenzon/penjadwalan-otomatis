<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Symfony\Component\HttpFoundation\Response;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string  ...$guards
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function handle(Request $request, Closure $next, string ...$guards): Response
    {
        $guards = empty($guards) ? [null] : $guards;

        foreach ($guards as $guard) {
            if (Auth::guard($guard)->check()) {
                return $this->redirectToDashboard();
            }
        }

        return $next($request);
    }

    /**
     * Redirect the user to their appropriate dashboard based on role.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    protected function redirectToDashboard(): \Illuminate\Http\RedirectResponse
    {
        $user = Auth::user();
        if (!$user) {
            Auth::logout();
            return redirect()->route('login');
        }

        $roleName = $user->role?->nama;
        if (!$roleName) {
            Auth::logout();
            return redirect()->route('login')->with('error', 'Role tidak ditemukan');
        }

        // For dosen role and those who can access dosen dashboard
        if (in_array($roleName, ['dosen', 'kaprodi', 'dekan'])) {
            return redirect()->route('dashboard.dosen');
        }
        
        // For other roles with their own dashboard
        if (Route::has("dashboard.$roleName")) {
            return redirect()->route("dashboard.$roleName");
        }
        
        // If no matching dashboard found, logout and redirect with error
        Auth::logout();
        return redirect()->route('login')->with('error', 'Role tidak ditemukan');
    }
}
