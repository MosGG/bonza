@extends('layouts.admin')

@section('title')<title>Orders Management - Fine Food Group</title>@stop

@section('modal')
    <!--Edit Category Modal -->
    <div class="modal fade" id="category-edit-modal" role="dialog">
        <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Edit Order</h4>
                </div>
                <div class="modal-body" id="admin-add-body">
                    <input hidden type="text" ng-model="orderId" value="">
                    <label>User: <span ng-bind="orderUser"></span></label><br>
                    <label>Currency: <span ng-bind="currency"></span></label><br>
                    <label>Order Detail: </label>
                    <table id="order-detail-table">
                        <tr>
                            <th>ID</th>
                            <th>Title</th>
                            <th>Unit Price</th>
                            <th>Quantity</th>
                            <th>Subtotal</th>
                            <th>Action</th>
                        </tr>
                        <tr ng-repeat="p in orderDetail track by $index">
                            <td><input style="width:60px" type="text" ng-model="p.id" disabled value=""></td>
                            <td><input type="text" ng-model="p.title" value="" disabled></td>
                            <td><input style="width:60px" type="text" ng-model="p.unitprice" ng-change="changeprice($index)" value=""></td>
                            <td>
                                <span ng-click="decreaseQ($index)"> - </span>
                                <input style="width:30px" type="text" ng-model="p.quantity" ng-change="changeprice($index)" value="">
                                <span ng-click="increaseQ($index)"> + </span>
                            </td>
                            <td><input style="width:60px" type="text" ng-model="p.subtotal" ng-change="calculateTotal()" value=""></td>
                            <td><button type="button" class="btn btn-danger" ng-click="removeProduct($index)">Delete</button></td>
                        </tr>
                        <tr>
                            <td><input style="width:60px" type="text" value="" ng-model="newProductId" placeholder="ID"></td>
                            <td><button type="button" class="btn btn-info" ng-click="addProduct()">Add</button></td>
                            <td></td>
                            <td>Total:(<span ng-bind="currency"></span>)</td>
                            <td><input style="width:60px" type="text" ng-model="orderTotal" value=""/></td>
                            <td></td>
                        </tr>
                    </table>
                    <br>
                    <label>Recipient: </label>
                    <input class="form-control" type="text" ng-model="orderRecipient" value=""/>
                    <label>Address: </label>
                    <input class="form-control" type="text" ng-model="orderAddress" value=""/></br>


                    <label>Payment Status: </label>
                    <select id="paystatus">
                      <option value="-1">Refound</option>
                      <option value="0">Unpaid</option>
                      <option value="1">Paid</option>
                    </select><br>
                    <label>Delivery Status: </label>
                    <select id="delstatus">
                      <option value="-1">Return</option>
                      <option value="0">Unshipped</option>
                      <option value="1">Shipped</option>
                    </select><br>
                    <label>Order Status: </label>
                    <select id="ordstatus">
                      <option value="-3">Refound or Return</option>
                      <option value="-2">Cancel By Seller</option>
                      <option value="-1">Cancel By Buyer</option>
                      <option value="0">Pending</option>
                      <option value="1">Success</option>
                    </select>

                </div>
                <div class="modal-footer">
                    <a class="btn btn-secondary btn-default" ng-click="updateOrder()">
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
            <h1>Order Management

            </h1>
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

