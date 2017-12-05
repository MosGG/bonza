@extends('layouts.pageLayout')

@section('title')<title>Bonza - 我的账户</title>@stop

@section('css-reference')
	<link href="/assets/css/myaccount.css" rel="stylesheet">
@stop

@section('body')

<div class="wrapper" style="margin-bottom: 100px;">
	<div class="breadcrum">
		<a href="/">首页</a>
		<img src="/assets/img/next.svg">
		<a href="/myaccount">我的账户</a>
	</div>

	<h2 class="title">我的账户</h2>
	<p class="welcome-p">
		欢迎您 {!!$username!!}，这是您的Bonza账户。点击进入以下各部分，即可管理个人信息、退换货品、查看订单或礼品卡状态。
	</p>

	<div class="ctl-box relative">
		<a href="/myaccount/addressbook"><div class="menu">
			<img src="/assets/img/m1.svg" class="my-icon">
			<h3>邮寄地址</h3>
			<p>添加或修改账单地址与送货地址</p>
		</div></a>
		<a href="/myaccount/accountinfo"><div class="menu">
			<img src="/assets/img/m2.svg" class="my-icon">
			<h3>账户信息</h3>
			<p>查看或修改您的登录信息</p>
		</div></a>
		<a href="/myaccount/order"><div class="menu">
			<img src="/assets/img/m3.svg" class="my-icon">
			<h3>我的订单</h3>
			<p>退换货品、追踪配送状态、查看订单记录</p>
		</div></a>
		<a href="/wishlist"><div class="menu">
			<img src="/assets/img/m4.svg" class="my-icon">
			<h3>愿望清单</h3>
			<p>查看愿望清单、加入心爱商品、整理愿望清单、购买清单商品</p>
		</div></a>
		<a href="/myaccount/wechat"><div class="menu">
			<img src="/assets/img/m5.svg" class="my-icon">
			<h3>微信绑定</h3>
			<p>及时获得新品推送和折扣信息</p>
		</div></a>
		<a href="/logout"><div id="logout" class="transition">退出</div></a>
		<img id="ctl-box-img" src="/assets/img/myaccount.png">
	</div>
</div>
@stop

@section('js-reference')
@stop

@section('js-function')
<script>
</script>
@stop
