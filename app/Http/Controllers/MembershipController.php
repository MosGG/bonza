<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Illuminate\Support\Facades\Redirect;
use App\Http\Requests;
use Mail;

class MembershipController extends Controller
{
    public function login(Request $request){
        $username = $request->input("username");
        $password = md5($request->input("password"));
        $remember = $request->input("remember");

        $res = array("success" => "failed", "msg" => "用户名或密码不正确，请重新输入。");
        if ($username !== NULL || $password !== NULL) {
            if (!empty($username) && !empty($password)){
                $member = DB::table('membership')->where("email", $username)->get();
                if (!empty($member) && $member[0]->password == $password){
                    $res = array("success" => "true", "msg" => "登陆成功");
                    $request->session()->put('member', $username);
                    $request->session()->put('member_id', $member[0]->id);
                    $request->session()->put('memberlevel', $member[0]->level);
                    $request->session()->put('wishlist', json_decode($member[0]->wishlist, true));
                    $request->session()->put('shopping-bag', json_decode($member[0]->shopping_bag, true));

                    if ($remember == "true") {
                        setcookie("bonza_username", $username, time()+3600*24*30);  
                        setcookie("bonza_password", $password, time()+3600*24*30);
                    }
                    
                }
            }
        }
        return json_encode($res);
    }

    public function logout(Request $request)
    {
        $request->session()->flush();
        if(!empty($_COOKIE['bonza_username'])) {
            setcookie("bonza_username", null, time()-3600*24*30); 
            setcookie("bonza_password", null, time()-3600*24*30);   
        }
        return Redirect::to('/login');
    }

    public function register(Request $request){
        $member = array(
            'email' => trim($request->input("email")),
            'username' => $request->input("username"),
            'password' => md5($request->input("password")),
            'address' => $request->input("address"),
            'mobile' => $request->input("mobile"),
        );

        if (!empty($member['email']) && !empty($member['password'])){
            $exist = DB::table('membership')->where("email", $member['email'])->get();
            if (empty($exist)) {
                $member['id'] = null;
                $member['level'] = 0;
                $member['create_time'] = time();
                $member['token'] = md5($member['email'].$member['password'].time());
                $member['token_exp'] = time() + 3600 * 24;
                DB::table('membership')->insert($member);
                // $this->regEmailSend($member);
                $res = array("success" => "true", "msg" => "注册成功");
            } else {
                $res = array("success" => "failed", "msg" => "邮箱已被使用，请重新输入");
            }
        } else {
            $res = array("success" => "failed", "msg" => "请输入所有带*号的栏目");
        }
        return json_encode($res);
    }

    public function active(Request $request){
        $token = $request->input("token");
        $result = $this->checkToken($token);
        if ($result == "success") {
            DB::table('membership')->where('token', $token)->update(["active_status" => "1","update_time" => time(),"token"=>""]);
        }
        return view('pages.active')->with("result", $result);
    }

    public function reset(Request $request){
        $token = $request->input("token");
        $result = $this->checkToken($token);
        return view('pages.reset')->with("result", $result)->with('token', $token);
    }

    public function resetPassword(Request $request){
        $token = $request->input("token");
        $result = $this->checkToken($token);
        if ($result == "success") {
            $password = md5($request->input('password'));
            DB::table('membership')->where('token', $token)->update(["password" => $password, "update_time" => time(),"token"=>""]);
            $res = array("success" => "ture", "msg" => "success");
        } else {
            $res = array("success" => "failed", "msg" => "Token has expired.");
        }
        return json_encode($res);
    }

    public function forget(Request $request){
        $email = $request->input("email");
        $member = DB::table('membership')->where("email", $email)->get();
        if(!empty($member)){
            $token_exp = time() + 3600 * 24;
            if ($token_exp - $member[0]->token_exp > 3600){
                $token = md5($member[0]->email.$member[0]->password.time());
                
                $member_info = array(
                    "email" => $member[0]->email,
                    "username" => empty($member[0]->username)?"Customer":$member[0]->username,
                    "token" => $token,
                );
                // $this->forgetEmailSend($member_info);
                DB::table('membership')->where("email", $email)->update(['token' => $token, "token_exp" => $token_exp]);
                $res = array("success" => "true", "msg" => "邮件已发送，请登录邮箱按邮件内容操作。");
            } else {
                $res = array("success" => "true", "msg" => "请勿重复操作。");
            }
        } else {
            $res = array("success" => "failed", "msg" => "找不到您的账户，请重新输入。");
        }
        return $res;
    }

