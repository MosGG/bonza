@extends('layouts.pageLayout')

@section('title')<title>Bonza - 激活账户</title>@stop

@section('css-reference')
	<link href="/assets/css/login.css" rel="stylesheet">
@stop

@section('body')

<div class="wrapper" style="overflow: hidden;margin-bottom: 160px;">
	<div class="breadcrum">
		<a href="/">首页</a>
		<img src="/assets/img/next.svg">
		<a href="/register/reactive">激活账户</a>
	</div>

	<h2 class="title">激活账户</h2>
	<div class="reset-div relative reset-sm-div">
		<h2 class="subtitle">请输入您的邮箱</h2>
		<div class="required-label">*此栏为必填</div>
		<div class="login-input">
			<div class="login-title">邮箱 *</div>
			<input id="username" type='text' required placeholder="请输入您的邮箱">
		</div>
		<div class="login-err">
			<img src="/assets/img/loading.gif"><span></span>
		</div>
		<div style="margin-top: 30px;">
			<input class="button login-btn" type="button" value="提交">
		</div>
		<div class="login-input">
			<div class="login-forget"><a href="/login">点击这里登录</a></div>
		</div>
	</div>
</div>

@stop

@section('js-reference')
@stop

@section('js-function')
<script>
	$(".login-btn").click(function(){
		$(".login-err img").show();
		$(".login-err span").html("");
		$.ajax({
	        type: "POST",
	        url: "/register/reactive",
	        data: {
	            email: $('#username').val(),
	        },
	        headers: {
	            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
	        },
	        dataType: "json",
	        success: function (data) {
	            $(".login-err span").html(data.msg);
	        },
	        error: function (jqXHR) {
	            alert("Error:" + jqXHR.status + ". Please contact the admin.");
	        },
	        complete: function () {
	        	$(".login-err img").hide();
	        }
	    });
	});
</script>
@stop