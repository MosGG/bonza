@extends('layouts.admin')

@section('title')<title>Document - Cheee Admin</title>@stop

@section('css-reference')
    <link rel="stylesheet" href="/assets/admin/js/plugins/fileupload/bootstrap-fileupload.css" type="text/css"/>
@stop

@section('content')
    <div id="content">
        <div id="content-header">
            <h1>Document Management

            </h1>
        </div>
        <!-- #content-header -->

        <div id="content-container">

            <div class="row">

                <div class="col-md-12">

                    <div class="portlet">

                        <div class="fileupload fileupload-new" data-provides="fileupload"><input type="hidden" value="" name="">
                            <div class="input-group">
                                <div class="form-control">
                                    <i class="fa fa-file fileupload-exists"></i> <span class="fileupload-preview"></span>
                                </div>
                                <div class="input-group-btn">
                                    <span class="btn btn-default btn-file doc-upload-btn">
                                        <a href="javascript:void(0);" class="btn btn-secondary fileupload-new">Select file</a>
                                        <input type="file" file-model="myFile"/>
                                    </span>
                                    <a href="javascript:void(0);" class="btn btn-secondary fileupload-exists"
                                        ng-click="uploadImage()">Upload</a>
                                    <a id="uploadImgCancel" href="#" class="btn btn-danger fileupload-exists" data-dismiss="fileupload" style="margin-left:10px;">Cancel</a>
                                </div>

                               
                            </div>
                        </div>  

                        <div class="portlet-header">

                            <h3>
                                <i class="fa fa-table"></i>
                                Document List
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
                                        <th data-filterable="true" data-sortable="true" data-direction="desc">Url
                                        <th>Action</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                        <div>
                                            <tr ng-repeat="x in documents">
                                                <td ng-bind="x.url"></td>
                                                <td>
                                                    <button type="button" class="btn btn-danger" ng-click="delete(x)">Delete
                                                    </button>
                                                    <a class="btn btn-info" target="_blank" ng-href="/@{{x.src}}">Check</a>
                                                </td>
                                            </tr>
                                        </div>
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
    <script src="/assets/admin/js/plugins/fileupload/bootstrap-fileupload.js"></script>
@stop

@section('js-function')
    <script>
        var app = angular.module('myApp', []);

        app.controller('adminCtrl', function($scope, $http) {

            $scope.documents = {!! $documents !!};

            $scope.uploadImage = function(){
                var file = $scope.myFile;
                var formData = new FormData();
                var uploadUrl = "/file-upload";

                formData.append('file', file[0]);

                $http.post(uploadUrl, formData, {
                    transformRequest: angular.identity,
                    headers: {'Content-Type': undefined}
                }).then(function successCallback(response) {
                    if (response.data.success) {
                        alert("Upload Successfully!");
                        location.reload();
                    } else {
                        alert(response.data.msg);
                        document.getElementById('uploadImgCancel').click();
                    }
                }, function errorCallback(response) {
                    alert("Error: " + response.status);
                });
            }

            $scope.delete = function(obj){
                if (confirm("Are you sure to delete this document?")) {
                    $http({
                        method: "POST",
                        url: "/document-delete-action",
                        data: {
                            file: obj
                        }
                    }).then(function successCallback(response) {
                        location.reload();
                    }, function errorCallback(response) {
                    });
                }
            }
        });

         // File upload (Create the file model)
        app.directive('fileModel', ['$parse', function ($parse) {
            return {
                restrict: 'A',
                link: function (scope, element, attrs) {
                    var model = $parse(attrs.fileModel);
                    var modelSetter = model.assign;
                    element.bind('change', function () {
                        scope.$apply(function () {
                            modelSetter(scope, element[0].files);
                        });
                    });
                }
            };
        }]);
    </script>
@stop

