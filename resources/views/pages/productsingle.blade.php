@extends('layouts.pageLayout')

@section('title')<title>{!!$product->title!!} - Bonza</title>@stop

@section('css-reference')
<link href="/assets/css/productsingle.css" rel="stylesheet">
<link href="/assets/js/slick/slick.css" rel="stylesheet">
@stop

@section('body')
<?php 
	$wishlist = array(); 
	if (!empty(session('wishlist'))) {
		foreach (session('wishlist') as $value) {
			$wishlist[$value['id']] = true;
		}
	}
?>
<div class="wrapper relative">
	<div class="breadcrum">
		<a href="/">首页</a>
		<img src="/assets/img/next.svg">
		<a href="/product">选购</a>
		<img src="/assets/img/next.svg">
		<a href="/category/{!!$product->category!!}">{!!$product->category!!}</a>
	</div>
	
	<div id="slider">
		<?php 
		foreach($imgs as $img){
			echo "<img src='".$img."'>";
		}
		?>
		<img src="/assets/img/default.png">
		<img src="/assets/img/default.png">
		<img src="/assets/img/default.png">
		<img src="/assets/img/default.png">
		<img src="/assets/img/default.png">
	</div>

	<div class="product-info">
		<h2>{!!$product->title!!}</h2>
		<h3>{!!$product->subtitle!!}</h3>
		<h4>￥{!!$product->price!!}</h4>
		<div class="p-size-box">
			<nav>
			  	<ul class="drop-down relative closed">
			  		<img id="drop-expand" class="transition nav-button" src="/assets/img/right.svg">
				    <li><a href="javascript:void(0);" id="current-sort" class="nav-button" data-size="">请选择您的尺码</a></li>
					<?php 
					$size = json_decode($product->size);
					foreach ($size as $s) {
						echo "<li><a class='sort-item' data-size='".$s->id."'>".$s->id." - ".$s->title."</a></li>";
					}
					?>
			  	</ul>
			</nav>
			<div id="size-refer" class="transition">查看尺码参考</div>
		</div>
		<div class="p-btn-box">
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
			<div id="btn-wishlist" class="transition" onclick="addwishlist({!!$product->id!!})">加入愿望清单
				<?php if (isset($wishlist[$product->id])) {?>
				<svg width="24px" height="22px" viewBox="0 0 24 22" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
				    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
				        <g class="transition PRODUCT-PAGE" transform="translate(-617.000000, -771.000000)" fill-rule="nonzero" fill="#000000">
				            <g transform="translate(327.000000, 353.000000)">
			                    <g transform="translate(290.000000, 418.000000)">
		                            <path d="M11.998125,21.3299999 C11.998125,21.3299999 0,11.8523144 0,6.51981443 C0,2.96307827 2.99953124,0 6.59792756,0 C8.69655825,0 10.8003961,1.5205957 11.998125,2.99953124 C13.1958551,1.5205957 14.9976562,0 17.3983224,0 C20.9967187,0 23.9962499,2.96307827 23.9962499,6.51981443 C23.9962499,11.8523144 11.998125,21.3299999 11.998125,21.3299999 Z" id="Shape"></path>
			                    </g>
				            </g>
				        </g>
				    </g>
				</svg>
				<?php } else {?>
				<svg width="26px" height="23px" viewBox="0 0 26 23" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
				    <g id="Page-1" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
				        <g class="transition PRODUCT-PAGE" transform="translate(-1182.000000, -67.000000)" stroke="#fff" stroke-width="0.75" fill="#000" fill-rule="nonzero">
				            <g transform="translate(-3.000000, 42.000000)">
				                <g transform="translate(1186.000000, 26.000000)">
				                    <path d="M17.2781256,2.4 C19.6781256,2.4 21.6,4.3218756 21.6,6.7218756 C21.6,9.1218756 16.9218756,14.4 12,18.4781256 C7.0781256,14.2781256 2.4,9 2.4,6.7218756 C2.4,4.3218756 4.3218756,2.4 6.7218756,2.4 C9.6,2.4 12,6 12,6 C12,6 14.2781256,2.4 17.2781256,2.4 L17.2781256,2.4 Z M17.2781256,0 C15.1218756,0 13.2,1.0781256 12,2.7609372 C10.8,1.0781256 8.8781256,0 6.7218756,0 C3,0 0,3 0,6.7218756 C0,12 12,21.6 12,21.6 C12,21.6 24,12 24,6.7218756 C24,3 21,0 17.2781256,0 Z" id="Shape"></path>
				                </g>
				            </g>
				        </g>
				    </g>
				</svg>
				<?php } ?>
			</div>
		</div>

		<div class="detail-box">
			<div class="detail-expand-box transition relative">
				品牌故事
				<div class="detail-expand-btn rotate">
					<div></div>
					<div></div>
				</div>
				<p>
					{!!$product->brief!!}
				</p>
			</div>
			<div class="detail-expand-box transition relative">
				尺码信息
				<div class="detail-expand-btn rotate">
					<div></div>
					<div></div>
				</div>
				<p>
					運用低調自在的詮釋方式、簡約設計與收納功能，讓設計與機能並存，滿足每個人對於袋包、配件的需求。
				</p>
			</div>
			<div class="detail-expand-box transition relative">
				Bonza笔记
				<div class="detail-expand-btn rotate">
					<div></div>
					<div></div>
				</div>
				<p>{!!$product->content!!}</p>
			</div>
		</div>
	</div>
</div>
@stop

@section('js-reference')
@stop

@section('js-function')
<script type="text/javascript" src="/assets/js/laypage/laypage.js"></script>
<script type="text/javascript" src="/assets/js/slick/slick.js"></script>
<script type="text/javascript">
	$("#slider").slick({
		lazyLoad: 'ondemand',
	    infinite: true,
	  	slidesToShow: 3,
		slidesToScroll: 2,
		swipeToSlide:true,
		prevArrow: "<div class='pre-arrow arrow'><img src='/assets/img/left.svg'></div>",
		nextArrow: "<div class='nxt-arrow arrow'><img src='/assets/img/right.svg'></div>",
		responsive: [
	    {
		    breakpoint: 769,
		    settings: {
		        slidesToShow: 2,
		        slidesToScroll: 1
		    }
	    }]
  	});

  	$(".nav-button").click(function(){
  		toggleDropdown();
  	});

  	function toggleDropdown() {
  		var height = $(".drop-down li").length * 31 - 1;
    	if ($(".drop-down").height() == 30) {
    		$(".drop-down").height(height);
    	} else {
    		$(".drop-down").height(30);
    	}
    	$("#drop-expand").toggleClass("drop-expand");
  	}

  	$(".detail-expand-box").click(function(){
  		$(this).toggleClass("detail-open");
  		$(this).children(".detail-expand-btn").toggleClass("rotate");
  	})

  	$(".sort-item").click(function(){
  		$("#current-sort").html("&nbsp;&nbsp;&nbsp;&nbsp;"+$(this).html());
  		$("#current-sort").attr('data-size', $(this).attr('data-size'));
  		toggleDropdown();
  	});

  	$("#btn-cart").click(function(){
  		var size = $("#current-sort").attr('data-size');
  		if (size == "") {
  			toggleDropdown();
  		} else {
  			addShoppingBag({!!$product->id!!},size,1)
  		}
  	});
</script>
@stop