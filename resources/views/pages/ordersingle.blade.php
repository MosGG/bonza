@extends('layouts.pageLayout')

@section('title')<title>Bonza - 我的订单 - {!!$order->number!!}</title>@stop

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
           <h3>订单总结</h3>
           <div class="new_address"><a href="/myaccount/order">返回上页</a></div>
           <div class="inside_re">
              <p class="single-order-des">
                <b>订单号码：</b> {!!$order->number!!}<br>
                <b>订单日期：</b> {!!$order->create_time!!}<br>
                <br>
                <b>请注意：</b>您可以在货到后28天内退换本订单内的商品。<br>
                如欲安排在此期限后退换货，请点此<a href="/help" target="_blank">联系客服</a>或致电<a href="tel:13000000">1300 0000</a>给我们的团队
              </p>
             
              <table class="single-order-detail">
                <tr>
                  <th class="imgth">产品</th>
                  <th>产品描述</th>
                  <th>颜色</th>
                  <th>尺码</th>
                  <th>单价</th>
                </tr>
                <?php 
                foreach($order->detail as $p) {
                  echo "<tr>";
                  echo "<td><img src='".$p['src']."'></td>";
                  echo "<td><h3>".$p['title']."</h3><p>".$p['subtitle']."</p></td>";
                  echo "<td><p>".$p['sales']."</p></td>";
                  echo "<td><p>".$p['size']."</p></td>";
                  echo "<td><p>￥".number_format($p['price'],2)."</p></td>";
                  echo "</tr>";
                }
                ?>
              </table>

              <div class="price-detail">
                <div class="pd-box">
                  <div class="pd-line">
                    <span class="pd-left">小计</span>
                    <span class="pd-right">￥{!!number_format($order->total_price,2)!!}</span>
                  </div>
                  <div class="pd-line">
                    <span class="pd-left">其他税</span>
                    <span class="pd-right">￥{!!number_format(0,2)!!}</span>
                  </div>
                  <div class="pd-line">
                    <span class="pd-left">关税</span>
                    <span class="pd-right">￥{!!number_format(0,2)!!}</span>
                  </div>
                  <div class="pd-line">
                    <span class="pd-left">运费</span>
                    <span class="pd-right">￥{!!number_format($order->delivery_fee,2)!!}</span>
                  </div>
                  <div class="pd-line pd-black">
                    <span class="pd-left">商品总金额</span>
                    <span class="pd-right">￥{!!number_format($order->subtotal,2)!!}</span>
                  </div>
                </div>                
              </div>

              <div class="paydetail">
                <div class="pd-up pd-line">
                    <span class="pd-left">付款方式</span>
                    <span class="pd-right">金额&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
                </div>
                <div class="pd-down pd-line">
                    <span class="pd-left">微信扫码支付</span>
                    <span class="pd-right">￥{!!number_format($order->subtotal,2)!!}</span>
                </div>
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
