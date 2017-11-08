@extends('layouts.pageLayout')

@section('title')<title>Login - Fine Food Group</title>@stop

@section('css-reference')
	<link href="/assets/css/login.css" rel="stylesheet">
@stop

@section('body')
<div id="login-div">
	<div class="wrapper">
		<h2>{!!$result!!}</h2>
		<h2>Please Click <a href="/login">HERE</a> to login.</h2>
	</div>
</div>
@stop

@section('js-reference')
@stop

@section('js-function')
@stop



