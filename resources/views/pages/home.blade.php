@extends('layouts.pageLayout')

@section('title')<title>Bonza - 我的账户</title>@stop

@section('css-reference')
	<link href="/assets/css/myaccount.css" rel="stylesheet">
@stop

@section('body')

<div class="wrapper" style="margin-bottom: 100px;">
	<div class="breadcrum">
		<a href="/">首页</a>
		<img src="/assets/img/next.svg">
		<a href="/myaccount">我的账户</a>
	</div>

	<?php
		// $res = XeroPrivate::load('Accounting\\Organisation')->execute();
		// var_dump($r->getRegistrationNumber());
		// foreach ($res as $r){
			
		// 	$r->setRegistrationNumber('11111111139');

		// 	var_dump($r->getRegistrationNumber());
		// 	$r->save();
		// }

		
	?>
</div>
@stop

@section('js-reference')
@stop

@section('js-function')
<script>
</script>
@stop