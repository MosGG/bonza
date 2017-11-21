<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="description" content="">
	<meta name="author" content="Bonza">
	<meta name="keywords" content="">
	<meta name="csrf-token" content="{{ csrf_token() }}">

	@yield('title')

	<!-- Favicons -->
	<link rel="shortcut icon" href="assets/img/favicon.ico">
	<link rel="apple-touch-icon" href="assets/img/apple-touch.png">
	<link rel="apple-touch-icon" sizes="72x72" href="assets/img/apple-touch.png">
	<link rel="apple-touch-icon" sizes="114x114" href="assets/img/apple-touch.png">

	<!-- Reset CSS -->
	<link href="/assets/css/reset.css" rel="stylesheet">
	<link href="/assets/css/font-awesome.min.css" rel="stylesheet">
	<link href="/assets/css/auto-complete.css" rel="stylesheet">
	<link href="/assets/css/bonza.css" rel="stylesheet">


	@yield('css-reference')

</head>
<body>
	<!-- PRELOADER -->
	<!-- <div class="page-loader">
		<div class="loader">Loading...</div>
	</div> -->
	<!-- /PRELOADER -->

	<div class="m-wrapper transition">
		<div class="m-nav transition">
			<div class="m-nav-up">
				<a href="/newarrival"><div>新品</div></a>
				<a href="/brand"><div>品牌</div></a>
				<a href="javascript:;"><div class="m-menu-second relative">选购
					<img class="m-nav-next" src="/assets/img/m-nav-next.svg"></div></a>
				<a href="/about"><div>关于BONZA</div></a>
			</div>
			<div class="m-nav-down">
				<a href="/register"><div>注册</div></a>
				<a href="/login"><div>登录</div></a>
			</div>
		</div>

		<div class="m-nav-second transition">
			<a href="javascript:;" onclick="mMenuBack()"><div class="m-n-s-back relative">
			 	<img src="/assets/img/m-nav-back.svg">
				返回首页
			</div></a>
			<div class="m-n-s-title">选购</div>
			<div class="m-n-s-menu">
				<a href="#"><div>全部产品</div></a>
				<a href="#"><div>上装</div></a>
				<a href="#"><div>下装</div></a>
				<a href="#"><div>外套</div></a>
				<a href="#"><div>连衣裙</div></a>
				<a href="#"><div>鞋履</div></a>
				<a href="#"><div>配饰</div></a>
				<a href="#"><div>护肤</div></a>
			</div>
		</div>

		<div class="m-search">
			<div class="m-search-typein relative">
				<form class="" action="/search" method="post">
					<input id="m-search-input" name="search" type="text" placeholder="您在寻找什么...">
				</form>
				<img id="m-search-clear" class="vertical-middle" src="/assets/img/clear-search.svg">
				<div onclick="close_search();">取消</div>
			</div>
			<div class="search-result"></div>
		</div>

		<div class="m-shade"></div>
		<div class="m-body">
		<!-- header -->
		<header>
			<div class="top-header">
				<div class="wrapper">
					<div class="header-tel">每周7天，全天24小时随时与我们联系：<a href="tel:1300737646">1300 737 646</a><span class="header-m-weixin"> | <a onclick="$('.qrcode').fadeIn();">微信公众号</a></span></div>
				</div>
			</div>
			<div class="mid-header">
				<div class="wrapper relative">
					<div class="header-weixin left vertical-middle" onclick="$('.qrcode').fadeIn();">
						<img src="/assets/img/weixin.svg">
						<div class="weixin-text">微信公众号</div>
					</div>
					<div class="m-menu left vertical-middle">
						<img src="/assets/img/m-menu.svg">
					</div>
					<img id="logo" class="center" src="/assets/img/bonza.svg">
					<div class="right vertical-middle icons">
						<a class="m-hide-icon relative"
						<?php
							if (empty(session("member"))) {
								echo "href='/login'";
							} else {
								echo "href='/myaccount'";
							}
						?>
						>
							<img class="hover-icon" data-hover="/assets/img/login-hover.svg" src="/assets/img/login-icon.svg">
						</a>
						<a class="m-hide-icon relative" href="/wishlist">
							<div class="wishlist-num"
							<?php
							if (empty(session('wishlist'))) {
								echo " hidden>";
							} else {
								echo ">".count(session('wishlist'));
							}?>
							</div>
							<img class="hover-icon" data-hover="/assets/img/wishlist-icon-hover.svg" src="/assets/img/wishlist-icon.svg">
						</a>
						<a class="relative" href="/shoppingbag">
							<div class="shopping-num"
							<?php
							if (empty(session('shopping-bag'))) {
								echo " hidden>";
							} else {
								echo ">".count(session('shopping-bag'));
							}?>
							</div>
							<img id="shopping_bag" class="hover-icon" data-hover="/assets/img/bag-hover.svg" src="/assets/img/shopping-bag-icon.svg">
						</a>
						<a class="relative search-icon" href="javascript:;" onclick="open_search();">
							<img class="hover-icon" data-hover="/assets/img/search-hover.svg" src="/assets/img/search-icon.svg">
						</a>
					</div>
					<div class="bag-buy">
						<div class="buy-up">
							<div class="buy-wrap">
								<div class="buy-total">购物袋 <b>1</b> 件商品</div>
								<div class="buy-detail">
									<img class="bd-product-img" src="/assets/img/default.png">
									<div class="buy-detail-right relative">
										<img class="bag-delete" src="/assets/img/bag-delete.svg">
										<span class="buy-detail-title">VETEMENTS</span><br>
										<p class="buy-detail-des">分层式印花棉质混纺平纹针织连帽卫衣</p>
										<span class="p-meta">
											<!-- <div class="p-color" style="background-color: #000;"></div> -->
											黑色
										</span><br>
										<span class="p-meta">尺码：<b>{!!"M"!!}</b></span><br>
										<span class="p-meta">数量：<b>{!!"1"!!}</b></span><br>
										<div class="p-price">{!!"￥4,450.00"!!}</div>
									</div>
								</div>
							</div>
						</div>
						<div class="buy-bottom">
							<div class="buy-wrap">
								<span class="buy-subtotal">商品总金额（不包含运费）<b>{!!"￥4,450.00"!!}</b></span>
								<a href="/shopping-cart"><div class="buy-btn go-shoppingbag">查看购物袋</div></a>
								<a href="/checkout"><div class="buy-btn go-order">结算</div></a>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="bottom-header relative">
				<div class="wrapper relative">
					<div class="center sub-nav">
						<a href="/newarrival"><span class="hvr-underline-from-center
							<?php
								if (isset($action) && $action == 'newarrival') echo "action-selected";
							?>
							">新品</span></a>
						<a href="/brand"><span class="hvr-underline-from-center
							<?php
								if (isset($action) && $action == 'brand') echo "action-selected";
							?>
							">品牌</span></a>
						<a href="/product"><span class="hvr-underline-from-center
							<?php
								if (isset($action) && $action == 'product') echo "action-selected";
							?>
							">选购</span></a>
						<a href="/about"><span class="hvr-underline-from-center
							<?php
								if (isset($action) && $action == 'about') echo "action-selected";
							?>
							">关于BONZA</span></a>
					</div>
					<form class="search-box transition" action="/search" method="post">
						<input id="search-input" name="search" type="text" class="transition" placeholder="搜索">
						<a href="javascript:void(0);" onclick="$('.search-box').submit();"><img src="/assets/img/search.svg"></a>
					</form>
				</div>
			</div>
		</header>

		<div class="body-content">
			@yield('body')
		</div>
		<div class="qrcode" onclick="$('.qrcode').fadeOut();">
			<img src="/assets/img/qrcode.png">
		</div>

		<!-- FOOTER -->
		<footer>
			<div class="topfooter">
				<div class="wrapper">
					<img src="/assets/img/bonza.svg">
				</div>
			</div>
			<div class="middlefooter">
				<div class="wrapper">
					<div class="mid-footer-content relative transition">
						<div class="m-service-info">
							<span class="left">服务信息</span>
							<img class="right" src="/assets/img/expand.svg">
						</div>
						<div class="footer-links flinks-1">
							<a href="/help" target="_blank"><span>联系客服</span></a>
							<a href="/recruitment" target="_blank"><span>招聘求职</span></a>
						</div>
						<div class="footer-links flinks-2">
							<a href="/deliver" target="_blank"><span>配送信息</span></a>
							<a href="/refund" target="_blank"><span>退换货信息</span></a>
						</div>
						<div class="footer-links flinks-3">
							<a href="/term" target="_blank"><span>服务条款</span></a>
							<a href="/privacy" target="_blank"><span>隐私政策</span></a>
						</div>
						<div class="weixin-gzh transition" onclick="$('.qrcode').fadeIn();">
							<img class="vertical-middle gzh1" src="/assets/img/weixin-2.svg">
							<span class="vertical-middle gzh2">关注微信公众号</span>
							<img class="vertical-middle gzh3" src="/assets/img/arrow.svg">
						</div>
					</div>
				</div>
			</div>
			<div class="downfooter relative">
				<div class="wrapper">
					<div id="copyright" class="vertical-middle">
						<i class="fa fa-copyright" aria-hidden="true"></i> 2017 BONZA, All Rights Reserved.
					</div>
				</div>
			</div>
		</footer>
		<!-- /FOOTER -->
		</div>
	</div>


	@yield('modal')

	<!-- SCROLLTOP -->
	<a href="javascript:scrolltotop();">
		<div class="scroll-up transition">
			<i class="fa fa-angle-up"></i>
		</div>
	</a>

	<!-- Javascript files -->
	<script src="/assets/js/jquery-3.2.0.min.js"></script>
	<script src="/assets/js/auto-complete.min.js"></script>
	<script src="/assets/js/bonza.js"></script>
	@yield('js-reference')

</body>
	@yield('js-function')
</html>
