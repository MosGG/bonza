@extends('layouts.pageLayout')

@section('title')<title>Register - Bonza</title>@stop

@section('css-reference')
	<link href="/assets/css/login.css" rel="stylesheet">
@stop

@section('body')
<div id="login-div">
	<div class="wrapper">
		<h2>Register</h2>
		<form id="reg-form" class="form-horizontal" onsubmit="return regSubmit()">
			{{ csrf_field() }}
			<div class="login-input">
				<div class="login-title">Email*</div>
				<input name="email" type='email' required placeholder="Please input your Email" required>
			</div>
			<div class="login-input">
				<div class="login-title">Username</div>
				<input name="username" type='text' placeholder="Please input your username">
			</div>
			<div class="login-input">
				<div class="login-title">Password*</div>
				<input name="password" required type='password' minlength="4" maxlength="16" placeholder="Please input your password">
			</div>
			<div class="login-input">
				<div class="login-title">Repeat Password*</div>
				<input name="repeat-password" type='password' minlength="4" maxlength="16" placeholder="Please input your password" required>
			</div>
			<div class="login-input">
				<div class="login-title">Address</div>
				<input name="address" type='text' placeholder="Please input your Address">
			</div>
			<div class="login-input">
				<div class="login-title">Mobile</div>
				<input name="mobile" type='text' placeholder="Please input your Mobile">
			</div>
			<div class="login-err">
				<img src="/assets/img/loading.gif"><span></span>
			</div>
			<div>
				<input id="reg-submit" type="submit" class="button login-btn" value="Register">
			</div>
		</form>
	</div>
</div>
@stop

@section('js-reference')
<script src="/assets/js/jqBootstrapValidation.js"></script>
@stop

@section('js-function')
<script>
	$(function(){ 
		// $("input,select,textarea").not("[type=submit]").jqBootstrapValidation(); 
		$("#reg-submit").click(function(){
			if (validator()) {
				$(".login-err img").show();
				$.ajax({
			        type: "POST",
			        url: "/register",
			        data: {
			        	email: $('input[name=email]').val(),
			            username: $('input[name=username]').val(),
			            password: $('input[name=password]').val(),
			            address: $('input[name=address]').val(),
			            mobile: $('input[name=mobile]').val(),
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
		var myreg = /^[a-z0-9]+([._\\-]*[a-z0-9])*@([a-z0-9]+[-a-z0-9]*[a-z0-9]+.){1,63}[a-z0-9]+$/;
		if (!myreg.test($("input[name=email]").val())) {
			$(this).addClass("input-warning");
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



