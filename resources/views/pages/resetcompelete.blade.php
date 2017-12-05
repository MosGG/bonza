@extends('layouts.pageLayout')

@section('title')<title>Bonza - 重置密码</title>@stop

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

	<h2 class="title">密码已更改</h2>
	<div class="reset-div">
		<br><br><br><h3 class="">您的密码已修改成功</h3><br><br>
		<div>如欲使用新的密码登录，请 点击此处 或在页顶菜单点击“登录”。</div>
		<br><br><br><br><br>
		<a href="/login"><div id="reset-c-btn" class="login-btn"><a href="/login">立即登录</a></div>
	</div>
</div>
@stop

@section('js-reference')
@stop

@section('js-function')
@stop



