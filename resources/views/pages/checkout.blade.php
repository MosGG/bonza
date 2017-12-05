@extends('layouts.pageLayout')

@section('title')<title>Bonza - 购物车</title>@stop

@section('css-reference')
	<link href="/assets/css/checkout.css" rel="stylesheet">
@stop

@section('body')
<div class="checkout-process">
	<div class="wrapper relative">
		<div class="center ck-sub-nav">
			<span>1&nbsp;&nbsp;&nbsp;登录</span>
			<span class="current-step">2&nbsp;&nbsp;&nbsp;运送</span>
			<span>3&nbsp;&nbsp;&nbsp;付款</span>
			<span>4&nbsp;&nbsp;&nbsp;确定</span>
		</div>
	</div>
</div>
<div class="wrapper ck-detail relative">
	<div class="ck-d-right">
		<h2>订单总结</h2>
		<div class="order-detail">
			<?php 
			foreach($shoppingbag as $product) { ?>
				<div class="item relative transition" id="p-{!!$product->id!!}">
					<div class="item-left">
						<img src="{!!$product->src!!}">
					</div>
					<div class="item-right relative">
						<h3>{!!$product->title!!}</h3>
						<h4>{!!$product->subtitle!!}</h4>
						<br>
						<h4>颜色：蔚蓝色</h4>
						<h4>尺寸：{!!$product->size!!}</h4>
						<h4>数量：{!!$product->qty!!}</h4>
						<h4 class="price">￥
							<span id="price{!!$product->id!!}">{!!number_format($product->price,2)!!}</span>
						</h4>
					</div>
				</div>
			<?php } ?>
			<div class="price-detail">
				<div class="justify-line"><span>商品总金额</span>￥{!!number_format($price['product_total'],2)!!}</div>
				<div class="justify-line"><span>运费</span>￥{!!number_format($price['delivery'],2)!!}</div>
			</div>
			<div class="price-detail" style="margin-bottom: -1px;">
				<div class="justify-line"><span>小计</span>￥{!!number_format($price['subtotal'],2)!!}</div>
			</div>
		</div>
		<div class="tax-des">所有价格包含关税和其他税</div>
	</div>
	
	<div class="ck-d-left">
		<h2>添加送货地址</h2>
		<div class="ck-d-wrapper relative address">
			<div class="required-label">*此栏为必填</div>
			<div class="login-input">
				<div class="login-title">名字 *</div>
				<input id="firstname" class="required" type='text' placeholder="">
			</div>
			<div class="login-input">
				<div class="login-title">姓氏 *</div>
				<input id="lastname" class="required" type='text' placeholder="">
			</div>
			<div class="login-input">
				<div class="login-title">邮箱 *</div>
				<input id="email" class="required" type='text' placeholder="">
			</div>
			<div class="login-input">
				<div class="login-title">电话 *</div>
				<input id="tel" class="required" type='text' placeholder="">
			</div>
			<div class="login-input">
				<div class="login-title">地址 *</div>
				<input id="add" class="required" type='text' placeholder="">
			</div>
			<div class="login-input">
				<div class="login-title">地址第二行</div>
				<input id="add-2" type='text' placeholder="">
			</div>
			<div class="login-input">
				<div class="login-title">城市 *</div>
				<input id="city" class="required" type='text' placeholder="">
			</div>
			<div class="login-input">
				<div class="login-title">省/辖区 *</div>
				<input id="state" class="required" type='text' placeholder="">
			</div>
			<div class="login-input">
				<div class="login-title">邮编 *</div>
				<input id="postcode" class="required" type='text' placeholder="">
			</div>
			<div class="login-remember-box">
				<input type="checkbox" name="billing-address" checked><span class="checkbox-span">送货地址与账单新地址相同</span>
			</div>
			<!-- <div class="login-remember-box">
				<input type="checkbox" name="billing-address"><span class="checkbox-span"></span><span>另外输入账单地址</span>
			</div> -->
		</div>
	</div>
	<div class="ck-d-left address-another">
		<h2>请填写账单地址</h2>
		<div class="ck-d-wrapper relative ">
			<div class="login-input">
				<div class="login-title">名字 *</div>
				<input id="firstname-b" class="required" type='text' placeholder="">
			</div>
			<div class="login-input">
				<div class="login-title">姓氏 *</div>
				<input id="lastname-b" class="required" type='text' placeholder="">
			</div>
			<div class="login-input">
				<div class="login-title">邮箱 *</div>
				<input id="email-b" class="required" type='text' placeholder="">
			</div>
			<div class="login-input">
				<div class="login-title">电话 *</div>
				<input id="tel-b" class="required" type='text' placeholder="">
			</div>
			<div class="login-input">
				<div class="login-title">地址 *</div>
				<input id="add-b" class="required" type='text' placeholder="">
			</div>
			<div class="login-input">
				<div class="login-title">地址第二行</div>
				<input id="add-2-b" type='text' placeholder="">
			</div>
			<div class="login-input">
				<div class="login-title">城市 *</div>
				<input id="city-b" class="required" type='text' placeholder="">
			</div>
			<div class="login-input">
				<div class="login-title">省/辖区 *</div>
				<input id="state-b" class="required" type='text' placeholder="">
			</div>
			<div class="login-input">
				<div class="login-title">邮编 *</div>
				<input id="postcode-b" class="required" type='text' placeholder="">
			</div>
		</div>
	</div>
	<div class="ck-d-left">
		<!-- Devilery -->
		<div class="delivery-box">
			<h3>送货方式</h3>
			<div class="delivery-item">
				<b>快递配送 - <span class="delete">￥15.00</span> 免费</b><br>
				预计到达时间2-3天
			</div>
		</div>
		<a href="javascript:void(0);" onclick="submitOrder();">
			<div class="checkout-button">
				立即购买
			</div>
		</a>
	</div>

	

</div>
@stop

@section('js-reference')
@stop

@section('js-function')
<script type="text/javascript">
	$(document).ready(function(){
		if ($(".ck-detail").height() < $(".ck-d-right").height()) {
			$(".ck-detail").height($(".ck-d-right").height());
		}
	})

	$("input[name=billing-address]").click(function(){
		$(".address-another").toggleClass("address-another-show");
	});

	$(".address input").change(function(){
		if ($("input[name=billing-address]")[0].checked) {
			var text = $(this).val();
			var id = $(this).attr('id');
			$("#"+id+"-b").val(text);
		}
	});

	function submitOrder(){
		var result = true;
		$.each($(".required"), function() {
			if($(this).val() == "") {
				$(this).addClass("input-warning");
				result = false;
			} else {
				$(this).removeClass("input-warning");
			}
		});
		if (result) {
			$.ajax({
				url: "/submit-order",
				method: 'POST',
				data:{
					firstname: $('#firstname').val(),
					lastname: $('#lastname').val(),
					email: $('#email').val(),
					tel: $('#tel').val(),
					add: $('#add').val(),
					add2: $('#add-2').val(),
					city: $('#city').val(),
					state: $('#state').val(),
					postcode: $('#postcode').val(),

					firstnameb: $('#firstname-b').val(),
					lastnameb: $('#lastname-b').val(),
					emailb: $('#email-b').val(),
					telb: $('#tel-b').val(),
					addb: $('#add-b').val(),
					add2b: $('#add-2-b').val(),
					cityb: $('#city-b').val(),
					stateb: $('#state-b').val(),
					postcodeb: $('#postcode-b').val(),
				}, 
				headers: {
		        	'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		    	},
				success: function(result){
					if (result.link !== undefined) {
						location.href = result.link;
					}
				}
			});
		}
	}
</script>
@stop