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

	<h2 class="title">账户验证{!!$result!!}</h2>
		<div id="login-div">
		<div>点击<a href="/login">这里</a>登录.</div>
		<br><br>
		<?php if ($result == "success") {?>
		<h2 class="subtitle">重置密码</h2>
		<div class="required-label">*此栏为必填</div>
		<form id="reg-form" class="form-horizontal" onsubmit="return resetSubmit()">
			<input name="token" required hidden value="{!!$token!!}">
			<div class="login-input">
				<div class="login-title">新密码 *</div>
				<input name="password" required type='password' minlength="4" maxlength="16" placeholder="请输入您的新密码">
			</div>
			<div class="login-input">
				<div class="login-title">确认新密码 *</div>
				<input name="repeat-password" type='password' minlength="4" maxlength="16" placeholder="请再次输入您的新密码" required>
			</div>
			<div class="login-err">
				<img src="/assets/img/loading.gif"><span></span>
			</div>
			<div>
				<input id="reg-submit" type="submit" class="button login-btn" value="重置">
			</div>
		</form>
		<?php } else {?>
		<div>连接已过期，请点击<a href="/forget-password">这里</a>重新发送邮件。</div>
		<?php } ?>
	</div>
</div>
@stop

@section('js-reference')
@stop

@section('js-function')
<script>
	$(function(){ 
		$("#reg-submit").click(function(){
			if (validator()) {
				$(".login-err img").show();
				$.ajax({
			        type: "POST",
			        url: "/register/reset",
			        data: {
			            password: $('input[name=password]').val(),
			            token: $('input[name=token]').val(),
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
			}
		});

		$("#reg-form input[required]").change(function(){
			$(this).removeClass("input-warning");
		});
	});

	function validator(){
		var result = true;
		$.each($("#reg-form input[required]"), function() {
			if($(this).val() == "" || $(this).val().length < 4) {
				$(this).addClass("input-warning");
				result = false;
			}
		});
		if ($("input[name=repeat-password]").val() !== $("input[name=password]").val()) {
			$("input[name=repeat-password]").addClass("input-warning");
			result = false;
		}
		return result;
	}

	function resetSubmit(){
		return false;
	}

</script>
@stop



