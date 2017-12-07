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
				<a href="/designers"><div>品牌</div></a>
				<a href="javascript:;"><div class="m-menu-second relative">选购
					<img class="m-nav-next" src="/assets/img/m-nav-next.svg"></div></a>
				<a href="/about"><div>关于BONZA</div></a>
			</div>
			<div class="m-nav-down">
				<?php if (!empty(session('member_id'))) { ?>
				<a href="/myaccount"><div>我的账户</div></a>
				<?php } else {?>
				<a href="/login#reg"><div>注册</div></a>
				<a href="/login"><div>登录</div></a>
				<?php } ?>
			</div>
		</div>

		<div class="m-nav-second transition">
			<a href="javascript:;" onclick="mMenuBack()"><div class="m-n-s-back relative">
			 	<img src="/assets/img/m-nav-back.svg">
				返回首页
			</div></a>
			<div class="m-n-s-title">选购</div>
			<div class="m-n-s-menu">
				<a href="/product"><div>全部产品</div></a>
				<?php 
				foreach ($category as $c) {
					echo "<a href='/product/category/".$c->id."'><div>".$c->name."</div></a>";
				}
				?>
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
					<a href="/"><img id="logo" class="center" src="/assets/img/bonza.svg"></a>
					<div class="right vertical-middle icons">
						<a class="m-hide-icon relative" href='/myaccount'>
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
								echo " >";
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
						<a href="/designers"><span class="hvr-underline-from-center
							<?php 
								if (isset($action) && $action == 'designers') echo "action-selected";
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
	<script>
		member = "{!!session('member')!!}";
	</script>
	@yield('js-function')
</html>
