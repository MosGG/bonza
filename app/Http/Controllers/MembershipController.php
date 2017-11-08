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

        $res = array("success" => "failed", "msg" => "The Username, Password you entered doesn't match our records.");
        if ($username !== NULL || $password !== NULL) {
            if (!empty($username) && !empty($password)){
                $member = DB::table('membership')->where("email", $username)->get();
                if (!empty($member) && $member[0]->password == $password){
                    $res = array("success" => "true", "msg" => "Success");
                    $request->session()->put('member', $username);
                    $request->session()->put('memberlevel', $member[0]->level);
                    $request->session()->put('wishlist', count(json_decode($member[0]->wishlist, true)));
                    $request->session()->put('shopping-bag', count(json_decode($member[0]->shopping_bag, true)));
                }
            }
        }
        return json_encode($res);
    }

    public function logout(Request $request)
    {
        $request->session()->flush();
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
                $res = array("success" => "true", "msg" => "Success");
            } else {
                $res = array("success" => "failed", "msg" => "account exist");
            }
        } else {
            $res = array("success" => "failed", "msg" => "Please input required fields.");
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
            $token = md5($member[0]->email.$member[0]->password.time());
            $token_exp = time() + 3600 * 24;
            $member_info = array(
                "email" => $member[0]->email,
                "username" => empty($member[0]->username)?"Customer":$member[0]->username,
                "token" => $token,
            );
            // $this->forgetEmailSend($member_info);
            DB::table('membership')->where("email", $email)->update(['token' => $token, "token_exp" => $token_exp]);
            $res = array("success" => "true", "msg" => "Email has been send.");
        } else {
            $res = array("success" => "failed", "msg" => "Can't find your account.");
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
}
