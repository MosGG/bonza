@extends('layouts.admin')

@section('title')<title>Refund Management - Fine Food Group</title>@stop

@section('modal')
@stop

@section('css-reference')
@stop

@section('content')
    <div id="content">
        <div id="content-header">
            <h1>Refund Management</h1>
        </div>
        <!-- #content-header -->

        <div id="content-container">
             <div class="row">
                <div class="col-sm-2">
                    <div class="from-group">
                        <label>Order Start Date</label>
                        <div class="date-picker input-group date" data-auto-close="true" data-date-format="dd-mm-yyyy" data-date-autoclose="true">
                            <input class="form-control" type="text" ng-model="finance_start">
                            <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                        </div>
                    </div>
                </div>
                <div class="col-sm-2">
                    <div class="from-group">
                        <label>Order End Date</label>
                        <div class="date-picker input-group date" data-auto-close="true" data-date="{!! $end !!}" data-date-format="dd-mm-yyyy" data-date-autoclose="true">
                            <input class="form-control" type="text" ng-model="finance_end">
                            <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                        </div>
                    </div>
                </div>
                <div class="col-sm-2">
                    <div class="from-group">
                        <div><label>&nbsp;</label></div>
                        <a type="button" class="btn btn-info" ng-click="search()">Search</a> 
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="portlet">
                        <div class="portlet-header">
                            <h3>
                                <i class="fa fa-list"></i>
                                Refund List
                            </h3>
                        </div>
                        <!-- /.portlet-header -->
                        <div class="portlet-content" id="cheee-admin-table-div">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover table-highlight table-checkable"
                                        data-provide="datatable"
                                        data-display-rows="50"
                                        data-info="true"
                                        data-search="true"
                                        data-length-change="true"
                                        data-paginate="true">
                                    <thead>
                                        <tr>
                                            <th data-filterable="true" data-sortable="true" data-direction="desc">ID</th>
                                            <th data-filterable="true" data-sortable="true" data-direction="desc">Date</th>
                                            <th data-filterable="true" data-sortable="true" data-direction="desc">User</th>
                                            <th data-filterable="true" data-sortable="true" data-direction="desc">Recipient</th>
                                            <th data-filterable="true" data-sortable="true" data-direction="desc">Address</th>
                                            <th data-filterable="true" data-sortable="true" data-direction="desc">Detail</th>
                                            <th data-filterable="true" data-sortable="true" data-direction="desc">Subtotal</th>
                                            <th data-filterable="true" data-sortable="true" data-direction="desc">Delivery</th>
                                            <th data-filterable="true" data-sortable="true" data-direction="desc">Payment</th>
                                            <th data-filterable="true" data-sortable="true" data-direction="desc">Order Status</th>
                                            <th data-filterable="true" data-sortable="true" data-direction="desc">Message</th>
                                            <th data-filterable="true" data-sortable="true" data-direction="desc">Contact</th>
                                            <th width=200>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr ng-repeat="x in refund">
                                            <td ng-bind="x.id"></td>
                                            <td ng-bind="x.date"></td>
                                            <td ng-bind="x.user"></td>
                                            <td ng-bind="x.recipient"></td>
                                            <td ng-bind="x.address"></td>
                                            <td>
                                                <p ng-repeat="p in x.orderDetail">
                                                    <span ng-bind="p.title"></span>
                                                    x<span ng-bind="p.quantity"></span>
                                                </p>
                                            </td>
                                            <td ng-bind="x.total_price | number:2"></td>
                                            <td ng-bind="x.delivery_status_name"></td>
                                            <td ng-bind="x.payment_status_name"></td>
                                            <td ng-bind="x.status_name"></td>
                                            <td ng-bind="x.message"></td>
                                            <td ng-bind="x.contact"></td>
                                            <td>
                                                <button class="btn btn-secondary" ng-if='x.status == 0' ng-click="confirm(x)">Confirm</button>
                                                <button class="btn btn-danger" ng-if='x.status == 0' ng-click="cancel(x)">Cancel</button>
                                                <button class="btn btn-warning" ng-if='x.status == 1' ng-click="return(x)">Processed</button>
                                                <button class="btn btn-warning" ng-if='x.status == -1' ng-click="return(x)">Canceled</button>
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
<script src="/assets/admin/js/plugins/datepicker/bootstrap-datepicker.js"></script>
@stop

@section('js-function')
    <script>
        $(".date-picker").datepicker();
        var app = angular.module('myApp', []);

        app.controller('adminCtrl', function($scope, $http) {

            $scope.refund = {!! $refund !!};
            $scope.finance_start = "{!! $start !!}";
            $scope.finance_end = "{!! $end !!}";

            $scope.confirm = function(obj){
                if (confirm("Are you sure to mark this refund as PROCESSED?")) {
                    $http({
                        method: "POST",
                        url: "/refund-status-change",
                        data: {
                            id: obj.id,
                            status: 1,
                        }
                    }).then(function successCallback(response) {
                        obj.status = 1;
                    }, function errorCallback(response) {
                    });
                }
            }
            $scope.cancel = function(obj){
                if (confirm("Are you sure to CANCEL this refund?")) {
                    $http({
                        method: "POST",
                         url: "/refund-status-change",
                        data: {
                            id: obj.id,
                            status: -1,
                        }
                    }).then(function successCallback(response) {
                        obj.status = -1;
                    }, function errorCallback(response) {
                    });
                }
            }
            $scope.return = function(obj){
                if (confirm("Are you sure to change the status to Waiting to be Processed?")) {
                    
                    $http({
                        method: "POST",
                         url: "/refund-status-change",
                        data: {
                            id: obj.id,
                            status: 0,
                        }
                    }).then(function successCallback(response) {
                        obj.status = 0;
                    }, function errorCallback(response) {
                    });
                }
            }
            $scope.search = function(){
                url = "?start="+$scope.finance_start+"&end="+$scope.finance_end+"%2023:59:59";
                location.href = url;
            }
        });
    </script>
@stop