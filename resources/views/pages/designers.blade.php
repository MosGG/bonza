@extends('layouts.pageLayout')

@section('title')<title>Bonza - 品牌</title>@stop

@section('css-reference')
	<link href="/assets/css/designers.css" rel="stylesheet">
@stop

@section('body')
<div class="wrapper">
	<h2>A - Z 品牌</h2>
	<div class="index-box">
		<?php 
			foreach ($designers as $key => $value) {
				echo '<div class="index ';
				if (empty($value)) {
					echo 'd-null';
				}
				echo '">'.$key.'</div>';
			}
		?>
	</div>
	<div class="designers-box relative">
		<div id="underline" class="transition"></div>
		<?php 
			foreach ($designers as $key => $value) {
				echo '<div id="'.$key.'" class="d-item transition">';
				echo '<div class="d-title ';
				if (empty($value)) {
					echo 'd-null';
				}
				echo '">'.$key.'</div>';
				foreach ($value as $d) {
					echo '<div class="d-designer"><a href="/designers/'.$d.'"><span>'.$d.'</span></a></div>';
				}
				echo '</div>';
			}
		?>
	</div>
</div>
@stop

@section('js-reference')
@stop

@section('js-function')
<script type="text/javascript">
	$(".index").hover(function(){
		var id = "#" + $(this).html();
		$(".d-item").not(id).addClass('de-selected');
	},function(){
		$(".d-item").removeClass('de-selected');
	});

	$(".d-designer span").hover(function(){
		var top = $(this).position().top  + 25;
		var left = $(this).position().left;
		var width = $(this).width();
		$("#underline").width(width).css("top", top).css("left", left);
	},function(){

	});
</script>
@stop



