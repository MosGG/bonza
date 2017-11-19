@extends('layouts.pageLayout')

@section('title')<title>Wishlist - Bonza</title>@stop

@section('css-reference')
	<link href="/assets/css/wishlist.css" rel="stylesheet">
@stop

@section('body')
<div class="wrapper single-login-page">
	<div class="breadcrum">
		<a href="/">首页</a>
		<img src="/assets/img/next.svg">
		<a href="/wishlist">愿望清单</a>
	</div>

	<div class="wishlist-box">
		<?php if (empty(session('wishlist'))) { ?>
			<h2 class="wishlist-title">您的愿望清单暂时是空的</h2>
			<p class="wishlist-desc">想要实时追踪您的心仪单品？只需点击“
				<img src="/assets/img/wishlist-icon.svg">
			”，即可将喜欢的商品加入愿望清单。</p>
			<a href="/product"><div class="goshopping transition">继续购物</div></a>
		<?php } else { ?>
			<h2 class="title">愿望清单</h2>
			<?php 
			$i = 0;
			foreach($wishlist as $product) { ?>
				<div class="item relative">
					<img class="wishlist-del transition" src="/assets/img/bag-delete.svg" onclick="removewishlist({!!$i++!!});">
					<div class="item-left">
						<img src="{!!$product->src!!}">
					</div>
					<div class="item-right relative">
						<div class="product-info">
							<h2>{!!$product->title!!}</h2>
							<h3>{!!$product->subtitle!!}</h3>
							<h4>￥{!!$product->price!!}</h4>
							<div class="p-size-box relative">
								<nav>
								  	<ul class="drop-down relative closed">
								  		<img id="drop-expand" class="transition" src="/assets/img/right.svg">
									    <li><a href="javascript:void(0);" id="current-sort" class="nav-button">请选择您的尺码</a></li>
										<?php 
										$size = json_decode($product->size);
										foreach ($size as $s) {
											echo "<li><a class='sort-item'>".$s->id." - ".$s->title."</a></li>";
										}
										?>
								  	</ul>
								</nav>
								<div class="number-select">
									<div class="minuse"><img src="/assets/img/minuse.svg"></div>
									<div class="number">1</div>
									<div class="plus"><img src="/assets/img/plus.svg"></div>
								</div>
								<div id="size-refer" class="transition">查看尺码参考</div>
							</div>
							<div class="p-btn-box relative">
								<div id="btn-cart" class="transition">加入购物车
									<svg width="19px" height="22px" viewBox="0 0 19 22" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
									    <g id="Page-1" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
									        <g id="PRODUCT-PAGE-Single" transform="translate(-920.000000, -550.000000)" fill-rule="nonzero" fill="#FFFFFF">
									            <g id="Group-4" transform="translate(662.000000, 293.000000)">
									                <g transform="translate(32.000000, 248.000000)">
									                    <g transform="translate(226.000000, 9.000000)">
									                        <path d="M9.36057692,0 C7.03695892,0 5.12980769,1.90715123 5.12980769,4.23076923 L5.12980769,5.07692308 L0.951923077,5.07692308 L0.899038462,5.87019231 L0.0528846154,21.1009615 L0,22 L18.7211538,22 L18.6682692,21.1009615 L17.8221154,5.87019231 L17.7692308,5.07692308 L13.5913462,5.07692308 L13.5913462,4.23076923 C13.5913462,1.90715123 11.6841949,0 9.36057692,0 Z M9.36057692,1.69230769 C10.7620192,1.69230769 11.8990385,2.82932692 11.8990385,4.23076923 L11.8990385,5.07692308 L6.82211538,5.07692308 L6.82211538,4.23076923 C6.82211538,2.82932692 7.95913462,1.69230769 9.36057692,1.69230769 Z M2.53846154,6.76923077 L5.12980769,6.76923077 L5.12980769,9.30769231 L6.82211538,9.30769231 L6.82211538,6.76923077 L11.8990385,6.76923077 L11.8990385,9.30769231 L13.5913462,9.30769231 L13.5913462,6.76923077 L16.1826923,6.76923077 L16.9230769,20.3076923 L1.79807692,20.3076923 L2.53846154,6.76923077 Z" id="Shape"></path>
									                    </g>
									                </g>
									            </g>
									        </g>
									    </g>
									</svg>
								</div>
								<div id="btn-wishlist" class="transition">加入愿望清单
									<svg width="26px" height="23px" viewBox="0 0 26 23" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
									    <g id="Page-1" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
									        <g id="PRODUCT-PAGE" class="transition" transform="translate(-1182.000000, -67.000000)" stroke="#fff" stroke-width="0.75" fill="#000" fill-rule="nonzero">
									            <g id="header" transform="translate(-3.000000, 42.000000)">
									                <g id="wishlist" transform="translate(1186.000000, 26.000000)">
									                    <path d="M17.2781256,2.4 C19.6781256,2.4 21.6,4.3218756 21.6,6.7218756 C21.6,9.1218756 16.9218756,14.4 12,18.4781256 C7.0781256,14.2781256 2.4,9 2.4,6.7218756 C2.4,4.3218756 4.3218756,2.4 6.7218756,2.4 C9.6,2.4 12,6 12,6 C12,6 14.2781256,2.4 17.2781256,2.4 L17.2781256,2.4 Z M17.2781256,0 C15.1218756,0 13.2,1.0781256 12,2.7609372 C10.8,1.0781256 8.8781256,0 6.7218756,0 C3,0 0,3 0,6.7218756 C0,12 12,21.6 12,21.6 C12,21.6 24,12 24,6.7218756 C24,3 21,0 17.2781256,0 Z" id="Shape"></path>
									                </g>
									            </g>
									        </g>
									    </g>
									</svg>
								</div>
							</div>
						</div>
					</div>
				</div>
			<?php } ?>
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



