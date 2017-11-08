<link rel="stylesheet" href="/assets/admin/js/plugins/fileupload/bootstrap-fileupload.css" type="text/css"/>
<link rel="stylesheet" href="/assets/admin/css/media-library.css" type="text/css"/>
<meta name="csrf-token" content="{{ csrf_token() }}">


<div data-loading style="z-index: 9999"></div>
<div class="modal fade" id="media_library_modal" tabindex="-1" role="dialog" ng-controller="medialModalCtrl">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header nm-modal-header">
                <h4>Media Library</h4>
            </div>
            <div class="modal-body">
                <div class="media-upload">
                    <div class="fileupload fileupload-new" data-provides="fileupload" style="padding-left: 5px">
                        <div class="fileupload-new thumbnail" style="border:none;"></div>
                        <div class="fileupload-preview fileupload-exists thumbnail"
                             style="line-height: 20px;"></div>
                        <div>
                            <span class="btn btn-info btn-file fileupload-new"><span class="fileupload-new">Choose Image</span><input
                                        type="file" file-model="myFile" multiple/></span>
                            <a href="javascript:void(0);" class="btn btn-info fileupload-exists"
                               ng-click="uploadImage()">Upload</a>
                            <a id="uploadImgCancel" href="#" class="btn btn-danger fileupload-exists" data-dismiss="fileupload">Cancel</a>
                            <input id="searchInput" type="text" ng-model="searchText" placeholder="Search Folder" style="position:relative;top:1px;left:10px;width:200px;height:33px;padding:0 10px;"/>
                        </div>
                    </div>
                </div>

                <div class="img-box">
                    <div id="folder-div">
                    <div id="folder-upper-div"></div>

                    <div ng-repeat="imgItem in folder | filter:searchText">
                        <div class="media-modal-item" id="@{{imgItem.id}}">
                            <div class="media-img">
                                <img class="folder" src="/assets/images/folder.png" alt="folder img"/>
                                <span class="media-folder-name" ng-bind="imgItem.name"></span>
                            </div>
                        </div>
                    </div>

                    <?php
                        // foreach($folder as $f) {
                        //     echo '<div class="media-modal-item ng-scope" id="'.$f->id.'">';
                        //         echo '<div class="media-img">';
                        //             echo '<img class="folder" src="../../../assets/images/folder.png" alt="folder img"/>';
                        //             echo '<span class="media-folder-name">'.$f->name.'</span>';
                        //         echo '</div>';
                        //     echo '</div>';
                        // }
                    ?>
                    </div>
                    <div class="media-modal-item" ng-repeat="imgItem in media" >
                        <div class="media-img" ng-click="tickModalMedia(imgItem)">
                            <img ng-src="@{{ imgItem.src_thumb }}" alt="media img">
                            <span class="media-folder-name" ng-bind="imgItem.foldername"></span>
                            <button class="media-tick-btn" ng-class="imgItem.tickClass">
                                <i class="fa fa-check-circle"></i></button>
                        </div>
                    </div>
                    <div class="clear-both"></div>
                    <button class="load-more-btn" ng-if="showLoadMore" ng-click="loadMoreImages()">Load More Files...</button>
                </div>

            </div>
            <div class="modal-footer">
                <button class="btn btn-info" ng-click="insertMedia()" data-dismiss="modal"><i class="fa fa-picture-o" style="margin-right: 3px"></i>Save</button>
            </div>
        </div>
    </div>
</div>