    private function checkToken($token){
        $result = "failed";
        if (strlen($token) == 32) {
            $member = DB::table('membership')
            ->where('token', $token)
            ->where("token_exp", ">", time())
            ->get();
            if (!empty($member)){
                $result = "success";
            }
        }
        return $result;
    }

    public function myaccount(){
        return view('pages.myaccount');
    }

    public function regEmailSend($member){
        $email = $member['email'];
        Mail::send('emails.register', ['username' => $member['username'],'token'=>$member['token']], function ($message) use ($email) {
            $message->from("info@bonza.com.co", "BONZA");
            $message->to($email)->subject("Active your account - BONZA");
        });
        return ture;
    }

    public function forgetEmailSend($member){
        $email = $member['email'];
        Mail::send('emails.resetPassword', ['username' => $member['username'],'token'=>$member['token']], function ($message) use ($email) {
            $message->from("info@bonza.com.co", "BONZA");
            $message->to($email)->subject("Reset your password - BONZA");
        });
        return ture;
    }

    public function addtowishlist(Request $request){
        $id = $request->input('id');
        $member = session('member');
        $wishlist = session('wishlist');
        $wishlist[] = array('id' => $id);
        $num = count($wishlist);
        DB::table('membership')->where('email', $member)->update(["wishlist" => json_encode($wishlist),"update_time" => time()]);
        $request->session()->put('wishlist', $wishlist);
        return array("success" => "true", "num" => $num);
    }

    public function removeFromWishlist(Request $request){
        $i = $request->input('i');
        $member = session('member');
        $wishlist = session('wishlist');
        array_splice($wishlist, $i, 1);
        $num = count($wishlist);
        DB::table('membership')->where('email', $member)->update(["wishlist" => json_encode($wishlist),"update_time" => time()]);
        $request->session()->put('wishlist', $wishlist);
        return array("success" => "true", "num" => $num);
    }

    public function addToShoppingbag(Request $request){
        $id = $request->input('id');
        $size = $request->input('size');
        $qty = $request->input('qty');
        $member = session('member');
        $shoppingbag = session('shopping-bag');

        $flag = false;
        foreach($shoppingbag as $k => $p){
            if ($p['id'] == $id && $p['size'] == $size) {
                $shoppingbag[$k]['qty'] += $qty;
                $flag = true;
            }
        }
        if (!$flag) {
            $shoppingbag[] = array("id"=>$id, "size"=>$size, "qty"=>$qty);
        }
        // $num = count($shoppingbag);
        var_dump($shoppingbag);
        // DB::table('membership')->where('email', $member)->update(["shopping-bag" => json_encode($shoppingbag),"update_time" => time()]);
        // $request->session()->put('shopping-bag', $shoppingbag);

        $price = array("product_total"=>0, "delivery"=>0, "subtotal"=>0);
        foreach ($shoppingbag as $key => $p) {
            $product = DB::table('portfolios')->where('id',$p['id'])->get();
            $imgs = DB::table('media_portfolio')->where('portfolio_id', $p['id'])->orderBy('featured','DESC')->get();
            if (empty($imgs[0]->media_id)) {
                $imgSrc = '/assets/img/default.png';
            } else {
                $imgSrc = DB::table('media_library')->where('id', $imgs[0]->media_id)->value('src_thumb');
            }
            $product[0]->src = $imgSrc;
            $product[0]->size = $p['size'];
            $product[0]->qty = $p['qty'];
            $shoppingbag[$key] = $product[0];
            $price['product_total'] += $product[0]->price * $product[0]->qty;
        }
        $price['delivery'] = 15;
        $price['subtotal'] = $price['product_total'] + $price['delivery'];
        return view('partial.shoppingbag')->with("shoppingbag", $shoppingbag)->with('price', $price)->with('id', $id);
    }

    public function removeFromShoppingbag(Request $request){
        $id = $request->input('id');
        $size = $request->input('size');
        $member = session('member');
        $shoppingbag = session('shopping-bag');
        foreach($shoppingbag as $k => $p){
            if ($p['id'] == $id && $p['size'] == $size) {
                unset($shoppingbag[$k]);
            }
        }
        $num = count($shoppingbag);
        // DB::table('membership')->where('email', $member)->update(["wishlist" => json_encode($wishlist),"update_time" => time(),"token"=>""]);
        // $request->session()->put('shopping-bag', $shoppingbag);
        return array("success" => "true", "num" => $num);
    }
}
