<?php

namespace App\Http\Middleware;

use Closure;

use Session;

class LoggedInMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $userData = Session::get('userData');
        if(!empty($userData) && $userData['privilege'] != 1) {
            return redirect()->route('home');
        }
        return $next($request);
    }
}
