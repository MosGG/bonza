<div class="p-home animated fadeInUp">
	<div class="portfolio-item" ng-if='portfolioData.type == "yes"'>
		<h1 ng-bind='portfolioData.title'></h1>
		<p ng-bind-html='portfolioData.content'></p>
		<div class="row">
			<div class="p-item-div" ng-repeat='image in portfolioData.image' ng-class='{"col-sm-12":image.narrow != 1,"col-sm-6":image.narrow == 1}'>
				<img lazy-src="@{{image.src}}" alt="@{{portfolioData.title}}" >
			</div>
		</div>
	</div>
	<div class="portfolio-item" ng-if='portfolioData.type == "no"'>
		<h1 class="no-portfolio">Currently, We do not have any portfolio with <span ng-bind='portfolioData.title'></span>.</h1>
	</div>
</div>
