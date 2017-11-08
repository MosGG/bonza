/*
*========================
* Angular Js contoller (All the controller in Portfolio Part)
*========================    
*/


//AngularJS controller for portfolio overall
app.controller('PortfolioOverall',['$scope','$http',function ($scope,$http){
	$scope.descriptions = [
	'We are Cheee : )',
	'Cheee is the universal word that describes a beautiful should through love, happiness, creativity, and positive cheee energy.',
	'Our philosophy is happiness, delivering happiness to people around us and spreading to the rest of the world. Our slogan is “saycheee”. When you say cheee, you are smiling. Smiling is a simply easy way to be happy.',
	'We value, profession, logic, communication, respect and happiness.',
	'Please view our previous work via the navigation on the left, including the categories of Brand, Design, Digital, Media and Interior, or you may click on the project name from the list.'
	];

	$http({
		method: 'POST',
	  	url: '/get-portfolio-data',
	  	data: {
	  		type:'all'
	  	}
	}).then(function successCallback(response) {
		$scope.portfolioData = response.data;
	}, function errorCallback(response) {
		alert("Error: " + response.status);
	});

}]);

//AngularJS controller for portfolio brand part
app.controller('PortfolioBrand',['$scope','$http',function ($scope,$http){
	$scope.title = 'Brand';
	$scope.descriptions = [
	'Brand, including the logo, name, colours, typography, patterns, iconography and all other identifying elements, are valuable company assets.',
	'The right brand design is able to sending a consistent and controlled message of who the company are. It is essential to presenting a strong, unified image of company through brand.',
	'Our Branding approach is focusing on the concept and logic. Please see the following portfolios for our brainstorm process and final brand design works.'
	];

	$http({
		method: 'POST',
	  	url: '/get-portfolio-data',
	  	data: {
	  		type:'brand'
	  	}
	}).then(function successCallback(response) {
		$scope.portfolioData = response.data;
	}, function errorCallback(response) {
		alert("Error: " + response.status);
	});

}]);

//AngularJS controller for portfolio design part
app.controller('PortfolioDesign',['$scope','$http',function ($scope,$http){
	$scope.title = 'Design';
	$scope.descriptions = [
	'Our design approach is focusing on the logic and visual hierarchy. The visual hierarchy orders of the information hierarchy are depend on the information that clients provide us and reasoned by logic.',
	'Color hierarchy contains two colour systems, the primary logo colour system and the secondary brand colour system. Typographic hierarchy is another form of visual hierarchy, a sub-hierarchy per se in an overall design project. Those hierarchy creates contrast between design elements.',
	'Please see the following portfolios for our final design works.'
	];

	$scope.portfolioImagesAttr = [];
	$http({
		method: 'POST',
	  	url: '/get-portfolio-data',
	  	data: {
	  		type:'design'
	  	}
	}).then(function successCallback(response) {
		$scope.portfolioData = response.data;
	}, function errorCallback(response) {
		alert("Error: " + response.status);
	});
}]);

//AngularJS controller for portfolio digital part
app.controller('PortfolioDigital',['$scope','$http',function ($scope,$http){
	$scope.title = 'Digital';
	$scope.descriptions = [
	'Our design team is cheerful and sharp-eyed, delivering clear, structured and branding consistent website designs.',
	'Our development team is experienced highly skilled with back and front-end coding language, frameworks, database and responsive websites with a smooth user interface. We can provide customised CMS systems intergraded with any third party API to keep the system simple and easy to manage.',
	'We design and develop, all you have to do is smile. #saycheee'
	];

	$scope.portfolioImagesAttr = [];
	$http({
		method: 'POST',
	  	url: '/get-portfolio-data',
	  	data: {
	  		type:'digital'
	  	}
	}).then(function successCallback(response) {
		$scope.portfolioData = response.data;
	}, function errorCallback(response) {
		alert("Error: " + response.status);
	});
}]);

//AngularJS controller for portfolio media part
app.controller('PortfolioMedia',['$scope','$http',function ($scope,$http){
	$scope.title = 'Media';
	$scope.descriptions = [
	'Brand and brand identity design, development and application, are key strengths of CHEEE. We start each branding project with a strong strategic approach ensuring the work we produce is built around a meaningful concept with the end user firmly in mind.',
	'From small start-ups to large multinationals, the brands we have produced for our clients are rolled out through a wide range of on and offline channels. Knowledge and experience across these platforms, as well as a methodical approach regarding rules and regulations of brand application, ensures our clients enjoy cohesion, consistency and increased brand equity.'
	];
	$scope.portfolioImagesAttr = [];
	$http({
		method: 'POST',
	  	url: '/get-portfolio-data',
	  	data: {
	  		type:'media'
	  	}
	}).then(function successCallback(response) {
		$scope.portfolioData = response.data;
	}, function errorCallback(response) {
		alert("Error: " + response.status);
	});
}]);

//AngularJS controller for portfolio interior part
app.controller('PortfolioInterior',['$scope','$http',function ($scope,$http){
	$scope.title = 'Interior';
	$scope.descriptions = [
	'Brand and brand identity design, development and application, are key strengths of CHEEE. We start each branding project with a strong strategic approach ensuring the work we produce is built around a meaningful concept with the end user firmly in mind.',
	'From small start-ups to large multinationals, the brands we have produced for our clients are rolled out through a wide range of on and offline channels. Knowledge and experience across these platforms, as well as a methodical approach regarding rules and regulations of brand application, ensures our clients enjoy cohesion, consistency and increased brand equity.'
	];

	$scope.portfolioImagesAttr = [];
	$http({
		method: 'POST',
	  	url: '/get-portfolio-data',
	  	data: {
	  		type:'interior'
	  	}
	}).then(function successCallback(response) {
		$scope.portfolioData = response.data;
	}, function errorCallback(response) {
		alert("Error: " + response.status);
	});
}]);

//AngularJS controller for portfolio single work part
app.controller('PortfolioWork',['$scope','$http','$stateParams','$timeout','$sce', function ($scope,$http,$stateParams,$timeout, $sce){
	$scope.portfolioImagesAttr = [];
	$http({
		method: 'POST',
	  	url: '/get-portfolio-data',
	  	data: {
	  		type:'work',
	  		name:$stateParams.name 
	  	}
	}).then(function successCallback(response) {
		$scope.portfolioData = response.data;
		$scope.portfolioData['content'] = $sce.trustAsHtml($scope.portfolioData['content'])
	}, function errorCallback(response) {
		alert("Error: " + response.status);
	});
}]);