<div class="p-home animated fadeInUp">
	<h1 ng-bind='title'></h1>
	<p ng-repeat='description in descriptions' ng-bind='description'></p>
	<div class="portfolio-item" ng-repeat='portfolio in portfolioData'>
		<h1 ng-bind = 'portfolio.title'></h1>
		<p ng-bind-html = 'portfolio.content'></p>
		<div class="row">
			<div class="p-item-div col-sm-12" ng-repeat='image in portfolio.image' ng-class='{"col-sm-12":image.narrow != 1,"col-sm-6":image.narrow == 1}'>
				<a ui-sref="work({name: '@{{portfolio.searchIndex}}'})">
					<img lazy-src="@{{image.src}}" alt="@{{portfolioData.title}}" >
					<div class="div-mask">
						<h2 ng-bind='portfolio.title'></h2>
					</div>
				</a>
			</div>

		</div>
	</div>
</div>
