<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\User;

class EnsureNotBanned
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {

        if (auth()->check() && auth()->user()->banned_at) {

            auth()->logout();

            return redirect()->route('login')->with([
                'error' => 'Your account is banned! Please contact admin if you think this is mistake.'
            ]);
        }

        return $next($request);

    }
}
