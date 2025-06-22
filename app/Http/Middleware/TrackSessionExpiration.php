<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TrackSessionExpiration
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next)
    {
        if (Auth::check()) {
            $request->session()->put('last_user_id', Auth::id());
        }
        // Jika user tidak login, tapi session punya last_user_id
        else if ($request->session()->has('last_user_id')) {
            $userId = $request->session()->pull('last_user_id'); // Ambil dan hapus
            User::where('id', $userId)->update(['is_logged_in' => false]);
        }

        return $next($request);
    }
}
