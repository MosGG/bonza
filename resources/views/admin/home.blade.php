@extends('layouts.admin')

@section('title')<title>Home - Fine Food Group Admin</title>@stop

    @section('modal')
    <!--NEW ADMIN Modal -->
    <div class="modal fade" id="admin-add-modal" role="dialog">
        <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">New Admin</h4>
                </div>
                <div class="modal-body" id="admin-add-body">
                    <label>Username</label>
                    <input class="form-control" type="text" ng-model="adminAddName"
                           value=""/></br>
                    <label>Email</label>
                    <input class="form-control" type="text" ng-model="adminAddEmail"
                           value=""/></br>
                    <label>Phone</label>
                    <input class="form-control" type="text" ng-model="adminAddPhone"
                           value=""/></br>
                    </br>
                    <label>Password</label>
                    <input class="form-control" type="password" ng-model="adminAddPassword"
                           value=""/></br>
                    </br>
                    <label>Level</label>
                    <select ng-model="adminAddLevel" class="form-control margin-bottom-20">
                        <option value="administrator">Administrator</option>
                        <option value="staff">Staff</option>
                    </select>
                </div>
                <div class="modal-footer">
                    <a class="btn btn-secondary btn-default" ng-click="new()"><i
                                class="fa fa-pencil"></i>
                        ADD</a>
                    <button type="button" class="btn btn-default btn-warning" data-dismiss="modal"><i
                                class="fa fa-power-off"></i> CLOSE
                    </button>
                </div>
            </div>

        </div>
    </div>

    <!--ADMIN Edit Modal -->
    <div class="modal fade" id="admin-edit-modal" role="dialog">
        <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Detail of Admin</h4>
                </div>
                <div class="modal-body" id="admin-edit-body" >
                    <input type="hidden" class="form-control" value="" ng-model="adminId" /></br>
                    <label>Username</label>
                    <input class="form-control" type="text" value="" ng-model="adminName" /></br>
                    <label>Email</label>
                    <input class="form-control" type="text" value="" ng-model="adminEmail" /></br>
                    <label>Phone</label>
                    <input class="form-control" type="text" value="" ng-model="adminPhone"/></br>
                    <label>Password</label>
                    <input class="form-control" type="password" value="" ng-model="adminPassword" /></br>
                    <label>Level</label>
                    <select class="form-control margin-bottom-20" ng-model="adminLevel">
                        <option value="administrator">Administrator</option>
                        <option value="staff">Staff</option>
                    </select>
                </div>
                <div class="modal-footer">
                    <a class="btn btn-info btn-default" ng-click="update()"><i class="fa fa-pencil"></i> UPDATE</a>
                    <button type="button" class="btn btn-default btn-warning" data-dismiss="modal"><i class="fa fa-power-off"></i> CLOSE
                    </button>
                </div>
            </div>

        </div>
    </div>
@stop

@section('content')
    <div id="content">
        <div id="content-header">
            <h1>Admin Management

            </h1>
        </div>
        <!-- #content-header -->

        <div id="content-container">

            <div class="row">

                <div class="col-md-12">

                    <div class="portlet">

                        <button type="button" class="btn btn-secondary admin-add-btn" href="#admin-add-modal"
                                data-toggle="modal">New
                            Admin
                        </button>

                        <div class="portlet-header">

                            <h3>
                                <i class="fa fa-table"></i>
                                Admin Table
                            </h3>

                        </div>
                        <!-- /.portlet-header -->

                        <div class="portlet-content" id="cheee-admin-table-div">
                            <div class="table-responsive">
                                <table
                                        class="table table-striped table-bordered table-hover table-highlight table-checkable"
                                        data-provide="datatable"
                                        data-display-rows="10"
                                        data-info="true"
                                        data-search="true"
                                        data-length-change="true"
                                        data-paginate="true"
                                        >
                                    <thead>
                                    <tr>
                                        <th data-filterable="true" data-sortable="true" data-direction="desc">Username
                                        </th>
                                        <th data-direction="asc" data-filterable="true" data-sortable="true">Phone
                                        </th>
                                        <th data-direction="asc" data-filterable="true" data-sortable="true">Email
                                        </th>
                                        <th data-filterable="true" data-sortable="true">Level</th>
                                        <th>Action</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                        <tr ng-repeat="x in admins">
                                            <td ng-bind="x.username"></td>
                                            <td ng-bind="x.phone"></td>
                                            <td ng-bind="x.email"></td>
                                            <td ng-bind="x.level"></td>
                                            <td>
                                                <button type="button" class="btn btn-info" href="#admin-edit-modal" data-toggle="modal" ng-click="showEdit(x)">Edit
                                                </button>
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

            $scope.adminAddLevel = "administrator";

            $scope.admins = {!! $admins !!};
            
            $scope.showEdit = function(obj){
                $scope.adminName = obj.username;
                $scope.adminId = obj.id;
                $scope.adminPhone = obj.phone;
                $scope.adminLevel = obj.level;
                $scope.adminEmail = obj.email;
                $scope.adminPassword= obj.password;
            }

            $scope.delete = function(obj){
                if (confirm("Are you sure to delete this admin?")) {
                    $http({
                        method: "POST",
                        url: "/admin-delete-action",
                        data: {
                            id: obj.id
                        }
                    }).then(function successCallback(response) {
                        location.reload();
                    }, function errorCallback(response) {
                    });
                }
            }

            $scope.new = function(){
                $http({
                    method: 'POST',
                    url: "/admin-add-action",
                    data: {
                    username: $scope.adminAddName,
                    phone: $scope.adminAddPhone,
                    email: $scope.adminAddEmail,
                    pwd: $scope.adminAddPassword,
                    level: $scope.adminAddLevel
                    }
                }).then(function successCallback(response) {
                    location.reload();
                }, function errorCallback(response) {
                });
            }

            $scope.update = function(){
                $http({
                    method: 'POST',
                    url: "/admin-edit-action",
                    data: {
                    id: $scope.adminId,
                    username: $scope.adminName,
                    phone: $scope.adminPhone,
                    email: $scope.adminEmail,
                    pwd: $scope.adminPassword,
                    level: $scope.adminLevel
                    }
                }).then(function successCallback(response) {
                    location.reload();
                }, function errorCallback(response) {
                });
            }
        });
    </script>
@stop

