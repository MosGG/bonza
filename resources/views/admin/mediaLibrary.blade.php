@extends('layouts.admin')

@section('title')
    Media Library - TG Estate Admin
@stop
    <meta name="csrf-token" content="{{ csrf_token() }}">
@section('css-reference')
    <link rel="stylesheet" href="/assets/admin/js/plugins/fileupload/bootstrap-fileupload.css" type="text/css"/>
    <link rel="stylesheet" href="/assets/admin/css/media-library.css" type="text/css"/>
    @stop

    @section('modal')
    <!--single image modal -->
    <div class="modal fade" id="media-detail" tabindex="-1" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5>Image Detail</h5>
                </div>
                <div class="modal-body media-detail-body">
                    <div class="single-media-image-div"><img id="single-media-image" ng-src="@{{ mediaObj.src }}"
                                                             alt="media-img"></div>
                    <dl class="dl-horizontal">
                        <dt>Media Type:</dt>
                        <dd>@{{ mediaObj.category }}</dd>
                        <dt>Media ID:</dt>
                        <dd>@{{ mediaObj.id }}</dd>
                        <dt>Media url:</dt>
                        <dd style="word-break: break-all;">@{{ mediaObj.src }}</dd>
                    </dl>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" data-dismiss="modal">OK</button>
                </div>
            </div>
        </div>
    </div>
    <div data-loading></div>

@stop

@section('content')
    <div id="content">
        <div id="content-header">
            <h1>Media Library</h1>
        </div>

        <div id="content-container">
            <div class="media-library">

                <div class="media-upload">
                    <div class="fileupload fileupload-new" data-provides="fileupload" style="padding-left: 5px">
                        <div class="fileupload-new thumbnail" style="border:none;"></div>
                        <div class="fileupload-preview fileupload-exists thumbnail"
                             style="line-height: 20px;"></div>
                        <div>
                            <span class="btn btn-secondary btn-file fileupload-new"><span class="fileupload-new">Upload Image</span><input
                                        type="file" file-model="myFile" multiple/></span>
                            <a href="javascript:void(0);" class="btn btn-secondary fileupload-exists"
                               ng-click="uploadImage()">Upload</a>
                            <a id="uploadImgCancel" href="#" class="btn btn-danger fileupload-exists" data-dismiss="fileupload">Cancel</a>
                        </div>
                    </div>
                </div>
                <button id="newfolder" class="btn btn-secondary" style="position: absolute; top:13px; left:135px">New Folder</button>

                <button class="btn btn-danger multi-delete-btn" ng-click="deleteMedia(imgItem)">Delete Media Files</button>
                <!-- /.col -->

                <input type="hidden" id="uplevel" father="{{$father}}">
                <div class="media-item ng-scope" id="{{$upper}}" style="<?php echo ($father == "0") ? "display:none;" : "" ?>">
                    <div class="media-img">
                        <img class="folder" src="../../../assets/images/folder.png" alt="folder img"/>
                        <span class="media-folder-name">..</span>
                    </div>
                    <div class="media-actions"></div>
                </div>
                <?php
                    foreach($folder as $f) {
                        echo '<div class="media-item ng-scope" id="'.$f->id.'">';
                            echo '<div class="media-img">';
                                echo '<img class="folder" src="../../../assets/images/folder.png" alt="folder img"/>';
                                echo '<span class="media-folder-name">'.$f->name.'</span>';
                            echo '</div>';
                            echo '<div class="media-actions">';
                                echo '<button class="media-delete-btn delfolder"><i class="fa fa-trash-o"></i></button>';
                            echo '</div>';
                        echo '</div>';
                    }
                ?>
                <div id="img-box">
                    <div class="media-item" ng-repeat="imgItem in media">
                        <div class="media-img">
                            <input type="hidden" class="imgId" ng-value="imgItem.id"/>
                            <img ng-src="@{{ imgItem.src_thumb }}" alt="media img" ng-click="showMediaDetail(imgItem)">
                        </div>
                        <div class="media-actions">
                            <button class="media-tick-btn" ng-class="imgItem.tickClass" ng-click="tickMediafiles(imgItem)">
                                <i class="fa fa-check-circle"></i></button>
                            <button class="media-delete-btn" ng-click="deleteMedia(imgItem)"><i class="fa fa-trash-o"></i>
                            </button>
                        </div>
                    </div>
                    <button class="load-more-btn" ng-if="showLoadMore" ng-click="loadMoreImages()">Load More Files...</button>
                </div>
            </div>
        </div>
    </div>
@stop

@section('js-reference')
    <script src="/assets/admin/js/plugins/fileupload/bootstrap-fileupload.js"></script>
@stop

