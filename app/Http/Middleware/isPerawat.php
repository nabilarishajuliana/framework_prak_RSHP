<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class isPerawat
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
          if (!Auth::check()) {
            return redirect()->route("login");




            /** @var \App\Models\User $user */
            // $user = Auth::user();

            // // Cek apakah user punya role 'Administrator' yang aktif (status = 1)
            // if ($user->roles()
            //     ->wherePivot('status', 1)
            //     ->whereHas('role', fn($q) => $q->where('nama_role', 'Administrator'))
            //     ->exists()
            // ) {
            //     return $next($request);
            // }
        }
        $userRole = session('user_role');

        if ($userRole === 3) {
            return $next($request);
        } else {
            return back()->with(403, 'Access denied. Only Administrator can access this page.');
            // abort(403, message: 'Access denied. Only Administrator can access this page.');

        }
    }
}
