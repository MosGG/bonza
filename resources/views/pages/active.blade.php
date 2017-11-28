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
	<div id="login-div">
		<h2 class="subtitle">激活账户结果：{!!$result!!}</h2>
		<div class="login-input">
			<div class="login-forget"><a href="/login">点击这里登录</a></div>
		</div>
	</div>
</div>
@stop

@section('js-reference')
@stop

@section('js-function')
@stop



