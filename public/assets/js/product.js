
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
