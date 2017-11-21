<?php 
	foreach($shoppingbag as $p){
		if ($p->id == $id && $p->size == $size) {
			$product = $p;
			break;
		}
	}
?>
<div class="buy-up">
	<div class="buy-wrap">
		<div class="buy-total">购物袋 <b id="sb-num">{!!count($shoppingbag)!!}</b> 件商品</div>
		<div class="buy-detail">
			<img class="bd-product-img" src="/assets/img/default.png">
			<div class="buy-detail-right relative">
				<img class="bag-delete" src="/assets/img/bag-delete.svg" onclick="removeFromMenu({!!$product->id!!},{!!$product->size!!},'none')">
				<span class="buy-detail-title" id="sb-title">{!!$product->title!!}</span><br>
				<p class="buy-detail-des" id="sb-subtitle">{!!$product->subtitle!!}</p>
				<span class="p-meta">
					<!-- <div class="p-color" style="background-color: #000;"></div> -->
					<!-- 黑色 -->
				</span><br>
				<span class="p-meta">尺码：<b>{!!$product->size!!}</b></span><br>
				<span class="p-meta">数量：<b>{!!$product->qty!!}</b></span><br>
				<div class="p-price">￥{!!$product->price!!}</div>
			</div>
		</div>
	</div>
</div>
<div class="buy-bottom">
	<div class="buy-wrap">
		<span class="buy-subtotal">商品总金额（不包含运费）<b>￥{!!$price['product_total']!!}</b></span>
		<a href="/shoppingbag"><div class="buy-btn go-shoppingbag">查看购物袋</div></a>
		<a href="/checkout"><div class="buy-btn go-order">结算</div></a>
	</div>
</div>