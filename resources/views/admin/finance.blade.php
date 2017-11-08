@extends('layouts.admin')

@section('title')<title>Financial Report - Fine Food Group</title>@stop

@section('modal')

@stop

@section('css-reference')

@stop

@section('content')
    <div id="content">
        <div id="content-header">
            <h1>Financial Report</h1>
        </div>
        <!-- #content-header -->

        <div id="content-container">
            <div class="row">
                <div class="col-sm-2">
                    <div class="from-group">
                        <label>Report Start Date</label>
                        <div class="date-picker input-group date" data-auto-close="true" data-date-format="dd-mm-yyyy" data-date-autoclose="true">
                            <input class="form-control" type="text" ng-model="finance_start">
                            <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                        </div>
                    </div>
                </div>
                <div class="col-sm-2">
                    <div class="from-group">
                        <label>Report End Date</label>
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
                        <a type="button" class="btn btn-secondary admin-add-btn" ng-click="export()">EXPORT</a> 
                        <a type="button" class="btn btn-secondary admin-add-btn" ng-click="dayview()">Daily View</a>
                        <a type="button" class="btn btn-secondary admin-add-btn" ng-click="monthview()">Monthly View</a>
                        <div class="portlet-header">
                            <h3>
                                <i class="fa fa-list"></i>
                                Order Summary
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
                                            <th data-filterable="true" data-sortable="true" data-direction="desc">Date</th>
                                            <th data-filterable="true" data-sortable="true" data-direction="desc">Total</th>
                                            <th data-filterable="true" data-sortable="true" data-direction="desc">Success</th>
                                            <th data-filterable="true" data-sortable="true" data-direction="desc">Processing</th>
                                            <th data-filterable="true" data-sortable="true" data-direction="desc">Cancel By Buyer</th>
                                            <th data-filterable="true" data-sortable="true" data-direction="desc">Cancel By Seller</th>
                                            <th data-filterable="true" data-sortable="true" data-direction="desc">Return</th>
                                            <th data-filterable="true" data-sortable="true" data-direction="desc">Unpaid</th>
                                            <th data-filterable="true" data-sortable="true" data-direction="desc">Paid</th>
                                            <th data-filterable="true" data-sortable="true" data-direction="desc">Not shipped</th>
                                            <th data-filterable="true" data-sortable="true" data-direction="desc">Shipped</th>
                                            <th data-filterable="true" data-sortable="true" data-direction="desc">Sales</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr ng-repeat="x in report">
                                            <td style="white-space: nowrap" ng-bind="x.date"></td>
                                            <td ng-bind="x.total_order"></td>
                                            <td ng-bind="x.success"></td>
                                            <td ng-bind="x.processing"></td>
                                            <td ng-bind="x.cancel-buyer"></td>
                                            <td ng-bind="x.cancel-seller"></td>
                                            <td ng-bind="x.return"></td>
                                            <td ng-bind="x.payment-no"></td>
                                            <td ng-bind="x.payment-yes"></td>
                                            <td ng-bind="x.delivery-no"></td>
                                            <td ng-bind="x.deilvery-yes"></td>
                                            <td ng-bind="'({!!$currency!!})' + (x.sales | number:2)"></td>
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
            $scope.report = {!! $report !!};
            $scope.finance_start = "{!! $start !!}";
            $scope.finance_end = "{!! $end !!}";

            $scope.search = function(){
                url = "?start="+$scope.finance_start+"&end="+$scope.finance_end;
                location.href = url;
            }
            $scope.dayview = function(){
                url = "?start="+$scope.finance_start+"&end="+$scope.finance_end+"&view=day";
                location.href = url;
            }
            $scope.monthview = function(){
                url = "?start="+$scope.finance_start+"&end="+$scope.finance_end+"&view=month";
                location.href = url;
            }
            $scope.export = function(){
                url = "?start="+$scope.finance_start+"&end="+$scope.finance_end+"&view={!!$view!!}&export=1";
                var win = window.open(url, '_blank');
                // win.focus();
            }
        });
    </script>
@stop

