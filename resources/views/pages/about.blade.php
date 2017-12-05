@extends('layouts.pageLayout')

@section('title')<title>Bonza - 关于BONZA</title>@stop

@section('css-reference')
	<link href="/assets/css/about.css" rel="stylesheet">
@stop

@section('body')
<div class="banner">
	<div class="wrapper">
		<div class="breadcrum">
			<a href="/">首页</a>
			<img src="/assets/img/next.svg">
			<a href="/about">关于BONZA</a>
		</div>
	</div>
</div>
<div class="wrapper about-content">
	<h2>BONZA的品牌故事</h2>
	<h3>BONZA</h3>
	<div class="short-border"></div>
	<p>—<br>致力于寻找高端的时尚，挖掘年轻优秀品牌，提供搭配理念。我们相信，真正好的时尚设计并不是人云亦云，而是绽放自己。</p>
	<div class="ac-des-box">
		<div class="ac-des ac-left">
			<h4>BONZA的由来</h4>
			<p>BONZA AUSTRALIA澳洲时尚网站是由两位在澳大利亚定居多年的女士于2017年创立。BONZA一词源于当地语言，意为优秀华丽，强大。这也是两位创始人做网站的设想——兼具优秀的购物平台服务和美好的时尚审读，打造新时代强大女性。</p>
		</div>
		<div class="ac-des ac-right">
			<h4>澳洲时尚的崛起</h4>
			<p>随着澳洲时尚近几年在世界舞台大放异彩，相比较起日韩可爱俏皮风格，越来越多的人更加倾向于大气兼容性感的澳洲时尚，越来越多的人开始领会到了那种与天然环境完美融合、充满张力的设计之美。</p>
		</div>
		<div class="ac-des ac-left">
			<h4>澳洲的时尚风格</h4>
			<p>澳洲政府更加大力的扶持本土设计师品牌，这为为设计师们提供了良好的创作环境，由此每年涌现的优秀设计师新品牌源源不断。不同于国内以清纯甜美风作为穿衣的主流，澳洲的穿衣风格会更偏向欧美，性感为主，舒适简洁大气利落。比起品牌效应，人们更看重设计感。</p>
		</div>
		<div class="ac-des ac-right">
			<h4>将澳洲时尚带给大家</h4>
			<p>凭着对时尚敏锐的嗅觉，尤其在切身了解了很多澳洲本土小众品牌之后，BONZA AUSTRALIA创始人看到了澳洲时尚前景，这种设计的本真和对自由浪漫的狂热深深的触动了她们。</p>
		</div>
	</div>
	<div class="ac-link"><a href="/product"><span>开启BONZA的时尚之旅</span></a></div>
</div>
@stop

@section('js-reference')
@stop

@section('js-function')
@stop