@extends('layouts.pageLayout')

@section('title')<title>求职招聘 - Bonza</title>@stop

@section('css-reference')
	<link href="/assets/css/help.css" rel="stylesheet">
	<link href="/assets/css/login.css" rel="stylesheet">
@stop

@section('body')
<div class="body-content">
			<div class="re_main">
	       <div class="breadcrum">
		         <a href="/">首页</a>
		           <img src="/assets/img/next.svg">
		          <a href="/help">帮助</a>
							<img src="/assets/img/next.svg">
						 <a href="/recruitment">求职招聘</a>
         </div>

         <div class="nav">
           <h3>帮助</h3>
           <div class="nav_box_one">
             <a href="/help">
               <span class="hvr-underline-from-center">联系我们</span>
             </a>
           </div>

           <div class="nav_box">
             <a href="/deliver">
               <span class="hvr-underline-from-center">配送信息</span>
             </a>
           </div>
           <div class="nav_box">
             <a href="/refund">
               <span class="hvr-underline-from-center">退换货信息</span>
             </a>
           </div>
           <div class="nav_box">
             <a href="/term">
               <span class="hvr-underline-from-center">服务条款</span>
             </a>
           </div>
           <div class="nav_box">
             <a href="/privacy">
               <span class="hvr-underline-from-center">隐私政策</span>
             </a>
           </div>
           <div class="nav_box">
             <a href="/recruitment">
               <span class="hvr-underline-from-center-selected">求职招聘</span>
             </a>
           </div>
         </div>

         <div class= "content">
           <h3>求职招聘</h3>
            <div class="inside_re">
			 <form id="rec-form" class="form-horizontal" onsubmit="return recSubmit()">
	 			<input name="_token" value="{{ csrf_token() }}" type="hidden">
	 			<div class="login-input">
	 				<div class="login-title">名字 *</div>
	 				<input name="firstname" required="" placeholder="请输入您的名字" type="text">
	 			</div>
	 			<div class="login-input">
	 				<div class="login-title">姓氏 *</div>
	 				<input name="lastname" required="" placeholder="请输入您的姓氏" type="text">
	 			</div>
	 			<div class="login-input">
	 				<div class="login-title">邮箱 *</div>
	 				<input name="email" required="" placeholder="请输入您的邮箱" type="email">
	 			</div>
				<div class="login-input">
	 				<div class="login-title">电话 *</div>
	 				<input name="phone" required="" placeholder="请输入您的电话" type="text">
	 			</div>
	 			<div class="login-input">
	 				<div class="login-title">简介</div>
					<textarea rows="9" name="description" placeholder="请留下想说的内容"></textarea>
	 			</div>
	 			<div class="login-input">
	 				<a href="/term" target="_blank"><div class="login-title reg-policy">隐私条款</div></a>
	 			</div>

	 			<div>
					<div class="sub-err">
		 				<img src="/assets/img/loading.gif"><span></span>
		 			</div>
	 				<input id="rec-submit" class="button login-btn" value="提交" type="submit">
	 			</div>
	 		</form>

           </div>
         </div>

	    </div>
</div>
@stop

@section('js-function')
<script>
	$(function(){
		// $("input,select,textarea").not("[type=submit]").jqBootstrapValidation();
		$("#rec-submit").click(function(){
			if (validator()) {
				$.ajax({
			        type: "POST",
			        url: "/email-sending",
			        data: {
			        		firstname: $('input[name=firstname]').val(),
			            lastname: $('input[name=lastname]').val(),
									phone: $('input[name=phone]').val(),
			            email: $('input[name=email]').val(),
			            description: $('textarea[name=description]').val()
			        },
			        headers: {
			            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			        },
			        dataType: "json",
							beforeSend  : function() {
													$(".sub-err").css('visibility','visible');
													$(".sub-err span").html("");
                          },
			        success: function (data) {
			            $(".sub-err span").html(data.msg);
			        },
			        error: function (jqXHR) {
			            alert("Error:" + jqXHR.status + ". Please contact the admin.");
			        },
			        complete: function () {
			        	$(" .sub-err").css('visibility','hidden');
			        }
			    });
			}
		});

		$("#rec-form input[required]").change(function(){
			$(this).removeClass("input-warning");
		});
	});

	function validator(){
		var result = true;
		$.each($("#rec-form input[required]"), function() {
			if($(this).val() == "") {
				$(this).addClass("input-warning");
				result = false;
			}
		});
		var myreg = /^[a-z0-9]+([._\\-]*[a-z0-9])*@([a-z0-9]+[-a-z0-9]*[a-z0-9]+.){1,63}[a-z0-9]+$/;
		if (!myreg.test($("input[name=email]").val())) {
			$(this).addClass("input-warning");
			result = false;
		}
		return result;
	}

	function recSubmit(){
		return false
	}
</script>
@stop
