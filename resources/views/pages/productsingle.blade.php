@extends('layouts.pageLayout')

@section('title')<title>{!!$product->title!!} - Bonza</title>@stop

@section('css-reference')
<link href="/assets/css/productsingle.css" rel="stylesheet">
<link href="/assets/js/slick/slick.css" rel="stylesheet">
@stop

@section('body')
<div class="wrapper">
	<div class="breadcrum">
		<a href="/">首页</a>
		<img src="/assets/img/next.svg">
		<a href="/product">选购</a>
		<img src="/assets/img/next.svg">
		<a href="/category/{!!$product->category!!}">{!!$product->category!!}</a>
	</div>

	<div id="slider">
		<?php 
		foreach($imgs as $img){
			echo "<img src='".$img."'>";
		}
		?>
		<img src="/assets/img/default.png">
		<img src="/assets/img/default.png">
		<img src="/assets/img/default.png">
		<img src="/assets/img/default.png">
		<img src="/assets/img/default.png">
	</div>
</div>
@stop

@section('js-reference')
@stop

@section('js-function')
<script type="text/javascript" src="/assets/js/laypage/laypage.js"></script>
<script type="text/javascript" src="/assets/js/slick/slick.js"></script>
<script type="text/javascript">
	$("#slider").slick({
		lazyLoad: 'ondemand',
	    infinite: true,
	  	slidesToShow: 3,
		slidesToScroll: 2,
		swipeToSlide:true,
		prevArrow: "<div class='pre-arrow arrow'><img src='/assets/img/left.svg'></div>",
		nextArrow: "<div class='nxt-arrow arrow'><img src='/assets/img/right.svg'></div>",
		responsive: [
	    {
		    breakpoint: 769,
		    settings: {
		        slidesToShow: 2,
		        slidesToScroll: 1
		    }
	    }]
  	});
</script>
@stop