<script>
    $("#folder-div").on('click', '.folder', function(){
        var id = $(this).parent().parent().attr('id');
        var ele = document.querySelector("[ng-controller=medialModalCtrl]");
        var scope = angular.element(ele).scope();
        if (typeof scope.portfolio != 'undefined') {
            var portfolioid = scope.portfolio.id;
        } else {
            var portfolioid = "";
        }
        $.ajax({
            type: "POST",
            url: "/media-modal-sub-folder",
            data: {
                id: id,
                portfolioid: portfolioid,
            },
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            dataType: "json",
            success: function (data) {
                if (data.fatherId === ""){
                    var html = "";
                } else {
                    var html = '<div class="media-modal-item ng-scope" id="' + data.fatherId + '">'+
                        '<div class="media-img">'+
                            '<img class="folder" src="../../../assets/images/folder.png" alt="folder img"/>'+
                            '<span class="media-folder-name">..</span>'+
                        '</div>'+
                    '</div>';
                }
                // $.each(data.subFolder, function( index, value ) {
                //     html = html + '<div class="media-modal-item ng-scope" id="' + value.id + '">'+
                //         '<div class="media-img">'+
                //             '<img class="folder" src="../../../assets/images/folder.png" alt="folder img"/>'+
                //             '<span class="media-folder-name">' + value.name + '</span>'+
                //         '</div>'+
                //     '</div>';
                // });
                scope.folder = data.subFolder;
                data.medias.reverse();
                scope.mediaData = data.medias;
                scope.media = scope.mediaData.slice(0, 30);
                scope.showLoadMore = (scope.mediaData.length > scope.media.length) ? true : false;
                scope.$apply();
                $("#folder-upper-div").html(html);
            },
            error: function (jqXHR) {
                alert("Error：" + jqXHR.status);
            }
        });
    });
    
    var app = angular.module('myApp', ['ui.sortable']);

    app.controller('medialModalCtrl', function ($scope, $http, $timeout) {
        var initialLoadNum = 30;
        $scope.tickMediaAttr = [];
        
        $scope.tickModalMedia = function (media) {
            if($scope.pickMethod == "multi"){
                if (media.tickClass != "mediaTick") {
                    $scope.tickMediaAttr.push(media);
                    media.tickClass = "mediaTick";
                } else {
                    if ($scope.tickMediaAttr.indexOf(media) >= 0) {
                        $scope.tickMediaAttr.splice($scope.tickMediaAttr.indexOf(media), 1);
                    }
                    media.tickClass = "";
                    media.featured = 0;
                    media.narrow = 0;
                }
            }else{
                if (media.tickClass != "mediaTick") {
                    for (var x in $scope.tickMediaAttr) {
                        $scope.tickMediaAttr[x].tickClass = "";
                        $scope.tickMediaAttr.splice(x, 1);
                    }
                    $scope.tickMediaAttr.push(media);
                    media.tickClass = "mediaTick";
                } else {
                    if ($scope.tickMediaAttr.indexOf(media) >= 0) {
                        $scope.tickMediaAttr.splice($scope.tickMediaAttr.indexOf(media), 1);
                    }
                    media.tickClass = "";
                    media.featured = 0;
                    media.narrow = 0;
                }
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
                    $http.post("/media-upload-to-folder", {father: "0"});
                    alert("Upload Successfully!");
                    response.data.mediaInfo.reverse();
                    $scope.mediaData = response.data.mediaInfo.concat($scope.mediaData);
                    $scope.media = $scope.mediaData.slice(0, initialLoadNum);
                    $scope.showLoadMore = ($scope.mediaData.length > $scope.media.length) ? true : false;
                    $timeout(function() {
                        document.getElementById('uploadImgCancel').click();
                    }, 100);
                } else {
                    alert(response.data.msg);
                    document.getElementById('uploadImgCancel').click();
                }

            }, function errorCallback(response) {
                alert("Error: " + response.status);
            });
        };

        $scope.loadMoreImages = function () {
            var loadNum = 10;
            var terminate = $scope.media.length + loadNum;
            $scope.media = $scope.mediaData.slice(0, terminate);

            $scope.showLoadMore = ($scope.mediaData.length > $scope.media.length) ? true : false;
        };

        $scope.insertMedia = function(){
            $scope.$emit('mediaFromModal',$scope.tickMediaAttr);
            $scope.$emit('mediaAll',$scope.mediaData);
        };

        $scope.$on('pickMethod', function(event, data) {
            $scope.pickMethod = data;
        });

        $scope.$on('mediaFromModal', function(event, data) {
            $scope.tickMediaAttr = data;
        });

        $scope.$on('mediaAll', function(event, data) {
            $scope.mediaData = data;
            $scope.media = $scope.mediaData.slice(0, initialLoadNum);
            $scope.showLoadMore = ($scope.mediaData.length > $scope.media.length) ? true : false;
        });

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