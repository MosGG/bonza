<?php

namespace App\Http\Middleware;

use Closure;
use Redirect;

class VerifyAdminPerssion
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
        if ($request->session()->get('adminLevel') != 'administrator') {
            return Redirect::to('/media-library');
        }
        return $next($request);
    }
}
