@extends('layouts.pageLayout')

@section('title')<title>Bonza - 帮助页面</title>@stop

@section('css-reference')
	<link href="/assets/css/help.css" rel="stylesheet">
@stop

@section('body')
<div class="body-content">
			<div class="main">
	       <div class="breadcrum">
		         <a href="/">首页</a>
		           <img src="/assets/img/next.svg">
		          <a href="/help">帮助</a>
							<img src="/assets/img/next.svg">
						 <a href="/help">联系我们</a>
         </div>

         <div class="nav">
           <h3>帮助</h3>
           <div class="nav_box_one">
             <a href="/help">
               <span class="hvr-underline-from-center-selected">联系我们</span>
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
               <span class="hvr-underline-from-center">求职招聘</span>
             </a>
           </div>
         </div>

         <div class= "content">
           <h3>联系我们</h3>
           <div class="inside">
             <div class="content_box">
               客户服务：
             </div>

             <div class="content_box">
               我们的团队一周七天，每天24小时为您服务。
             </div>

						 <div class="content_box">
						 	服务内容：
						 </div>

             <div class="content_box">
               <p>提供尺码建议</p>
               <p>提供产品详细信息</p>
               <p>解答送货相关疑问</p>
               <p>解答退换货疑问</p>
               <p>订单相关咨询</p>
             </div>

             <div class="content_box">
               电邮：<a href="mailto:customercare@bonza.com.co">customercare@bonza.com.co</a>
             </div>

             <div class="content_box">
               联系电话：<a href="tel:1300 0000">1300 0000</a>
             </div>

           </div>
         </div>

	    </div>
</div>
@stop
