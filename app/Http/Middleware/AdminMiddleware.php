<?php

namespace App\Http\Middleware;

use Closure;

use Session;

class AdminMiddleware
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
        if(empty($userData) || $userData['privilege'] != 3) {
            return redirect()->route('login');
        }
        return $next($request);
    }
}
