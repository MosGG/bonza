@extends('layouts.pageLayout')

@section('title')<title>Bonza - 修改送货地址</title>@stop

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
            <a>修改送货地址</a>
         </div>

         <div class="nav">
          <div class="detail-expand-btn rotate">
            <div></div>
            <div></div>
          </div>
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
           <h3> 修改送货地址</h3>
					 <div class="new_address"><a href="/myaccount/addressbook">返回上页</a></div>
           <div class="inside_re">
						 <div class="f_head">请修改下面的送货地址</div>
               <form id="reviseaddress-form" class="form-horizontal" onsubmit="return revisSubmit()">
                <div class="left_div relative">
              		<div class="new_required_label">*此栏为必填</div>
                  <div class="login-input">
                   <div class="login-title">名字 *</div>
                   <input name="firstname" required="" value="{!!$firstname!!}" type="text">
                 </div>

                 <div class="login-input">
                   <div class="login-title">姓氏 *</div>
                   <input name="lastname" required="" value="{!!$lastname!!}" type="text">
                 </div>

                 <div class="login-input">
                   <div class="login-title">电话 *</div>
                   <input name="phone" required="" value="{!!$phone!!}" type="text">
                 </div>
              	</div>

              	<div class="right_div relative">
                  <div class="login-input">
                        <div class="login-title">地址 *</div>
                        <input name="address" required="" value="{!!$address!!}"  type="text">
                   </div>
                  <div class="login-input">
                        <div class="login-title">地址第二行</div>
                        <input name="address2" value="{!!$address_second!!}"  type="text">
                   </div>
                   <div class="login-input">
                        <div class="login-title">城市 *</div>
                        <input name="city" required="" value="{!!$city!!}" type="text">
                   </div>
                   <div class="login-input">
                        <div class="login-title">省/辖区 *</div>
                        <input name="state" required="" value="{!!$state!!}" type="text">
                   </div>

                   <div class="login-input">
                        <div class="login-title">邮编 *</div>
                        <input id ="checkedbox" name="postcode" required="" value="{!!$postcode!!}" type="text">
                   </div>

									 <div class="login-remember-box">
               			    <input id ="checkbox-3" type="checkbox" name="default" class="styled-checkbox" checked><label for="checkbox-3">默认为送货地址</label>
               		</div>

              			<!-- <div class="login-loading">
              				<img src="/assets/img/loading.gif"><span></span>
              			</div> -->
              			<div>
              				<input id="reviseaddress-submit" type="submit" class="button login-btn" value="更新地址">
              			</div>
              		</form>
              	</div>
        	 		</form>

           </div>
         </div>
	    </div>
@stop


@section('js-function')
<script type="text/javascript" src="/assets/js/myaccount-m-nav.js"></script>
<script>
$(function(){
  var def = <?php echo $default;?>;
  if (def == 1){
    $('input[name=default]').click();
  }
  $("#reviseaddress-submit").click(function(){
    var currenturl = window.location.href;
    if (validator()) {


      $.ajax({
            type: "POST",
            url: currenturl+"/update",
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
                // $("#reviseaddress-form .login-loading span").html(data.success);
								window.location.href = "/myaccount/addressbook";
            },
            error: function (jqXHR) {
                alert("Error:" + jqXHR.status + ". Please contact the admin.");
            },
            complete: function () {
              // $("#reviseaddress-form .login-loading img").css('visibility','hidden');
							// setTimeout(function(){ $("#reviseaddress-form .login-loading span").html(""); }, 2000);
            }
        });
    }
  });

  $("#reviseaddress-form input[required]").change(function(){
    $(this).removeClass("input-warning");
  });
});

function validator(){
  var result = true;
  $.each($("#reviseaddress-form input[required]"), function() {
    if($(this).val() == "") {
      $(this).addClass("input-warning");
      result = false;
    }
  });
  return result;
}

function revisSubmit(){
  return false
}
</script>
@stop
