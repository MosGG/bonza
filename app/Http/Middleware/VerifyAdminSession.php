<?php

namespace App\Http\Middleware;

use Closure;
use Redirect;

class VerifyAdminSession
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
        if (!$request->session()->has('admin')) {
            return Redirect::to('/admin-login');
        }  
        return $next($request); 
    }
}
