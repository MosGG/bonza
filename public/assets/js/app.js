/*
*========================
* Angular Js directive (Make Div 16:9)
*========================    
*/
app.directive('sixteenNine', function($window,$timeout) {
    return {
        restrict: 'A',
        link: function (scope, element, attr) {
            $timeout(function(){
                $(element).height(Math.ceil($(element).width()*0.5625));

                //do the lazy loading images after the document has rendered.
                // $("img.lazy").lazyload({
                //    effect : "fadeIn"
                // });
            },0);

            $(element).height(Math.ceil($(element).width()*0.5625));
            angular.element($window).bind('resize', function(){
                $(element).height(Math.ceil($(element).width()*0.5625));
            });
        }
    };
});


app.filter('htmlToString', function () {
    return function (text,url) {
        text = text ? String(text).replace(/<[^>]+>/gm, ' ') : '';
        return text;
    };
}
);

/*
*========================
* Jquery control portfolio page sub-navigation
*========================    
*/
function subNavigationControl(){
	$('.mobile-subnav').on('click',function(){
		var $this = $(this);
		var target = $(this).data('target');
		$this.toggleClass('open');			
		$(target).slideToggle(300);
	});
}