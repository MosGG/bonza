@extends('layouts.pageLayout')

@section('title')<title>Wishlist - Bonza</title>@stop

@section('css-reference')
	<!-- <link href="/assets/css/wishlist.css" rel="stylesheet"> -->
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
				<div id="btn-l" class="sb-btn">继续购物</div>
				<div id="btn-r" class="sb-btn">结算</div>
			</div>
			<div class="left-detail">
				<?php 
				$i = 0;
				foreach($shoppingbag as $product) { ?>
					<div class="item relative">
						<div class="item-left">
							<img src="{!!$product->src!!}">
						</div>
						<div class="item-right relative">
							<h2>{!!$product->title!!}</h2>
							<div class="relative">
								<h3>{!!$product->subtitle!!}</h3>
								<h4 class="price">￥{!!$product->price!!}</h4>
							</div>
							<h4>颜色：蔚蓝色</h4>
							<h4>尺寸：{!!$product->size!!}</h4>
							<div class="number-select">
								<div class="minuse"><img src="/assets/img/minuse.svg"></div>
								<div class="number">1</div>
								<div class="plus"><img src="/assets/img/plus.svg"></div>
							</div>
							<div id="to-wl" class="links transition">移至愿望清单</div>
							<div id="del" class="links transition">从购物袋中删除</div>
						</div>
					</div>
				<?php } ?>
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
	});

	$(".plus").click(function(){
		var i = $(this).siblings('.number').html();
		i++;
		$(this).siblings('.number').html(i);
	});

	$(".nav-button").click(function() {
		var nav = $(this).parent().parent();
		var height = nav.children("li").length * 31 - 1;
		if (nav.height() == 30) {
			nav.height(height);
		} else {
			nav.height(30);
		}
		$("#drop-expand").toggleClass("drop-expand");
	});

	function removewishlist(i){
		$.ajax({
  			url: "/remove-from-wishlist",
  			method: 'POST',
  			data:{
  				i: i,
  			}, 
  			headers: {
	            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
	        },
  			success: function(result){
		        $(".wishlist-num").show();
		  		$(".wishlist-num").html(result.num);
		  		$(".wishlist-num").addClass("addwishlist");
				setTimeout(function(){
					$(".wishlist-num").removeClass("addwishlist");
				},2100);
				$(".item").eq(i).fadeOut();
		    }
		});
  	}
</script>
@stop