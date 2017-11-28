
@extends('layouts.pageLayout')

@section('title')<title>账户信息 - Bonza</title>@stop

@section('css-reference')
	<link href="/assets/css/help.css" rel="stylesheet">
  <link href="/assets/css/login.css" rel="stylesheet">
@stop

@section('body')
<div class="body-content">
			<div class="main">
	       <div class="breadcrum">
		         <a href="/">首页</a>
		           <img src="/assets/img/next.svg">
		          <a href="/myaccount">我的账户</a>
							<img src="/assets/img/next.svg">
						 <a href="/myaccount/accountinfo">账户信息</a>
         </div>

         <div class="nav">
           <h3>我的账户</h3>
           <div class="nav_box_one">
             <a href="/myaccount/addressbook">
               <span class="hvr-underline-from-center">地址簿</span>
             </a>
           </div>

           <div class="nav_box">
             <a href="/myaccount/accountinfo">
               <span class="hvr-underline-from-center-selected">账户信息</span>
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
           <h3>我的账户信息</h3>
           <div class="inside_re">
						 <div class="f_head">修改个人信息</div>

                <div class="left_div relative">
                <form id="repersonal-form" class="form-horizontal" onsubmit="return repSubmit()">
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
                   <div class="login-title">邮箱 *</div>
                   <input name="email" required="" value="{!!$email!!}" type="email">
                 </div>

                 <div class="login-input">
                   <div class="login-title">确认邮箱 *</div>
                   <input name="email2" required="" value="{!!$email!!}" type="email2">
                 </div>

                 <div class="login-input">
                   <div class="login-title">电话 *</div>
                   <input name="phone" required="" value="{!!$phone!!}" type="text">
                 </div>

                <div class="login-loading">
                  <img src="/assets/img/loading.gif"><span></span>
                </div>

                <div>
                  <input id="repersonal-submit" type="submit" class="button accountinfo-btn" value="更新信息">
                </div>

                </form>

              </div>



              	<div class="right_div relative">

                  <form id="repassword-form" class="form-horizontal" onsubmit="return repaSubmit()">
                  <div class="login-input">
                    <div class="login-title">现在的密码 *</div>
                    <input name="currentpassword" required="" type="password">
                  </div>
                  <div class="login-input">
                    <div class="login-title">新密码 *</div>
                    <input name="newpassword" required="" type="password">
                  </div>
                  <div class="login-input">
                    <div class="login-title">确认新密码 *</div>
                    <input name="newpasswordconfirm" required="" type="password">
                  </div>
              			<div class="login-loading">
              				<img src="/assets/img/loading.gif"><span></span>
              			</div>
              			<div>
              				<input id="repassword-submit" type="submit" class="button accountinfo-btn" value="更新密码">
              			</div>
                  </form>
              	</div>

           </div>
         </div>

	    </div>
</div>
@stop

@section('js-function')
<script>
$(function(){
  // $("input,select,textarea").not("[type=submit]").jqBootstrapValidation();
  $("#repersonal-submit").click(function(){
    if (validator()) {
      $.ajax({
            type: "POST",
            url: "/myaccount/updateinfo",
            data: {
                email: $('input[name=email]').val(),
                firstname: $('input[name="firstname"]').val(),
                lastname: $('input[name="lastname"]').val(),
                phone: $('input[name=phone]').val(),
            },
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            dataType: "json",
            beforeSend  : function() {
                        $("#repersonal-form .login-loading").css('visibility','visible');
                        $("#repersonal-form .login-loading span").html("");
                        },
            success: function (data) {
                $("#repersonal-form .login-loading span").html(data.success);
            },
            error: function (jqXHR) {
                alert("Error:" + jqXHR.status + ". Please contact the admin.");
            },
            complete: function () {
              $("#repersonal-form .login-loading img").css('visibility','hidden');
							setTimeout(function(){ $("#repersonal-form .login-loading span").html(""); }, 2000);
            }
        });
    }
  });

  $("#repersonal-form input[required]").change(function(){
    $(this).removeClass("input-warning");
  });

	$("#repassword-submit").click(function(){
		if (validator2()) {
			$.ajax({
						type: "POST",
						url: "/myaccount/updatepassword",
						data: {
								currentpassword: $('input[name="currentpassword"]').val(),
								newpassword: $('input[name="newpassword"]').val(),
						},
						headers: {
								'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
						},
						dataType: "json",
						beforeSend  : function() {
												$("#repassword-form .login-loading").css('visibility','visible');
												$("#repassword-form .login-loading span").html("");
												},
						success: function (data) {
								$("#repassword-form .login-loading span").html(data.success);
						},
						error: function (jqXHR) {
								alert("Error:" + jqXHR.status + ". Please contact the admin.");
						},
						complete: function () {
							$("#repassword-form .login-loading img").css('visibility','hidden');
							setTimeout(function(){ $("#repassword-form .login-loading span").html(""); }, 2000);
						}
				});
		}
	});

	$("#repassword-form input[required]").change(function(){
		$(this).removeClass("input-warning");
	});
});

function validator(){
  var result = true;
  $.each($("#repersonal-form input[required]"), function() {
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
  if ($("input[name=email2]").val() !== $("input[name=email]").val()) {
    $("input[name=email2]").addClass("input-warning");
    result = false;
  }
  return result;
}

function validator2(){
  var result = true;
  $.each($("#repassword-form input[required]"), function() {
    if($(this).val() == "") {
      $(this).addClass("input-warning");
      result = false;
    }
  });

	if ($("input[name=newpassword]").val() !== $("input[name=newpasswordconfirm]").val()) {
    $("input[name=newpasswordconfirm]").addClass("input-warning");
    result = false;
  }


  return result;
}

function repSubmit(){
  return false
}

function repaSubmit(){
  return false
}
</script>
@stop
