<?php

namespace App\Http\Middleware;

use Closure;
use Redirect;

class MembershipPermission
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
        if (!$request->session()->has('member')) {
            return Redirect::to('/login');
        }  
        return $next($request); 
    }
}
