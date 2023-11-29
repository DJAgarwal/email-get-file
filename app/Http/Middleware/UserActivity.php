<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\User;
use Auth;
use Cache;

class UserActivity
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check()) {
            $expire = now()->addMinutes(2);
            Cache::put('user-is-online-' .Auth::user()->id,true,$expire);
            User::where('id',Auth::user()->id)->update(['last_seen' => now()]);
        }
        return $next($request);
    }
}
