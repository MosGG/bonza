@extends('layouts.admin')

@section('title')<title>Tags - Fine Food Group</title>@stop

@section('modal')
    <!--NEW Category Modal -->
    <div class="modal fade" id="category-add-modal" role="dialog">
        <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">New Tag</h4>
                </div>
                <div class="modal-body" id="admin-add-body">
                    <label>Tag Name* </label>
                    <input class="form-control" type="text" ng-model="categoryName" placeholder='Max 20 letters' value=""/></br>
                    <label>Tag Name Chinese* </label>
                    <input class="form-control" type="text" ng-model="categoryNameCn" placeholder='Max 20 letters' value=""/></br>
                </div>
                <div class="modal-footer">
                    <a class="btn btn-secondary btn-default" ng-click="newCategory()">
                        <i class="fa fa-pencil"></i> ADD
                    </a>
                    <button type="button" class="btn btn-default btn-warning" data-dismiss="modal">
                        <i class="fa fa-power-off"></i> CLOSE
                    </button>
                </div>
            </div>

        </div>
    </div>

     <!--Edit Category Modal -->
    <div class="modal fade" id="category-edit-modal" role="dialog">
        <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Edit Tag</h4>
                </div>
                <div class="modal-body" id="admin-add-body">
                    <input hidden type="text" ng-model="categoryId" value="">
                    <label>Tag Name* </label>
                    <input class="form-control" type="text" ng-model="categoryName" placeholder='Max 20 letters' value=""/></br>
                    <label>Tag Name Chinese* </label>
                    <input class="form-control" type="text" ng-model="categoryNameCn" placeholder='Max 20 letters' value=""/></br>
                </div>
                <div class="modal-footer">
                    <a class="btn btn-secondary btn-default" ng-click="editCategory()">
                        <i class="fa fa-pencil"></i> UPDATE
                    </a>
                    <button type="button" class="btn btn-default btn-warning" data-dismiss="modal">
                        <i class="fa fa-power-off"></i> CLOSE
                    </button>
                </div>
            </div>

        </div>
    </div>
@stop

@section('css-reference')

@stop

@section('content')
    <div id="content">
        <div id="content-header">
            <h1>Tags Management

            </h1>
        </div>
        <!-- #content-header -->

        <div id="content-container">

            <div class="row">

                <div class="col-md-12">

                    <div class="portlet">

                        <a type="button" class="btn btn-secondary admin-add-btn" href="#category-add-modal" data-toggle="modal">New Tag</a>  
              
                        <div class="portlet-header">

                            <h3>
                                <i class="fa fa-list"></i>
                                Tag List
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
                                            <th data-filterable="true" data-sortable="true" data-direction="desc">ID
                                            </th>
                                            <th data-filterable="true" data-sortable="true" data-direction="desc">Tag
                                            </th>
                                            <th data-filterable="true" data-sortable="true" data-direction="desc">Tag Chinese
                                            </th>
                                            <th width=200>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr ng-repeat="x in category">
                                            <td ng-bind="x.id"></td>
                                            <td ng-bind="x.tag"></td>
                                            <td ng-bind="x.tag_cn"></td>
                                            <td>
                                                <a class="btn btn-info" href="#category-edit-modal" data-toggle="modal" ng-click="showEdit(x)">Edit</a>
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

@section('js-reference')

@stop

@section('js-function')
    <script>
        var app = angular.module('myApp', []);

        app.controller('adminCtrl', function($scope, $http) {

            $scope.category = {!! $tag !!};

            $scope.newCategory = function(){
                $http({
                    method: 'POST',
                    url: "/admin-add-tag",
                    data: {
                        name: $scope.categoryName,
                        name_cn: $scope.categoryNameCn,
                    }
                }).then(function successCallback(response) {
                    if (response.data.success == true) {
                        location.reload();
                    } else {
                        alert(response.data.msg);
                    }
                }, function errorCallback(response) {
                    alert("Error: " + response.status);
                });
            }

            $scope.showEdit = function(obj){
                $scope.categoryNameCn = obj.tag_cn;
                $scope.categoryName = obj.tag;
                $scope.categoryId = obj.id;
            }

            $scope.editCategory = function(){
                $http({
                    method: 'POST',
                    url: "/admin-edit-tag",
                    data: {
                        name_cn: $scope.categoryNameCn,
                        id: $scope.categoryId,
                        name: $scope.categoryName,
                    }
                }).then(function successCallback(response) {
                    if (response.data.success == true) {
                        location.reload();
                    } else {
                        alert(response.data.msg);
                    }
                }, function errorCallback(response) {
                    alert("Error: " + response.status);
                });
            }

            $scope.delete = function(obj){
                if (confirm("Are you sure to delete this category?")) {
                    $http({
                        method: "POST",
                        url: "/admin-delete-tag",
                        data: {
                            id: obj.id,
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

