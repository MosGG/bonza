@extends('layouts.pageLayout')

@section('title')<title>Product - Bonza</title>@stop

@section('css-reference')
<link href="/assets/css/product.css" rel="stylesheet">
<link href="/assets/css/newarrival.css" rel="stylesheet">
@stop

@section('body')
<?php 
	$wishlist = array(); 
	if (!empty(session('wishlist'))) {
		foreach (session('wishlist') as $value) {
			$wishlist[$value['id']] = true;
		}
	}
?>
<div class="wrapper">
	<div class="total-number">
		<span class="total-number-content">
			<?php 
				if ($meta['items_per_page'] > $meta['total']) {
					echo "<b>".$meta['total']."</b> / ".$meta['total']."个结果";
				} else {
					echo "<b>".$meta['items_per_page']."</b> / ".$meta['total']."个结果";
				}
			?>
		</span>
	</div>
	<div class="page-control relative">
	  	<nav>
		  	<ul class="drop-down relative closed">
		  		<img id="drop-expand" class="transition nav-button" src="/assets/img/next.svg">
			    <li><a href="javascript:void(0);" id="current-sort" class="nav-button">排序方式</a></li>
			    <li class="srot-select"><a href="#" class="sort-item">最新上架</a></li>
			    <li><a href="#" class="sort-item">价格从低到高</a></li>
			    <li><a href="#" class="sort-item">价格从高到底</a></li>
			    <li><a href="#" class="sort-item">销量从低到高</a></li>
			    <li><a href="#" class="sort-item">销量从高到底</a></li>
		  	</ul>
		</nav>
		<div class="item-per-page">
			<div class="ipp-title">产品<br>每页</div>
			<a href="javascript:;"><div class="ipp-num 
				<?php if ($meta['items_per_page'] == '24') echo "ipp-active";?>
				">24</div></a>
			<a href="javascript:;"><div class="ipp-num
				<?php if ($meta['items_per_page'] == '36') echo "ipp-active";?>
				">36</div></a>
			<a href="javascript:;"><div class="ipp-num
				<?php if ($meta['items_per_page'] == '48') echo "ipp-active";?>
				">48</div></a>
		</div>
		<div id='layPage' class='laypage'></div>
	</div>
	<div class="product-content">
		<div class="pc-right">
			<?php foreach($product as $p) {?>
			<div class="pc-item">
				<a href="/product/{!!$p->id!!}">
					<div class="item-up relative">
						<div class="hover-shade transition"></div>
						<img class="item-img transition" src="/assets/img/default.png">
					</div>
				</a>
				<div class="item-info">
					<a onclick="addwishlist({!!$p->id!!})" href="jsvascript:void(0);">
						<img class="item-wishlist hover-icon" data-hover="/assets/img/wishlist-add-hover.svg" 
						<?php 
							if (isset($wishlist[$p->id])) {
								echo "src='/assets/img/wishlist-add-hover.svg'";
							} else {
								echo "src='/assets/img/wishlist-add.svg'";
							}
						?>
						>
					</a>
					<a href="/product/1">
						<div class="item-title">VETEMENTS</div>
						<div class="item-des">分层式印花棉质混纺平纹针织连帽卫衣</div>
						<div class="item-price">￥4,450.00</div>
					</a>
				</div>
			</div>
			<?php }?>
		</div>
	</div>
	<div class="page-control bottom-control relative">
		<div id='layPage2' class='laypage'></div>
	</div>
	<div class="bottom-margin"></div>
</div>
<div class="m-page-ctl relative">
	<span class="center">第{!!$meta['page']!!}/{!!$meta['allPages']!!}页</span>
	<div id='layPage3'></div>
</div>
<?php 
 	//qurey string to array
	$str = isset($_SERVER['QUERY_STRING'])?$_SERVER['QUERY_STRING']:"";
	parse_str($str, $qurey);
	if (empty($qurey["item"])) $qurey["item"] = 24;
?>
@stop

@section('js-reference')
@stop

@section('js-function')
<script type="text/javascript" src="/assets/js/laypage/laypage.js"></script>
<script type="text/javascript">

	$(function() {
	  	$(".nav-button").click(function() {
	    	$(".drop-down").toggleClass("closed");
	    	$("#drop-expand").toggleClass("drop-expand");
	  	});

	  	$(".ipp-num").click(function(){
	  		var items_per_page = $(this).html();
	  		location.href = '?page=1&item='+items_per_page;
	  	});
	});

	laypage({
	  	cont: 'layPage',
		skin: '#fff',
		groups: 4,
		prev: "<img class='arrow' src='/assets/img/prev.svg'>",
	  	next: "<img class='arrow' src='/assets/img/next.svg'>",
	  	first: '1',
		last: {!!$meta['allPages']!!},
		pages: {!!$meta['allPages']!!},
		curr: function(){
			var page = location.search.match(/page=(\d+)/);
		    return page ? page[1] : 1;
	  	}(), 
		jump: function(e, first){
		    if(!first){
			    location.href = '?page='+e.curr+'&item='+{!!$qurey['item']!!};
		    }
		}
	});

	laypage({
	  	cont: 'layPage2',
		skin: '#fff',
		groups: 4,
		prev: "<img class='arrow' src='/assets/img/prev.svg'>",
	  	next: "<img class='arrow' src='/assets/img/next.svg'>",
	  	first: '1',
		last: {!!$meta['allPages']!!},
		pages: {!!$meta['allPages']!!},
		curr: function(){
			var page = location.search.match(/page=(\d+)/);
		    return page ? page[1] : 1;
	  	}(), 
		jump: function(e, first){
		    if(!first){
			    location.href = '?page='+e.curr+'&item='+{!!$qurey['item']!!};
		    }
		}
	});

	laypage({
	    cont: 'layPage3',
	    pages: {!!$meta['allPages']!!},
    	groups: 0,
    	first: false,
    	last: false,
    	curr: function(){
			var page = location.search.match(/page=(\d+)/);
		    return page ? page[1] : 1;
	  	}(), 
    	jump: function(e, first){
	 	    if(!first){
	        	location.href = '?page='+e.curr+'&item='+{!!$qurey['item']!!};
	      	}
    	}
  	});

</script>
@stop