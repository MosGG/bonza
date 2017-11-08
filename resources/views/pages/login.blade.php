@extends('layouts.pageLayout')

@section('title')<title>Login - Fine Food Group</title>@stop

@section('css-reference')
	<link href="/assets/css/login.css" rel="stylesheet">
@stop

@section('body')
<div id="login-div">
	<div class="wrapper">
		<?php if(session('member')) {?>
		<h2>Welcome Back, {!!session('member')!!}</h2>
		<div>
			<a href="/logout"><button class="button login-btn" value="Logout">Logout</button></a>
		</div>
		<?php } else {?>
		<h2>Login</h2>
		<div class="login-input">
			<div class="login-title">Username</div>
			<input id="username" type='text' placeholder="Please input your username">
		</div>
		<div class="login-input">
			<div class="login-title">Password</div>
			<input id="password" type='password' placeholder="Please input your password">
		</div>
		<div class="login-err">
			<img src="/assets/img/loading.gif"><span></span>
		</div>
		<div>
			<input class="button login-btn" type="button" value="Login">
		</div>
		<div class="login-input">
			<div class="login-title"><a href="/forget-password">Forget your password?</a></div>
		</div>
		<?php }?>
	</div>
</div>
@stop

@section('js-reference')
@stop

@section('js-function')
<script>
	$(".login-btn").click(function(){
		$(".login-err img").show();
		$.ajax({
	        type: "POST",
	        url: "/login",
	        data: {
	            username: $('#username').val(),
	            password: $('#password').val(),
	        },
	        headers: {
	            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
	        },
	        dataType: "json",
	        success: function (data) {
	            $(".login-err span").html(data.msg);
	            if (data.success == "true") {
	            	location.href = "{!!URL::previous()!!}"
	            }
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



