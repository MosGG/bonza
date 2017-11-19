$(document).ready(function(){
	var xhr;
	new autoComplete({
		minChars: 2,
		offsetTop: -15,
	    selector: '#search-input',
	    source: function(term, response){
	        try { xhr.abort(); } catch(e){}
	        xhr = $.getJSON('/search-ajax', { q: term }, function(data){ response(data); });
	    }
	});

	new autoComplete({
		minChars: 1,
		offsetTop: 10,
	    selector: '#m-search-input',
	    menuClass: 'm-search-auto',
	    source: function(term, response){
	        try { xhr.abort(); } catch(e){}
	        xhr = $.getJSON('/search-ajax', { q: term }, function(data){
        		response(data);
		    });
	    }
	});

	$(window).scroll(function() {
	    if ($(this).scrollTop() > 100) {
	        $('.scroll-up').show();
	    } else {
	        $('.scroll-up').hide();
	    }
	});

	$('.button-nav').on("click", function(e) {
	  e.preventDefault();
	  $(this).toggleClass('button-close');
	  $(".menu-m-item").toggleClass('open-menu-m');
	});

	$(".m-service-info").click(function(){
		$(".mid-footer-content").toggleClass("m-footer-open");
		$(".footer-links").toggleClass("footer-links-show fadein");
	});

	$(".hover-icon").hover(function(){
  		swapHoverSrc(this)
  	},function(){
  		swapHoverSrc(this)
  	});

  	$(".hover-icon").click(function(){
  		$(this).unbind();
  	});

	$("#shopping_bag").hover(function(){
		$(".bag-buy").fadeIn();
		setTimeout(function(){
			$(".bag-buy").fadeOut();
		}, 5000)
	});

  	function swapHoverSrc(obj){
  		var src = $(obj).attr('src');
  		var hover = $(obj).attr('data-hover');
  		$(obj).attr('src',hover);
  		$(obj).attr('data-hover', src);
  	}

  	//m-menu
  	$(".m-menu").click(function(){
  		$(".m-wrapper").addClass("m-menu-open");
  		$('.m-nav').addClass("m-nav-open");
  		$(".m-shade").fadeIn('300');
  	});
  	$(".m-shade").click(function(){
  		$(".m-wrapper").removeClass("m-menu-open");
  		$('.m-nav').removeClass("m-nav-open");
  		$(".m-shade").fadeOut('300');
  		mMenuBack();
  	})
  	$(".m-menu-second").click(function(){
  		$('.m-nav-second').addClass("m-nav-open");
  	});
  	$("#m-search-clear").click(function(){
  		$("#m-search-input").val("");
  	});
});
function scrolltotop(){
	$("html, body").animate({ scrollTop: 0 }, "slow");
}
function mMenuBack(){
	$('.m-nav-second').removeClass("m-nav-open");
}
function open_search(){
	$('.m-search').fadeIn();
	$("#m-search-input").focus();
}
function close_search(){
	$('.m-search').fadeOut();
}
function addwishlist(id){
	$.ajax({
			url: "/add-to-wishlist",
			method: 'POST',
			data:{
				id: id,
			}, 
			headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
		success: function(result){
	        $(".wishlist-num").show();
	  		$(".wishlist-num").html(result.num);
	  		$(".wishlist-num").addClass("addwishlist");
			setTimeout(function(){
				$(".wishlist-num").removeClass("addwishlist");
			},2100);
	    }
	});
}

function addShoppingBag(id){
		 // 		$.ajax({
// 			url: "/add-to-shoppingbag",
// 			data:{
// 				id: id,
// 			}, 
// 			success: function(result){
	        
	//     }
	// });
		$(".bag-buy").fadeIn();
	setTimeout(function(){
		$(".bag-buy").fadeOut();
	},2000);
}