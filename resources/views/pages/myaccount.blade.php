@extends('layouts.pageLayout')

@section('title')<title>Bonza - My Account</title>@stop

@section('css-reference')
	<link href="/assets/css/login.css" rel="stylesheet">
@stop

@section('body')
<div id="login-div">
	<div class="wrapper">
		<h2>My Account</h2>
		<div>
			<a href="/logout"><button class="button login-btn" value="Logout">Logout</button></a>
		</div>
	</div>
</div>
@stop

@section('js-reference')
@stop

@section('js-function')
<script>
</script>
@stop



