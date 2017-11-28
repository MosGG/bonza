@extends('layouts.pageLayout')

@section('title')<title>Login - Fine Food Group</title>@stop

@section('css-reference')
	<link href="/assets/css/login.css" rel="stylesheet">
@stop

@section('body')
<div class="wrapper">
	<div class="breadcrum">
		<a href="/">首页</a>
		<img src="/assets/img/next.svg">
		<a href="/login">登录或注册</a>
	</div>

	<?php if(session('member')) {?>

	<h2 class="title">欢迎回来, {!!session('member')!!}</h2>
	<div class="already-login">
		<p>敬请尽情浏览<a href="/product">我们的商品</a>!</p>
		<p>更多操作：</p>
		<a href="/myaccount"><button class="button login-btn" value="我的账户">我的账户</button></a>
		<br><br>
		<a href="/logout"><button class="button login-btn" value="Logout">登出</button></a>
	</div>

	<?php } else { ?>

	<h2 class="title">登录或立即注册</h2>
	<div id="login-div" class="relative">
		<h2 class="subtitle">登录</h2>
		<div class="required-label">*此栏为必填</div>
		<div class="login-input">
			<div class="login-title">邮箱 *</div>
			<input id="username" type='text' placeholder="请输入您的邮箱">
		</div>
		<div class="login-input">
			<div class="login-title">密码 *</div>
			<input id="password" type='password' placeholder="请输入您的密码">
		</div>
		<div class="login-remember-box">
			<input type="checkbox" name="remember"><span>记住我</span>
		</div>
		<div class="login-err">
			<img src="/assets/img/loading.gif"><span></span>
		</div>
		<div>
			<input id="login" class="button login-btn" type="button" value="登录">
		</div>
		<div class="login-input">
			<div class="login-forget"><a href="/forget-password">忘记密码？</a></div>
		</div>
	</div>

	<div class="register-div relative">
		<h2 class="subtitle">注册新账户</h2>
		<div class="required-label">*此栏为必填</div>
		<form id="reg-form" class="form-horizontal" onsubmit="return regSubmit()">
			{{ csrf_field() }}
			<div class="login-input">
				<div class="login-title">名字 *</div>
				<input name="firstname" type='text' required placeholder="请输入您的名字">
			</div>
			<div class="login-input">
				<div class="login-title">姓氏 *</div>
				<input name="lastname" type='text' required placeholder="请输入您的姓氏">
			</div>
			<div class="login-input">
				<div class="login-title">邮箱 *</div>
				<input name="email" type='email' required placeholder="请输入您的邮箱" required>
			</div>
			<div class="login-input">
				<div class="login-title">确认邮箱 *</div>
				<input name="repeat-email" type='text' required placeholder="请再次输入您的邮箱">
			</div>
			<div class="login-input">
				<div class="login-title">密码 *</div>
				<input name="password" required type='password' minlength="4" maxlength="16" placeholder="请输入您的密码">
			</div>
			<div class="login-input">
				<div class="login-title">确认密码 *</div>
				<input name="repeat-password" type='password' minlength="4" maxlength="16" placeholder="请再次输入您的密码" required>
			</div>
			<div class="login-input">
				<a href="/terms" target="_blank"><div class="login-title reg-policy">隐私条款</div></a>
			</div>
			<div class="login-err">
				<img src="/assets/img/loading.gif"><span></span>
			</div>
			<div>
				<input id="reg-submit" type="submit" class="button login-btn" value="注册">
			</div>
		</form>
	</div>

	<?php }?>
</div>



@stop

@section('js-reference')
@stop

@section('js-function')
<script>
	$("#login").click(function(){
		$("#login-div .login-err img").show();
		$("#login-div .login-err span").html("");
		$.ajax({
	        type: "POST",
	        url: "/login",
	        data: {
	            username: $('#username').val(),
	            password: $('#password').val(),
	            remember: $('input[name="remember"]')[0].checked,
	        },
	        headers: {
	            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
	        },
	        dataType: "json",
	        success: function (data) {
	            $("#login-div .login-err span").html(data.msg);
	            if (data.success == "true") {
	            	location.href = "{!!$req_url!!}";
	            }
	        },
	        error: function (jqXHR) {
	            alert("Error:" + jqXHR.status + ". Please contact the admin.");
	        },
	        complete: function () {
	        	$("#login-div .login-err img").hide();
	        }
	    });
	});


	$(function(){
		// $("input,select,textarea").not("[type=submit]").jqBootstrapValidation();
		$("#reg-submit").click(function(){
			if (validator()) {
				$(".register-div .login-err img").show();
				$(".register-div .login-err span").html("");
				$.ajax({
			        type: "POST",
			        url: "/register",
			        data: {
			        		email: $('input[name=email]').val(),
									firstname: $('input[name="firstname"]').val(),
									lastname: $('input[name="lastname"]').val(),
			            password: $('input[name=password]').val(),
			            mobile: $('input[name=mobile]').val(),
			        },
			        headers: {
			            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			        },
			        dataType: "json",
			        success: function (data) {
			            $(".register-div .login-err span").html(data.msg);
			        },
			        error: function (jqXHR) {
			            alert("Error:" + jqXHR.status + ". Please contact the admin.");
			        },
			        complete: function () {
			        	$(".register-div .login-err img").hide();
			        }
			    });
			}
		});

		$("#reg-form input[required]").change(function(){
			$(this).removeClass("input-warning");
		});
	});

	function validator(){
		var result = true;
		$.each($("#reg-form input[required]"), function() {
			if($(this).val() == "") {
				$(this).addClass("input-warning");
				result = false;
			}
		});
		var myreg = /^[a-z0-9]+([._\\-]*[a-z0-9])*@([a-z0-9]+[-a-z0-9]*[a-z0-9]+.){1,63}[a-z0-9]+$/;
		if (!myreg.test($("input[name=email]").val())) {
			$(this).addClass("input-warning");
			result = false;
		}
		if ($("input[name=repeat-email]").val() !== $("input[name=email]").val()) {
			$("input[name=repeat-email]").addClass("input-warning");
			result = false;
		}
		if ($("input[name=repeat-password]").val() !== $("input[name=password]").val()) {
			$("input[name=repeat-password]").addClass("input-warning");
			result = false;
		}
		return result;
	}

	function regSubmit(){
		return false
	}
</script>
@stop
