@extends('layouts.pageLayout')

@section('title')<title>Bonza - 我的订单</title>@stop

@section('css-reference')
  <link href="/assets/css/help.css" rel="stylesheet">
  <link href="/assets/css/myorder.css" rel="stylesheet">
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
               <span class="hvr-underline-from-center-selected">我的订单</span>
             </a>
           </div>
           <div class="nav_box">
             <a href="/wishlist">
               <span class="hvr-underline-from-center">愿望清单</span>
             </a>
           </div>
           <div class="nav_box">
             <a href="/myaccount/wechat">
               <span class="hvr-underline-from-center">微信绑定</span>
             </a>
           </div>
         </div>

         <div class= "content">
           <h3>我的订单信息</h3>
           <div class="inside_re">
              <div style="font-size: 16px;color: #555555;">请在下面点击订单号码，以查看订单信息或申请退换货。您可以在收到货品起28天之内通过邮寄的方式进行退换。</div>
              <table class="orderlist">
                <tr>
                  <th>订单日期</th>
                  <th>订单号码</th>
                  <th>订单状态</th>
                  <th>配送信息</th>
                </tr>
                <?php 
                foreach($order as $o) {
                  echo "<tr>";
                  echo "<td><a href='/myaccount/order/".$o->id."'>".$o->create_time."</a></td>";
                  echo "<td><a href='/myaccount/order/".$o->id."'>".$o->number."</a></td>";
                  echo "<td><a href='/myaccount/order/".$o->id."'>".$o->status."</a></td>";
                  echo "<td><a href='/myaccount/order/".$o->id."'>".$o->delivery_status."</a></td>";
                  echo "</tr>";
                }
                ?>
              </table>
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
