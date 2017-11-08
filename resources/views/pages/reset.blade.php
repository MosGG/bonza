@extends('layouts.pageLayout')

@section('title')<title>Register - Bonza</title>@stop

@section('css-reference')
	<link href="/assets/css/login.css" rel="stylesheet">
@stop

@section('body')
<div id="login-div">
	<div class="wrapper">
		<h2>Token verify {!!$result!!}</h2>
		<div>Click <a href="/login">HERE</a> to login.</div>
		<br><br>
		<?php if ($result == "success") {?>
		<h2>Reset Password</h2>
		<form id="reg-form" class="form-horizontal" onsubmit="return resetSubmit()">
			<input name="token" required hidden value="{!!$token!!}">
			<div class="login-input">
				<div class="login-title">Password*</div>
				<input name="password" required type='password' minlength="4" maxlength="16" placeholder="Please input your password">
			</div>
			<div class="login-input">
				<div class="login-title">Repeat Password*</div>
				<input name="repeat-password" type='password' minlength="4" maxlength="16" placeholder="Please input your password" required>
			</div>
			<div class="login-err">
				<img src="/assets/img/loading.gif"><span></span>
			</div>
			<div>
				<input id="reg-submit" type="submit" class="button login-btn" value="Reset">
			</div>
		</form>
		<?php } else {?>
		<div>Token expired. Please click <a href="/forget-password">Here</a> to send token.</div>
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



