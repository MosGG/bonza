@extends('layouts.admin')

@section('title')<title>Partner - The Map Admin</title>@stop

@section('content')
    <div id="content">
        <div id="content-header">
            <h1>Partner Management
            </h1>
        </div>
        <!-- #content-header -->

        <div id="content-container">
            <div class="row">
                <div class="col-md-12">
                    <div class="portlet">
                        <a type="button" class="btn btn-secondary admin-add-btn" href="/partner-new">
                        New Partner
                        </a>

                        <div class="portlet-header">

                            <h3>
                                <i class="fa fa-table"></i>
                                Partner List
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
                                        <th data-filterable="true" data-sortable="true" data-direction="desc">ID
                                        </th>
                                        <th data-filterable="true" data-sortable="true" data-direction="desc">Title
                                        </th>
                                       <!--  <th data-filterable="true" data-sortable="true" data-direction="desc">Title Chinese
                                        </th> -->
                                        <th data-filterable="true" data-sortable="true" data-direction="desc">Description
                                        </th>
                                        <th data-filterable="true" data-sortable="true" data-direction="desc">Category
                                        </th>
                                        <th width=200>Action</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                        <tr ng-repeat="x in portfolios">
                                            <td><button type="button" class="featureBtn" ng-class="{ featureBtnActive:x.featured == 1 }" ng-click="changeFeatureClass(x)">
                                                <i class="fa fa-star"></i>
                                            </button></td>
                                            <td ng-bind="x.id"></td>
                                            <td ng-bind="x.title"></td>
                                            <td ng-bind="x.description"></td>
                                            <td ng-bind="x.category"></td>

                                            <td>
                                                <a class="btn btn-info" href="/partner-edit/@{{x.id}}">Edit</a>
                                                <button type="button" class="btn btn-danger" ng-click="delete(x)">Delete
                                                </button>
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

            $scope.changeFeatureClass = function(obj){
                if(obj.featured == 0){
                    obj.featured = 1;
                }else{
                    obj.featured = 0;
                }
                $http({
                    method: "POST",
                    url: "/partner-feature-action",
                    data: {
                        id: obj.id,
                        featured:obj.featured
                    }
                }).then(function successCallback(response) {
                }, function errorCallback(response) {
                });
                
            }

            $scope.delete = function(obj){
                if (confirm("Are you sure to delete this portfolio?")) {
                    $http({
                        method: "POST",
                        url: "/partner-delete-action",
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

