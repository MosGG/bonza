@extends('layouts.pageLayout')

@section('title')<title>Bonza - 登录和注册</title>@stop

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
		<div class="login-remember-box relative">
			<input type="checkbox" name="remember"><span class="checkbox-span"></span><span>记住我</span>
		</div>
		<div class="login-err">
			<img src="/assets/img/loading.gif"><span></span>
		</div>
		<div>
			<input id="login" class="button login-btn" type="button" value="登录">
		</div>
		<div class="login-input">
			<div class="login-forget"><a href="javascript:$('.modal').fadeIn();">忘记密码？</a></div>
		</div>
	</div>

	<div id="reg" class="register-div relative">
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
				<input name="r-password" required type='password' minlength="4" maxlength="16" placeholder="请输入您的密码">
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


<div class="modal">
	<div class="modal-box">
		<img class="close-modal" src="/assets/img/delete.svg" onclick="modalclose()">
		<div class="modal-html-4 layer">
			<h2>操作失败</h2>
			<p id="mh4-msg"></p>
		</div>
		<div class="modal-html-3 layer">
			<h2>电子邮件已发送出</h2>
			<p>设置新密码的链接将以电子邮件发送到<br>
				<span id="mh3-email"></span></p>
			<div class="login-btn" style="margin-top: 160px;" onclick="modalclose()">继续购物</div>
		</div>
		<div class="modal-html-2 layer"> 
			<img id="forget-loading" src="/assets/img/loading.gif">
		</div>
		<div class="modal-html layer">
			<h2>您是否忘记了密码？</h2>
			<p>请输入您的邮箱地址，然后点击“提交”。<br>我们将向您发送一封电邮，其中包含一个链接，您点击后即可创建新的密码。</p>
			<div class="input-des">邮件地址*</div>
			<input id="forget-email" type="text">
			<div id="forget-submit" class="login-btn">提交</div>
		</div>
	</div>
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
			            lastname: $('input[name=lastname]').val(),
			            firstname: $('input[name=firstname]').val(),
			            password: $('input[name=r-password]').val(),
			            address: $('input[name=address]').val(),
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

		$("#forget-submit").click(function(){
			$(".modal-html").fadeOut();
			var email = $('#forget-email').val();
			$.ajax({
		        type: "POST",
		        url: "/forget-password",
		        data: {
		            email: email,
		        },
		        headers: {
		            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		        },
		        dataType: "json",
		        success: function (data) {
		        	if (data.success == "true") {
		        		$("#mh3-email").html(email);
		        		$(".modal-html-2").fadeOut();
		        	} else {
		        		$("#mh4-msg").html(data.msg);
		        		$(".modal-html-2").fadeOut();
		        		$(".modal-html-3").fadeOut();
		        	}
		        },
		        error: function (jqXHR) {
		            alert("Error:" + jqXHR.status + ". Please contact the admin.");
		        },
		        // complete: function () {
		        // 	$("#forget-loading").hide();
		        // }
		    });
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
		if ($("input[name=repeat-password]").val() !== $("input[name=r-password]").val()) {
			$("input[name=repeat-password]").addClass("input-warning");
			result = false;
		}
		return result;
	}

	function regSubmit(){
		return false
	}

	function modalclose(){
		$('.modal').fadeOut();
		setTimeout(function(){
			$('.layer').show();
		}, 500);
	}
</script>
@stop
