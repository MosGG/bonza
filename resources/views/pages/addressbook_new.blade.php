@extends('layouts.pageLayout')

@section('title')<title>添加送货地址 - Bonza</title>@stop

@section('css-reference')
	<link href="/assets/css/help.css" rel="stylesheet">
  <link href="/assets/css/login.css" rel="stylesheet">
@stop

@section('body')
			<div class="main">
	       <div class="breadcrum">
		         <a href="/">首页</a>
		           <img src="/assets/img/next.svg">
		          <a href="/myaccount">我的账户</a>
							<img src="/assets/img/next.svg">
						 <a href="/myaccount/addressbook">地址簿</a>
             <img src="/assets/img/next.svg">
            <a href="/myaccount/addressbook/new">添加送货地址</a>
         </div>

         <div class="nav">
           <h3>我的账户</h3>
           <div class="nav_box_one">
             <a href="/myaccount/addressbook">
               <span class="hvr-underline-from-center-selected">地址簿</span>
             </a>
           </div>

           <div class="nav_box">
             <a href="/myaccount/accountinfo">
               <span class="hvr-underline-from-center">账户信息</span>
             </a>
           </div>
           <div class="nav_box">
             <a href="/refund">
               <span class="hvr-underline-from-center">我的订单</span>
             </a>
           </div>
           <div class="nav_box">
             <a href="/term">
               <span class="hvr-underline-from-center">愿望清单</span>
             </a>
           </div>
           <div class="nav_box">
             <a href="/privacy">
               <span class="hvr-underline-from-center">微信绑定</span>
             </a>
           </div>
         </div>

         <div class= "content">
           <h3>添加送货地址</h3>
					 <div class="new_address"><a href="/myaccount/addressbook">返回上页</a></div>
           <div class="inside_re">
						 <div class="f_head">请创建或修改下面的送货地址</div>



               <form id="newaddress-form" class="form-horizontal" onsubmit="return newaSubmit()">
                <div class="left_div relative">
              		<div class="new_required_label">*此栏为必填</div>
                  <div class="login-input">
                   <div class="login-title">名字 *</div>
                   <input name="firstname" required="" placeholder="请输入您的名字" type="text">
                 </div>

                 <div class="login-input">
                   <div class="login-title">姓氏 *</div>
                   <input name="lastname" required="" placeholder="请输入您的姓氏" type="text">
                 </div>

                 <div class="login-input">
                   <div class="login-title">电话 *</div>
                   <input name="phone" required="" placeholder="请输入您的电话" type="text">
                 </div>
              	</div>

              	<div class="right_div relative">
                  <div class="login-input">
                        <div class="login-title">地址 *</div>
                        <input name="address" required="" placeholder="请输入您的地址" type="text">
                   </div>
                  <div class="login-input">
                        <div class="login-title">地址第二行</div>
                        <input name="address2" placeholder="请输入您的地址第二行" type="text">
                   </div>
                   <div class="login-input">
                        <div class="login-title">城市 *</div>
                        <input name="city" required="" placeholder="请输入您的城市" type="text">
                   </div>
                   <div class="login-input">
                        <div class="login-title">省/辖区 *</div>
                        <input name="state" required="" placeholder="请输入您的省/辖区" type="text">
                   </div>
                   <div class="login-input">
                        <div class="login-title">邮编 *</div>
                        <input name="postcode" required="" placeholder="请输入您的邮编" type="text">
                   </div>
                   <div class="login-remember-box">
               			    <input id ="checkbox-2" type="checkbox" name="default" class="styled-checkbox"><label for="checkbox-2">默认为送货地址</label>
               		</div>
              			<!-- <div class="login-loading">
              				<img src="/assets/img/loading.gif"><span></span>
              			</div> -->
              			<div>
              				<input id="newaddress-submit" type="submit" class="button login-btn" value="保存地址">
              			</div>
              		</form>
              	</div>
        	 		</form>

           </div>
         </div>
	    </div>
@stop

@section('js-function')
<script>
$(function(){
  $("#newaddress-submit").click(function(){
    if (validator()) {
      $.ajax({
            type: "POST",
            url: "/myaccount/addressbook/newaddress",
            data: {
                firstname: $('input[name="firstname"]').val(),
                lastname: $('input[name="lastname"]').val(),
                phone: $('input[name=phone]').val(),
								address:$('input[name=address]').val(),
								address2:$('input[name=address2]').val(),
								city:$('input[name=city]').val(),
								state:$('input[name=state]').val(),
								postcode:$('input[name=postcode]').val(),
								default:$('input[name=default]')[0].checked,
            },
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            dataType: "json",
            beforeSend  : function() {
                        // $(".login-loading").css('visibility','visible');
                        // $(".login-loading span").html("");
                        },
            success: function (data) {
                // $("#newaddress-form .login-loading span").html(data.success);
								window.location.href = "/myaccount/addressbook";
            },
            error: function (jqXHR) {
                alert("Error:" + jqXHR.status + ". Please contact the admin.");
            },
            complete: function () {
              // $("#newaddress-form .login-loading img").css('visibility','hidden');
							// setTimeout(function(){ $("#newaddress-form .login-loading span").html(""); }, 2000);
            }
        });
    }
  });

  $("#newaddress-form input[required]").change(function(){
    $(this).removeClass("input-warning");
  });
});

function validator(){
  var result = true;
  $.each($("#newaddress-form input[required]"), function() {
    if($(this).val() == "") {
      $(this).addClass("input-warning");
      result = false;
    }
  });
  return result;
}

function newaSubmit(){
  return false
}
</script>
@stop
