@extends('layouts.pageLayout')

@section('title')<title>Login - Fine Food Group</title>@stop

@section('css-reference')
	<link href="/assets/css/login.css" rel="stylesheet">
@stop

@section('body')
<div id="login-div">
	<div class="wrapper">
		<h2>Forget Password</h2>
		<div class="login-input">
			<div class="login-title">Email</div>
			<input id="username" type='text' placeholder="Please input your email address">
		</div>
		<div class="login-err">
			<img src="/assets/img/loading.gif"><span></span>
		</div>
		<div>
			<input class="button login-btn" type="button" value="Forget">
		</div>
		<div class="login-input">
			<div class="login-title"><a href="/login">Click here to Sign In</a></div>
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
		$.ajax({
	        type: "POST",
	        url: "/forget-password",
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



