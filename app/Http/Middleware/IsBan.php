<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class IsBan
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        //* auth
        //* auth status
        //* auth status 0 == Ban
        //* logout login
        //* 1 == ACTIVE 
        //* redirect

        if (auth()->user()) {

            if (auth()->user()->status == 0) {
                //*BAN USERS
                Auth::logout();
                return redirect()->route('login')->withErrors(['email' => 'Your account has been ban.']);
            }
        }


        return $next($request);
    }
}
