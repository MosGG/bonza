@extends('layouts.admin')

@section('title')<title>Product - Fine Food Group Admin</title>@stop

@section('content')
    <div id="content">
        <div id="content-header">
            <h1>Product Management</h1>
        </div>
        <!-- #content-header -->

        <div id="content-container">
            <div class="row">
                <div class="col-md-12">
                    <div class="portlet">
                        <a type="button" class="btn btn-secondary admin-add-btn" href="/portfolio-new">
                            New Product
                        </a>

                       <!--  <a type="button" target="_blank" class="btn btn-info admin-add-btn" href="/portfolio-sort"
                               >Overall
                            Sorting
                        </a> -->

                        <div class="portlet-header">

                            <h3>
                                <i class="fa fa-table"></i>
                                Product List
                            </h3>

                        </div>
                        <!-- /.portlet-header -->

                        <div class="portlet-content" id="cheee-admin-table-div">
                            <div class="table-responsive">
                                <table
                                        class="table table-striped table-bordered table-hover table-highlight table-checkable"
                                        data-provide="datatable"
                                        data-display-rows="50"
                                        data-info="true"
                                        data-search="true"
                                        data-length-change="true"
                                        data-paginate="true"
                                        >
                                    <thead>
                                    <tr>
                                        <th data-filterable="true" data-sortable="true" data-direction="desc">Featured
                                        </th>
                                        <!-- <th data-filterable="true" data-sortable="true" data-direction="desc">Slider
                                        </th> -->
                                        <th data-filterable="true" data-sortable="true" data-direction="desc">ID
                                        </th>
                                        <th data-filterable="true" data-sortable="true" data-direction="desc">Title
                                        </th>
                                        <th data-filterable="true" data-sortable="true" data-direction="desc">Price(AUD)
                                        </th>
                                        <th data-filterable="true" data-sortable="true" data-direction="desc">Discount Price(AUD)
                                        </th>
                                        <th data-filterable="true" data-sortable="true" data-direction="desc">Stock
                                        </th>
                                        <th data-filterable="true" data-sortable="true" data-direction="desc">Designer
                                        </th>
                                        <th data-filterable="true" data-sortable="true" data-direction="desc">Category
                                        </th>
                                        <th data-direction="asc" data-filterable="true" data-sortable="true">Publisher
                                        </th>
                                        <th>Action</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                        <tr ng-repeat="x in portfolios">
                                            <td><button type="button" class="featureBtn" ng-class="{ featureBtnActive:x.featured == 1 }" ng-click="changeFeatureClass(x)">
                                                <i class="fa fa-star"></i>
                                            </button></td>
                                            <!-- <td><button type="button" class="featureBtn" ng-class="{ featureBtnActive:x.client == 1 }" ng-click="changeClientClass(x)">
                                                <i class="fa fa-star"></i>
                                            </button></td> -->
                                            <td ng-bind="x.id"></td>
                                            <td ng-bind="x.title"></td>
                                            <td ng-bind="x.price"></td>
                                            <td ng-bind="x.discount_price"></td>
                                            <td ng-bind="x.stock"></td>
                                            <td ng-bind="x.origin"></td>
                                            <td ng-bind="x.category"></td>
                                            <td ng-bind="x.publisher"></td>
                                            <td>
                                                <a class="btn btn-info" href="/portfolio-edit/@{{x.id}}">Edit</a>
                                                <a class="btn btn-success" target="_blank" href="/portfolio#/work/@{{x.searchIndex}}">Preview</a>
                                                <button type="button" class="btn btn-danger" ng-click="delete(x)">Delete
                                                </button>
                                                <button class="btn btn-secondary" ng-if='x.status == 0' ng-click="active(x)">Active</button>
                                                <button class="btn btn-warning" ng-if='x.status == 1' ng-click="ban(x)">Ban</button>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <!-- /.table-responsive -->
                        </div>
                        <!-- /.portlet-content -->
                    </div>
                    <!-- /.portlet -->
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->
        </div>
        <!-- /#content-container -->
    </div> <!-- #content -->
@stop



@section('js-function')
    <script>
        var app = angular.module('myApp', []);
        app.controller('adminCtrl', function($scope, $http) {

            $scope.portfolios = {!! $portfolios !!};

            $scope.active = function(obj){
                if (confirm("Are you sure to active this portfolio?")) {
                    obj.status = 1;
                    $http({
                        method: "POST",
                        url: "/portfolio-active-action",
                        data: {
                            id: obj.id
                        }
                    }).then(function successCallback(response) {
                    }, function errorCallback(response) {
                    });
                }
            }

            $scope.ban = function(obj){
                if (confirm("Are you sure to ban this portfolio?")) {
                    obj.status = 0;
                    obj.featured = 0;
                    obj.client = 0;

                    $http({
                        method: "POST",
                        url: "/portfolio-ban-action",
                        data: {
                            id: obj.id
                        }
                    }).then(function successCallback(response) {
                    }, function errorCallback(response) {
                    });
                }
            }

            $scope.changeFeatureClass = function(obj){
                if(obj.status == 0){
                    alert("Please active this portfolio first");
                }else{
                    if(obj.featured == 0){
                        obj.featured = 1;
                    }else{
                        obj.featured = 0;
                    }
                    $http({
                        method: "POST",
                        url: "/portfolio-feature-action",
                        data: {
                            id: obj.id,
                            featured:obj.featured
                        }
                    }).then(function successCallback(response) {
                    }, function errorCallback(response) {
                    });
                }
            }

            $scope.changeClientClass = function(obj){
                if(obj.status == 0){
                    alert("Please active this portfolio first");
                }else{
                    if(obj.client == 0){
                        obj.client = 1;
                    }else{
                        obj.client = 0;
                    }
                    $http({
                        method: "POST",
                        url: "/portfolio-client-action",
                        data: {
                            id: obj.id,
                            client:obj.client
                        }
                    }).then(function successCallback(response) {
                    }, function errorCallback(response) {
                    });
                }
            }

            $scope.delete = function(obj){
                if (confirm("Are you sure to delete this portfolio?")) {
                    $http({
                        method: "POST",
                        url: "/portfolio-delete-action",
                        data: {
                            id: obj.id
                        }
                    }).then(function successCallback(response) {
                        location.reload();
                    }, function errorCallback(response) {
                    });
                }
            }

            
        });
    </script>
@stop

