@extends('layouts.pageLayout')

@section('title')<title>我的账户 - Bonza</title>@stop

@section('css-reference')
	<link href="/assets/css/help.css" rel="stylesheet">
@stop

@section('body')
			<div class="main">
	       <div class="breadcrum">
		         <a href="/">首页</a>
		           <img src="/assets/img/next.svg">
		          <a href="/myaccount">我的账户</a>
							<img src="/assets/img/next.svg">
						 <a href="/myaccount/addressbook">地址簿</a>
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
           <h3>地址簿</h3>
					 <div class="new_address"><a href="/myaccount/addressbook/new">添加新的送货地址</a></div>
           <div class="inside_re">


						 <?php
						 if($default_address!= null){
						 echo '<div class="f_head">默认送货地址</div>';
						 echo '<div class="address_content" id= '.$default_address->id.'>';
						 echo '<p>'.$default_address->firstname.' '.$default_address->lastname.'</p>';
						 echo '<p>'.$default_address->phone.'</p>';
						 echo '<p class="address">'.$default_address->address.' </p>';
						 echo '<p>'.$default_address->address_second.' </p>';
						 echo '<p>'.$default_address->city.' </p>';
						 echo '<p>'.$default_address->state.' </p>';
						 echo '<p>'.$default_address->postcode.' </p>';
						 echo	 '<div class="bot">
							 	<div class="revise"><a href="/myaccount/addressbooksingle/'.$default_address->id.'">修改</a></div>
							 	<div class="delete">删除</div>
						 	</div>
						 </div>
						 </div>';
					 }else{

					 }
						 ?>


					 <?php
					 if($address!= null){
						 echo '<div class="inside_re"> <div class="f_head">其他送货地址</div>';
						 $i = 0;
						 foreach ($address as $a) {

							 if ($i % 2 == 0){
								 echo '<div class="address_content grid_system_left" id= '.$a->id.'>';
							 }else{
								 echo '<div class="address_content grid_system_right" id= '.$a->id.'>';
							 }

  						 echo '<p>'.$a->firstname.' '.$a->lastname.'</p>';
  						 echo '<p>'.$a->phone.'</p>';
  						 echo '<p class="address">'.$a->address.' </p>';
  						 echo '<p>'.$a->address_second.' </p>';
							 echo '<p>'.$a->city.' </p>';
							 echo '<p>'.$a->state.' </p>';
  						 echo '<p>'.$a->postcode.' </p>';
  						 echo	 '<div class="bot">
  							 	<div class="revise"><a href="/myaccount/addressbooksingle/'.$a->id.'">修改</a></div>
  							 	<div class="delete">删除</div>
  						 	</div>
  						 </div>';
							 $i ++;
						 }
						 echo "</div>";
					 }else{
						 echo '';
					 }

					 ?>
         </div>

	    </div>
@stop

@section('js-function')
<script>
$(function(){
  $(".delete").click(function(event){
		if(confirm("确认要删除吗？")){
      $.ajax({
            type: "POST",
            url: "/myaccount/addressbook/deleteaddress",
            data: {
                id: $(this).parent().parent().attr('id'),
            },
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            dataType: "json",
            beforeSend  : function() {

                        },
            success: function (data) {
                // $("#newaddress-form .login-loading span").html(data.success);
								 window.location.reload();
            },
            error: function (jqXHR) {
                alert("Error:" + jqXHR.status + ". Please contact the admin.");
            }
        });
			}
    });
  });

</script>
@stop
