<div class="p-brand animated fadeInUp" >
	<h1 ng-bind='title'></h1>
	<p ng-repeat='description in descriptions' ng-bind='description'></p>
	<div class="row">
		<div class="col-md-4 col-sm-6 p-item-div" ng-repeat='brand in portfolioData'>
			<a ui-sref="work({name: '@{{brand.searchIndex}}'})">
				<!-- <img class="lazy" data-original="@{{brand.image}}" alt="@{{brand.title}}" lazy-load> -->
				<img lazy-src="@{{brand.image}}" alt="@{{brand.title}}" >
				<div class="div-mask">
					<h2 ng-bind='brand.title'></h2>
				</div>
			</a>
		</div>
	</div>
</div>
