@extends('layouts.pageLayout')

@section('title')<title>Bonza - 微信绑定</title>@stop

@section('css-reference')
  <link href="/assets/css/help.css" rel="stylesheet">
@stop

@section('body')
<div class="body-content">
      <div class="main">
         <div class="breadcrum">
             <a href="/">首页</a>
               <img src="/assets/img/next.svg">
              <a href="/myaccount">我的账户</a>
              <img src="/assets/img/next.svg">
             <a href="/myaccount/wechat">微信绑定</a>
         </div>

         <div class="nav">
           <div class="detail-expand-btn rotate">
            <div></div>
            <div></div>
          </div>
           <h3>我的账户</h3>
           <div class="nav_box_one">
             <a href="/myaccount/addressbook">
               <span class="hvr-underline-from-center">地址簿</span>
             </a>
           </div>

           <div class="nav_box">
             <a href="/myaccount/accountinfo">
               <span class="hvr-underline-from-center">账户信息</span>
             </a>
           </div>
           <div class="nav_box">
             <a href="/myaccount/order">
               <span class="hvr-underline-from-center">我的订单</span>
             </a>
           </div>
           <div class="nav_box">
             <a href="/wishlist">
               <span class="hvr-underline-from-center">愿望清单</span>
             </a>
           </div>
           <div class="nav_box">
             <a href="/myaccount/wechat">
               <span class="hvr-underline-from-center-selected">微信绑定</span>
             </a>
           </div>
         </div>

         <div class= "content">
           <h3>微信绑定</h3>
           <div class="inside_re">
              <div class="left_div relative">
                <p style="width: 242px;margin-bottom: 20px">
                  只需掏出手机扫描右侧的二维码，即可将账户与微信绑定，
                  <br><br>
                  成功绑定微信后，您可第一时间获得新品推送和折扣信息。
                </p>
              </div>
              <div class="right_div relative">
                <img src="/assets/img/qrcode.png" style="width: 160px; height: 160px;">
                <p style="width: 160px;text-align: center;margin-top: 10px;">扫一扫</p>
              </div>

           </div>
         </div>

      </div>
</div>
@stop

@section('js-function')
<script type="text/javascript" src="/assets/js/myaccount-m-nav.js"></script>
<script>
  
</script>
@stop
