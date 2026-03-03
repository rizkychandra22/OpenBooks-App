<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, $role): Response
    {
        if (!Auth::check()) {
            return redirect()->route('login')->withErrors([
                'loginAkses' => 'Perlu akses login untuk halaman tersebut.'
            ]);
        }

        $user = Auth::user();
        
        // Hanya izinkan 1 pengecekan role login 
        if ($user->role === $role) {
            return $next($request);
        }

        // Izinkan pengecekan role login lebih dari 1
        // $allRole = explode('|', $role);
        // if(in_array($user->role, $allRole))
        // {
        //     return $next($request);
        // }
        
        Auth::logout();
        return redirect()
            ->route('login')->withErrors([
                'loginAkses' => 'Anda tidak punya akses halaman tersebut.'
            ]);
    }
}
