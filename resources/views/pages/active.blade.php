@extends('layouts.pageLayout')

@section('title')<title>Bonza - 激活账户</title>@stop

@section('css-reference')
	<link href="/assets/css/login.css" rel="stylesheet">
@stop

@section('body')
<div class="wrapper single-login-page">
	<div class="breadcrum">
		<a href="/">首页</a>
		<img src="/assets/img/next.svg">
		<a href="/login">登录或注册</a>
	</div>

	<h2 class="title">激活账户</h2>
	<div class="reset-div">
		<br>
		<?php if($result == "failed") {?>
		<h3>激活账户失败</h3>
		<br>
		<br>
		<p>链接不正确或者已失效，请检查您的链接是否正确。<br>
			如需重新发送激活邮件，请点击<a href="/register/reactive">这里</a>。</p>
		<br>
		<br>
		<?php } else {?>
			<h3>激活账户成功</h3>
			<br>
			<br>
			<p>您已成功验证邮箱并激活账户。</p>
			<div class="login-btn" style="max-width: 270px;margin:100px auto;"><a href="/login">点击这里登录</a></div>
		<?php }?>
	</div>
</div>
@stop

@section('js-reference')
@stop

@section('js-function')
@stop



