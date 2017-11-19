$(".nav-button").click(function() {
	var height = $(".drop-down li").length * 31 - 1;
	if ($(".drop-down").height() == 30) {
		$(".drop-down").height(height);
	} else {
		$(".drop-down").height(30);
	}
	$("#drop-expand").toggleClass("drop-expand");
});


$(".detail-expand-box").click(function(){
	$(this).toggleClass("detail-open");
	$(this).children(".detail-expand-btn").toggleClass("rotate");
})