@extends('layouts.pageLayout')

@section('title')<title>Bonza - 购物车</title>@stop

@section('css-reference')
	<link href="/assets/css/checkout.css" rel="stylesheet">
@stop

@section('body')
<div class="checkout-process">
	<div class="wrapper relative">
		<div class="center ck-sub-nav">
			<span>1&nbsp;&nbsp;&nbsp;登录</span>
			<span class="current-step">2&nbsp;&nbsp;&nbsp;运送</span>
			<span>3&nbsp;&nbsp;&nbsp;付款</span>
			<span>4&nbsp;&nbsp;&nbsp;确定</span>
		</div>
	</div>
</div>
<div class="wrapper ck-detail relative">
	<div class="ck-d-left">
		<h2>添加送货地址</h2>
		<div class="ck-d-wrapper relative">
			<div class="required-label">*此栏为必填</div>
			<div class="login-input">
				<div class="login-title">名字 *</div>
				<input id="name" type='text' placeholder="">
			</div>
			<div class="login-input">
				<div class="login-title">姓氏 *</div>
				<input id="name" type='text' placeholder="">
			</div>
			<div class="login-input">
				<div class="login-title">邮箱 *</div>
				<input id="name" type='text' placeholder="">
			</div>
			<div class="login-input">
				<div class="login-title">电话 *</div>
				<input id="name" type='text' placeholder="">
			</div>
			<div class="login-input">
				<div class="login-title">地址 *</div>
				<input id="name" type='text' placeholder="">
			</div>
			<div class="login-input">
				<div class="login-title">地址第二行</div>
				<input id="name" type='text' placeholder="">
			</div>
			<div class="login-input">
				<div class="login-title">城市 *</div>
				<input id="name" type='text' placeholder="">
			</div>
			<div class="login-input">
				<div class="login-title">省/辖区 *</div>
				<input id="name" type='text' placeholder="">
			</div>
			<div class="login-input">
				<div class="login-title">邮编 *</div>
				<input id="name" type='text' placeholder="">
			</div>
			<div class="login-remember-box">
				<input type="checkbox" name="remember"><span>送货地址与账单新地址相同</span>
			</div>
			<div class="login-remember-box">
				<input type="checkbox" name="remember"><span>另外输入账单地址</span>
			</div>
		</div>
	</div>
	<div class="ck-d-right">
		<h2>订单总结</h2>
	</div>
</div>

<!-- <div class="wrapper single-login-page">
	<div class="breadcrum">
		<a href="/">首页</a>
		<img src="/assets/img/next.svg">
		<a href="/shoppingbag">购物袋</a>
	</div>

	<div class="wishlist-box">
		<?php if (empty(session('shopping-bag'))) { ?>
			<h2 class="wishlist-title">很遗憾，您的购物袋是空的。</h2>
			<p class="wishlist-desc"> </p>
			<a href="/product"><div class="goshopping transition">继续购物</div></a>
		<?php } else { ?>
			<h2 class="title">购物袋</h2>
			<div class="btn-box">
				<a href="/product"><div id="btn-l" class="sb-btn">继续购物</div></a>
				<a href="/checkout"><div id="btn-r" class="sb-btn">结算</div></a>
			</div>
			<div class="relative">
				<div class="left-detail">
					<?php 
					$i = 0;
					foreach($shoppingbag as $product) { ?>
						<div class="item relative transition" id="p-{!!$product->id!!}">
							<div class="item-left">
								<img src="{!!$product->src!!}">
							</div>
							<div class="item-right relative">
								<h2>{!!$product->title!!}</h2>
								<div class="relative">
									<h3>{!!$product->subtitle!!}</h3>
									<h4 class="price">￥
										<span id="price{!!$product->id!!}">{!!$product->price!!}</span>
									</h4>
								</div>
								<h4>颜色：蔚蓝色</h4>
								<h4>尺寸：{!!$product->size!!}</h4>
								<div id="qty{!!$product->id!!}" class="number-select">
									<div class="minuse"><img src="/assets/img/minuse.svg"></div>
									<div class="number">{!!$product->qty!!}</div>
									<div class="plus"><img src="/assets/img/plus.svg"></div>
								</div>
								<div class="to-wl links transition" onclick="removeshoppingbag({!!$product->id!!},{!!$product->size!!},'wishlist')">移至愿望清单</div>
								<div class="del links transition" onclick="removeshoppingbag({!!$product->id!!},{!!$product->size!!},'none')">从购物袋中删除</div>
							</div>
						</div>
					<?php } ?>
				</div>
				<div class="right-checkout">
					<div class="rc-detail">
						<div class="rc-d-box">
							<span class="rc-left">商品总金额</span>
							<span class="rc-right">￥
								<span id="product_total">{!!$price['product_total']!!}</span>
							</span>
						</div>
						<div class="rc-d-box">
							<span class="rc-left">运费</span>
							<span class="rc-right">￥
								<span id="delivery">{!!$price['delivery']!!}</span>
							</span>
						</div>
						<div class="rc-line"></div>
						<div class="rc-d-box">
							<span class="rc-left">小计</span>
							<span class="rc-right">￥
								<span id="subtotal">{!!$price['subtotal']!!}</span>
							</span>
						</div>
					</div>
					<a href="/checkout"><div class="sb-btn" id="rc-c">结算</div></a>
					<a href="/product"><div class="sb-btn" id="rc-b">继续购物</div></a>
				</div>
			</div>
		<?php } ?>
	</div>
</div> -->
@stop

@section('js-reference')
@stop

@section('js-function')
<script type="text/javascript">
	$(".minuse").click(function(){
		var i = $(this).siblings('.number').html();
		if (i > 1) {
			i--;
		}
		$(this).siblings('.number').html(i);
		calculateTotal();
	});

	$(".plus").click(function(){
		var i = $(this).siblings('.number').html();
		i++;
		$(this).siblings('.number').html(i);
		calculateTotal();
	});

	$(".links").click(function(){
		var obj = $(this).parent().parent()
		obj.css('height','0').css('padding-bottom', "0").css('border-bottom', "0px solid #CCCCCC");
		setTimeout(function(){
			obj.html("");
			calculateTotal()
		}, 500)
	});


	function calculateTotal(){
		var sum = 0;
		var id = 0;
		var price = 0;
		var qty = 0;
		var temp_sum = 0;
		var delivery = 0;
		$.each($(".number"), function(){
			qty = $(this).html();
			id = $(this).parent().attr('id').substr(3);
			price = $("#price" + id).html();
			temp = qty * price;
			sum = sum + temp;
		});
		$("#product_total").html(sum.toFixed(2));
		delivery = $("#delivery").html();
		$("#subtotal").html((parseFloat(sum) + parseFloat(delivery)).toFixed(2));
	}
</script>
@stop