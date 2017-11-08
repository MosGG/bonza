<div class="p-home animated fadeInUp" >
	<p ng-repeat='description in descriptions' ng-bind='description'></p>
	<div class="row">
		<div class="col-md-4 col-sm-6 p-item-div" ng-repeat='portfolio in portfolioData'>
			<a ui-sref="work({name: '@{{portfolio.searchIndex}}'})">
				<img class="lazy" data-original="@{{portfolio.image}}" lazy-load>
				<img lazy-src="@{{portfolio.image}}" alt="@{{portfolio.title}}" >
				<div class="div-mask">
					<h2 ng-bind='portfolio.title'></h2>
				</div>
			</a>
		</div>
	</div>
</div>
