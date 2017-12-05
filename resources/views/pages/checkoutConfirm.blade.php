@extends('layouts.pageLayout')

@section('title')<title>Bonza - 确认订单</title>@stop

@section('css-reference')
	<link href="/assets/css/checkout.css" rel="stylesheet">
@stop

@section('body')
<div class="checkout-process">
	<div class="wrapper relative">
		<div class="center ck-sub-nav">
			<span>1&nbsp;&nbsp;&nbsp;登录</span>
			<span>2&nbsp;&nbsp;&nbsp;运送</span>
			<span class="current-step">3&nbsp;&nbsp;&nbsp;付款</span>
			<span>4&nbsp;&nbsp;&nbsp;确定</span>
		</div>
	</div>
</div>
<div class="wrapper ck-detail relative">
	<div class="ck-d-left">
		<h2>查看订单地址与送货地址</h2>
		<?php 
			$address = session("address");
			$billing = session("billing_address");
		?>
		<div class="address-item">
			<h4>账单地址</h4>
			<p>{!!$address['firstname'] . " " . $address['lastname']!!}</p>
			<p>{!!$address['add'] . " " . $address['add2']!!}</p>
			<p>{!!$address['city']!!}</p>
			<p>{!!$address['state']!!}</p>
			<p>{!!$address['postcode']!!}</p>
			<a href="/checkout"><div class="cc-btn">修改账单地址</div></a>
		</div>
		<div class="address-item">
			<h4>送货地址</h4>
			<p>{!!$billing['firstname'] . " " . $billing['lastname']!!}</p>
			<p>{!!$billing['add'] . " " . $billing['add2']!!}</p>
			<p>{!!$billing['city']!!}</p>
			<p>{!!$billing['state']!!}</p>
			<p>{!!$billing['postcode']!!}</p>
			<a href="/checkout"><div class="cc-btn">修改送货地址</div></a>
		</div>
	</div>
	
	<div class="ck-d-left">
		<!-- Devilery -->
		<div class="delivery-box">
			<h3>确认送货方式</h3>
			<p><b>快递配送</b></p>
			<p>预计到达时间2-3天</p>
			<p>免费</p>
			<a href="/checkout"><div class="cc-btn">更改送货方式</div></a>
		</div>
	</div>

	<div class="ck-d-left wechat-box">
		<h3>微信扫码支付</h3>
		<img>
		<a href="/checkout"><div class="cc-btn">回上页</div></a>
	</div>


	<div class="ck-d-right">
		<h2>订单总结</h2>
		<div class="order-detail">
			<?php 
			foreach($shoppingbag as $product) { ?>
				<div class="item relative transition" id="p-{!!$product->id!!}">
					<div class="item-left">
						<img src="{!!$product->src!!}">
					</div>
					<div class="item-right relative">
						<h3>{!!$product->title!!}</h3>
						<h4>{!!$product->subtitle!!}</h4>
						<br>
						<h4>颜色：蔚蓝色</h4>
						<h4>尺寸：{!!$product->size!!}</h4>
						<h4>数量：{!!$product->qty!!}</h4>
						<h4 class="price">￥
							<span id="price{!!$product->id!!}">{!!number_format($product->price,2)!!}</span>
						</h4>
					</div>
				</div>
			<?php } ?>
			<div class="price-detail">
				<div class="justify-line"><span>商品总金额</span>￥{!!number_format($price['product_total'],2)!!}</div>
				<div class="justify-line"><span>运费</span>￥{!!number_format($price['delivery'],2)!!}</div>
			</div>
			<div class="price-detail" style="margin-bottom: -1px;">
				<div class="justify-line"><span>小计</span>￥{!!number_format($price['subtotal'],2)!!}</div>
			</div>
		</div>
		<div class="tax-des">所有价格包含关税和其他税</div>
	</div>

</div>
@stop

@section('js-reference')
@stop

@section('js-function')
<script type="text/javascript">
	$(document).ready(function(){
		if ($(".ck-detail").height() < $(".ck-d-right").height()) {
			$(".ck-detail").height($(".ck-d-right").height());
		}
	})
</script>
@stop