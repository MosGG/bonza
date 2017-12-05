<?php

namespace App\Http\Middleware;

use Closure;
use Redirect;
use DB;

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
            if(empty($_COOKIE['bonza_username']) || empty($_COOKIE['bonza_password'])){
                return Redirect::to('/login?req_url='.$_SERVER["REQUEST_URI"]);
            } else {
                $username = $_COOKIE['bonza_username'];
                $password = $_COOKIE['bonza_password'];
                $member = DB::table('membership')->where("email", $username)->get();
                if (!empty($member) && $member[0]->password == $password){
                    $request->session()->put('member', $username);
                    $request->session()->put('member_id', $member[0]->id);
                    $request->session()->put('memberlevel', $member[0]->level);
                    $request->session()->put('wishlist', json_decode($member[0]->wishlist, true));
                    $request->session()->put('shopping-bag', json_decode($member[0]->shopping_bag, true));
                    
                } else {
                    return Redirect::to('/login?req_url='.$_SERVER["REQUEST_URI"]);
                }
            }
        }  
        return $next($request); 
    }
}
