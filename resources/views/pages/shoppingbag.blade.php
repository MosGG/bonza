@extends('layouts.pageLayout')

@section('title')<title>Shopping Bag - Bonza</title>@stop

@section('css-reference')
	<link href="/assets/css/shopping-bag.css" rel="stylesheet">
@stop

@section('body')
<div class="wrapper single-login-page">
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
</div>
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