@section('js-function')
    <script>
        
        $(function() {
            $("#uplevel").click(function(){
                var id = $(this).attr('father');
                window.open('media-library?up=' + id,'_self');
            });
            
            $("#newfolder").click(function(){
                var value = prompt('Folder Name:', 'new folder'); 
                if (value !== null) {
                    $.ajax({
                        type: "POST",
                        url: "media-library-new-folder",
                        data: {
                            name: value,
                            father: $("#uplevel").attr('father'),
                        },
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        dataType: "json",
                        success: function (data) {
                            location.reload();
                        },
                        error: function (jqXHR) {
                            alert("Error：" + jqXHR.status);
                        }
                    });
                }
            });
            
            $(".delfolder").click(function(){
                if (confirm("Are you sure to delete this folder? All related images will be moved to the up level.")) {
                    $.ajax({
                        type: "POST",
                        url: "media-library-delete-folder",
                        data: {
                            id: $(this).parent().parent().attr('id'),
                        },
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        dataType: "json",
                        success: function (data) {
                            window.open('media-library?folder=' + $("#uplevel").attr('father'), '_self');
                        },
                        error: function (jqXHR) {
                            alert("Error：" + jqXHR.status);
                        }
                    });
                }
            });
            
            $(".folder").click(function(){
                window.open('media-library?folder=' + $(this).parent().parent().attr("id"),'_self');
            });
            
            $("#img-box").sortable();
            $( ".folder" ).droppable({
                drop: function(event, ui) {
                    var id = new Array();
                    var img = ui.draggable[0];
                    if ($(".mediaTick").parent().siblings(".media-img").find(".imgId").val()) {
                        $(".mediaTick").each(function(){
                            id.push($(this).parent().siblings(".media-img").find(".imgId").val());
                        });
                    } else {
                        id.push($(img).find(".imgId").val());
                    }
                    var folderid = $(this).parent().parent().attr('id');
                    $.ajax({
                        type: "POST",
                        url: "media-library-move",
                        data: {
                            imgid: id,
                            folderid: folderid
                        },
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        dataType: "json",
                        success: function (data) {
                            $(".mediaTick").each(function(){
                                $(this).parent().parent().hide();
                            });
                            $(img).hide();
                        },
                        error: function (jqXHR) {
                            alert("Error：" + jqXHR.status);
                        }
                    });
                }
            });
        });
        
        var app = angular.module("myApp", []);

        app.controller('adminCtrl', function ($scope, $http, $timeout) {
            var initialLoadNum = 30;

            $scope.mediaData = {!! $media !!};
            $scope.mediaData.reverse();
            $scope.media = $scope.mediaData.slice(0, initialLoadNum);

            $scope.showLoadMore = ($scope.mediaData.length > $scope.media.length)?true:false;

            $scope.tickMediaAttr = [];
            $scope.showMediaDetail = function (media) {
                $scope.mediaObj = media;
                $("#media-detail").modal('show');
            };

            $scope.tickMediafiles = function (media) {
                if (media.tickClass != "mediaTick") {
                    $scope.tickMediaAttr.push(media);
                    media.tickClass = "mediaTick";
                } else {
                    if ($scope.tickMediaAttr.indexOf(media) >= 0) {
                        $scope.tickMediaAttr.splice($scope.tickMediaAttr.indexOf(media), 1);
                    }
                    media.tickClass = "";
                }
            };


            $scope.uploadImage = function () {
                var file = $scope.myFile;
                var uploadUrl = "/media-upload";
                var formData = new FormData();
                for (var i = 0 ; i < file.length ; i++) {
                    formData.append(i, file[i]);
                }

                $http.post(uploadUrl, formData, {
                    transformRequest: angular.identity,
                    headers: {'Content-Type': undefined}
                }).then(function successCallback(response) {
                    if (response.data.success) {
                        $http.post("/media-upload-to-folder", {father: $("#uplevel").attr('father')});
                        alert("Upload Successfully!");
//                        $scope.mediaData = response.data.mediaFiles;
//                        $scope.mediaData.reverse();
//                        $scope.media = $scope.mediaData.slice(0, initialLoadNum);
//                        $scope.showLoadMore = ($scope.mediaData.length > $scope.media.length)?true:false;
//                        $timeout(function() {
//                            document.getElementById('uploadImgCancel').click();
//                        }, 100);
                        window.open('media-library?folder=' + $("#uplevel").attr('father'), '_self');
                    } else {
                        alert(response.data.msg);
                        document.getElementById('uploadImgCancel').click();
                    }

                }, function errorCallback(response) {
                    alert("Error: " + response.status);
                });
            };

            $scope.deleteMedia = function (media) {
                var mediaAttr = [];
                if(typeof media != "undefined"){
                    mediaAttr.push(media);
                }else{
                    mediaAttr = $scope.tickMediaAttr;
                    if(mediaAttr.length == 0){
                        alert("Please choose the media files that you want to delete.")
                        return false;
                    }
                }
                var mediaJson = {"mediaJson": JSON.stringify(mediaAttr)};
                if (confirm("Do you want to delete the file/files from media library?")) {
                    $http.post("/delete-media-file", mediaJson).then(function successCallback(response) {
                        if (response.data.success) {
                            $scope.tickMediaAttr = [];
                            $scope.mediaData = response.data.mediaFiles;
                            $scope.mediaData.reverse();
                            $scope.media = $scope.mediaData.slice(0, initialLoadNum);
                            $scope.showLoadMore = ($scope.mediaData.length > $scope.media.length)?true:false;
                        } else {
                            alert(response.data.msg);
                        }

                    }, function errorCallback(response) {
                        alert("Error: " + response.status);
                    });
                }
            };

            $scope.loadMoreImages = function(){
                var loadNum = 10;
                var terminate = $scope.media.length + loadNum;
                $scope.media = $scope.mediaData.slice(0, terminate);
                $scope.showLoadMore = ($scope.mediaData.length > $scope.media.length)?true:false;
            };
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

        app.directive('loading',   ['$http' ,function ($http)
        {
           return {
               restrict: 'A',
               template : '<div class="loading-spiner-holder" ng-show="showMe"><div class="loading-spiner">'
                           +'<img src="/assets/img/loading.gif"></div></div>',
               replace: true,
               link: function (scope, elm, attrs)
               {
                   scope.isLoading = function () {
                       return $http.pendingRequests.length > 0;
                   };

                   scope.$watch(scope.isLoading, function (v)
                   {

                       if(v){
                           scope.showMe = true;
                       }else{
                           scope.showMe = false;
                       }
                   });
               }
           };
       }]);

    </script>
@stop