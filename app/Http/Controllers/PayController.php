<?php

namespace App\Http\Controllers;


// use App\Classes\PricesClass;
use App\Wxpay\NativePay;
use App\Wxpay\lib\WxPayApi;
use App\Wxpay\lib\WxPayUnifiedOrder;
use App\wxpay\lib\WxPayConfig;

use Illuminate\Http\Request;
// require_once(app_path() . '/Classes/test.php');


require_once(app_path() . '/Wxpay/lib/WxPay_Api.php');
require_once(app_path() . '/Wxpay/WxPay_NativePay.php');
require_once(app_path() . '/Wxpay/log.php');
// require_once(app_path() . '/Wxpay/lib/WxPay_Api.php');


class PayController extends Controller
{
    // bonza.com/test?body=hello&attach=hello&fee=1&tag=hello&id=123456
    
    public function getUrl(Request $request){
      $notify = new NativePay();
      // $url1 = $notify->GetPrePayUrl("123456789");
      $input = new WxPayUnifiedOrder();
      $input->SetBody($request->input('body'));
      $input->SetAttach($request->input('attach'));
      $input->SetOut_trade_no(WxPayConfig::MCHID.date("YmdHis"));
      $input->SetTotal_fee($request->input('fee'));
      $input->SetTime_start(date("YmdHis"));
      $input->SetTime_expire(date("YmdHis", time() + 60000));
      $input->SetGoods_tag($request->input('tag'));
      $input->SetNotify_url("http://paysdk.weixin.qq.com/example/notify.php");
      $input->SetTrade_type("NATIVE");
      $input->SetProduct_id($request->input('id'));
      $result = $notify->GetPayUrl($input);
      // echo var_dump($result);
      $url2 = $result["code_url"];
      return $url2;
      // $pricesClass = new PricesClass();
    }
    // public function getUrl(Request $request){
    //     return view('pages.test');
    // }
}