<!--                         <a type="button" class="btn btn-secondary admin-add-btn" href="#category-add-modal" data-toggle="modal">New Tag</a>   -->
              
                        <div class="portlet-header">

                            <h3>
                                <i class="fa fa-list"></i>
                                Order List
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
                                            <th data-filterable="true" data-sortable="true" data-direction="desc">ID</th>
                                            <th data-filterable="true" data-sortable="true" data-direction="desc">Date</th>
                                            <th data-filterable="true" data-sortable="true" data-direction="desc">User</th>
                                            <th data-filterable="true" data-sortable="true" data-direction="desc">Recipient</th>
                                            <th data-filterable="true" data-sortable="true" data-direction="desc">Address</th>
                                            <th data-filterable="true" data-sortable="true" data-direction="desc">Detail</th>
                                            <th data-filterable="true" data-sortable="true" data-direction="desc">Subtotal</th>
                                            <th data-filterable="true" data-sortable="true" data-direction="desc">Delivery</th>
                                            <th data-filterable="true" data-sortable="true" data-direction="desc">Payment</th>
                                            <th data-filterable="true" data-sortable="true" data-direction="desc">Status</th>
                                            <th width=200>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr ng-repeat="x in category">
                                            <td ng-bind="x.id"></td>
                                            <td ng-bind="x.date"></td>
                                            <td ng-bind="x.user_id"></td>
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
                                            <td>
                                                <a class="btn btn-info" href="#category-edit-modal" data-toggle="modal" ng-click="showEdit(x)">Edit</a>
                                                <!-- <button type="button" class="btn btn-danger" ng-click="delete(x)">Delete
                                                </button> -->
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

            $scope.category = {!! $orders !!};
            $scope.finance_start = "{!! $start !!}";
            $scope.finance_end = "{!! $end !!}";

            $scope.showEdit = function(obj){
                $scope.orderUser = obj.user_id;
                $scope.orderRecipient = obj.recipient;
                $scope.orderAddress = obj.address;
                $scope.orderDetail = obj.orderDetail;
                $scope.orderTotal = obj.total_price;
                $("#ordstatus").val(obj.status);
                $("#paystatus").val(obj.payment_status);
                $("#delstatus").val(obj.delivery_status);
                if(obj.region == "en") {
                    $scope.currency = "AUD";
                } else {
                    $scope.currency = "CNY";
                }
                $scope.orderId = obj.id;
            }

            $scope.updateOrder = function(){
                console.log($scope.orderDetail);
                console.log($scope.orderStatus);
                $http({
                    method: 'POST',
                    url: "/admin-update-order",
                    data: {
                        id: $scope.orderId,
                        recipient: $scope.orderRecipient,
                        address: $scope.orderAddress,
                        detail: JSON.stringify($scope.orderDetail),
                        total: $scope.orderTotal,
                        status: $("#ordstatus").val(),
                        paymentstatus: $("#paystatus").val(),
                        deliverystatus: $("#delstatus").val(),
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

            $scope.addProduct = function(){
                var newline = {"id":"","title":"","unitprice":"","quantity":"1","subtotal":""};
                $http({
                    method: 'POST',
                    url: "/admin-get-product-by-id",
                    data: {
                        id: $scope.newProductId,
                        region: $scope.orderRegion,
                    }
                }).then(function successCallback(response) {
                    if (response.data.success == true) {
                        newline = response.data.product;
                    }
                    $scope.orderDetail.push(newline);
                    $scope.calculateTotal();
                }, function errorCallback(response) {
                    alert("Error: " + response.status);
                });
                $scope.newProductId = "";
            }

            $scope.removeProduct = function(index){
                $scope.orderDetail.splice(index,1);
            }

            $scope.decreaseQ = function(index){
                $scope.orderDetail[index].quantity--;
                $scope.changeprice(index);
            }
            $scope.increaseQ = function(index){
                $scope.orderDetail[index].quantity++;
                $scope.changeprice(index);
            }
            $scope.changeprice = function(index){
                $scope.orderDetail[index].subtotal = $scope.orderDetail[index].quantity * $scope.orderDetail[index].unitprice;
                $scope.calculateTotal();
            }
            $scope.calculateTotal = function(){
                var sum = 0;
                for(i in $scope.orderDetail){
                    sum += parseFloat($scope.orderDetail[i].subtotal);
                }
                $scope.orderTotal = sum;
            }
            $scope.search = function(){
                url = "?start="+$scope.finance_start+"&end="+$scope.finance_end+"%2023:59:59";
                location.href = url;
            }
        });
    </script>
@stop

