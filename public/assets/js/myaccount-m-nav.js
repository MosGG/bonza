$(".nav").click(function(){
	$(this).toggleClass("detail-open");
	$(this).children(".detail-expand-btn").toggleClass("rotate");
})