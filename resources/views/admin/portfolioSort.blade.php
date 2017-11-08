@extends('layouts.admin')

@section('title')<title>Portfolio - Cheee Admin</title>@stop

@section('content')
    <div id="content">
        <div id="content-header">
            <h1>Client Sort
            </h1>
        </div>
        <!-- #content-header -->

        <div id="content-container">
            <div class="row">
                <div class="col-md-12">
                    <div class="portlet">
                        <div >
                            <ul ui-sortable="sortableOptions" ng-model="portfolios">
                                <li class="media-modal-item" ng-repeat="portfolio in portfolios">@{{portfolio.title}}</li>
                            </ul>
                           <!--  <div class="media-modal-item" ng-repeat="portfolio in portfolios" >
                               <h2></h2>
                            </div> -->
                        </div>
                    </div>

                     <button class="btn btn-secondary admin-add-btn pull-left" ng-click="sort()">Sort
                        </button>
                    <!-- /.portlet -->
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->
        </div>
        <!-- /#content-container -->
    </div> <!-- #content -->
@stop

@section('js-reference')
    <script type="text/javascript" src="/assets/admin/js/plugins/angular-ui-sortable/dist/sortable.min.js"></script>
@stop

@section('js-function')
    <script>
        var app = angular.module('myApp', ['ui.sortable']);
        app.controller('adminCtrl', function($scope, $http) {
            $scope.portfolios = {!! $portfolios !!};

            $scope.sort = function () {
                $http({
                    method: 'POST',
                    url: "/client-sort-action",
                    data: {
                        portfolios: $scope.portfolios
                    }
                }).then(function successCallback(response) {
                    window.location.href = "/portfolio-sort";
                }, function errorCallback(response) {
                });
            };
        });

    </script>
@stop

