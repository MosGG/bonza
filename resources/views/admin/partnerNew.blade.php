@extends('layouts.admin')

@section('title')<title>Partner New - The Map Admin</title>@stop

@section('css-reference')
    <link href="/assets/admin/js/plugins/html-editor/css/froala_editor.min.css" rel="stylesheet" type="text/css" />
    <link href="/assets/admin/js/plugins/html-editor/css/froala_style.min.css" rel="stylesheet" type="text/css" />

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.3.0/codemirror.min.css">

    <!-- Include Editor Plugins style. -->
    <link rel="stylesheet" href="/assets/admin/js/plugins/html-editor/css/plugins/char_counter.css">
    <link rel="stylesheet" href="/assets/admin/js/plugins/html-editor/css/plugins/code_view.css">
    <link rel="stylesheet" href="/assets/admin/js/plugins/html-editor/css/plugins/colors.css">
    <link rel="stylesheet" href="/assets/admin/js/plugins/html-editor/css/plugins/emoticons.css">
    <link rel="stylesheet" href="/assets/admin/js/plugins/html-editor/css/plugins/file.css">
    <link rel="stylesheet" href="/assets/admin/js/plugins/html-editor/css/plugins/fullscreen.css">
    <link rel="stylesheet" href="/assets/admin/js/plugins/html-editor/css/plugins/image.css">
    <link rel="stylesheet" href="/assets/admin/js/plugins/html-editor/css/plugins/image_manager.css">
    <link rel="stylesheet" href="/assets/admin/js/plugins/html-editor/css/plugins/line_breaker.css">
    <link rel="stylesheet" href="/assets/admin/js/plugins/html-editor/css/plugins/quick_insert.css">
    <link rel="stylesheet" href="/assets/admin/js/plugins/html-editor/css/plugins/table.css">
    <link rel="stylesheet" href="/assets/admin/js/plugins/html-editor/css/plugins/video.css">
    <link rel="stylesheet" href="/assets/admin/js/plugins/timepicker/bootstrap-timepicker.css" type="text/css" />
@stop

@section('modal')
    @include('partial.mediaModal')
@stop

@section('content')

    <div id="content">
        <div id="content-header">
            <h1>New Partner
            </h1>
        </div>
        <!-- #content-header -->

        <div id="content-container">
            <div class="portlet">
                <div class="portlet-header">
                    <h3>
                        <i class="fa fa-tasks"></i>
                        Partner Information
                    </h3>
                </div>
                <!-- /.portlet-header -->
                <div class="portlet-content">
                    <!-- /.table-responsive -->

                    <div class="row">
                        <div class="col-sm-4">
                            <div class="from-group">
                                <label>Partner Title</label>
                                <input type="text" ng-model="portfolioTitle" class="form-control">
                            </div>
                        </div>

                        <div class="col-sm-4">
                            <div class="from-group">
                                <label>Partner Title_cn</label>
                                <input type="text" ng-model="portfolioTitle_cn" class="form-control">
                            </div>
                        </div>

                        <div class="col-sm-2">
                            <div class="from-group">
                                <label>Partner Type</label>
                                <select ng-model="portfolioType" class="form-control">
                                    <option value="Banking">Banking</option>
                                    <option value="Legal">Legal & Finance</option>
                                    <option value="Estate">Real Estate</option>
                                    <option value="Industry">Industry Experts</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-sm-2">
                            <div class="from-group">
                                <label>Create Date</label>
                                <div id="project-date" class="input-group date" data-auto-close="true" data-date-format="dd-mm-yyyy" data-date-autoclose="true">
                                    <input class="form-control" type="text" ng-model="portfolioDate">
                                    <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                </div>
                            </div>
                        </div>
                    </div>

                   <div class="row">
                        <div class="col-sm-12">
                            <div class="from-group">
                                <label>Description</label>
                                <input type="text" ng-model="portfolioDescription" class="form-control">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-12">
                            <div class="from-group">
                                <label>Description Chinese</label>
                                <input type="text" ng-model="portfolioDescription_cn" class="form-control">
                            </div>
                        </div>
                    </div>

                    <div class="row photo-gallery">
                        <div class="col-sm-12">
                            <div style="padding-bottom: 16px">
                                <button class="btn btn-secondary" ng-click="showMediaModal()">Insert Photo From Media Library</button>
                            </div>
                            <div ui-sortable="sortableOptions" ng-model="tickMediaAttr">
                                <div class="media-modal-item" ng-repeat="media in tickMediaAttr" >
                                    <div class="media-img">
                                        <button class="media-left-top-btn" ng-class="{'mediaTickBlue': media.narrow == 1}" ng-click="chooseNarrowImage(media)"><i class="fa fa-th"></i></button>
                                        <img ng-src="@{{ media.src_thumb }}" alt="media img">
                                        <button class="media-tick-btn" ng-class="{'mediaTick': media.featured}" ng-click="chooseFeatured(media)">
                                            <i class="fa fa-check-circle"></i></button>
                                        <button class="media-delete-btn" ng-click="removePhoto(media)">
                                            <i class="fa fa-trash-o"></i></button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.portlet-content -->
            </div>
            <!-- /.portlet -->

            <div class="row">
                <div class="col-sm-12">
                    <div class="from-group">
                        <button class="btn btn-secondary admin-add-btn pull-left" ng-click="new()">Submit
                        </button>
                         <a type="button" class="btn btn-default btn-warning pull-left" href="/admin-partner" style="margin-left: 10px;">Cancel
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <!-- /#content-container -->
    </div> <!-- #content -->
@stop

@section('js-reference')
    <script src="/assets/admin/js/plugins/fileupload/bootstrap-fileupload.js"></script>
    <script type="text/javascript" src="/assets/admin/js/plugins/html-editor/js/froala_editor.min.js"></script>

    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.3.0/codemirror.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.3.0/mode/xml/xml.min.js"></script>

     <!-- Include Plugins. -->
    <script type="text/javascript" src="/assets/admin/js/plugins/html-editor/js/plugins/align.min.js"></script>
    <script type="text/javascript" src="/assets/admin/js/plugins/html-editor/js/plugins/char_counter.min.js"></script>
    <script type="text/javascript" src="/assets/admin/js/plugins/html-editor/js/plugins/code_beautifier.min.js"></script>
    <script type="text/javascript" src="/assets/admin/js/plugins/html-editor/js/plugins/code_view.min.js"></script>
    <script type="text/javascript" src="/assets/admin/js/plugins/html-editor/js/plugins/colors.min.js"></script>
    <script type="text/javascript" src="/assets/admin/js/plugins/html-editor/js/plugins/emoticons.min.js"></script>
    <script type="text/javascript" src="/assets/admin/js/plugins/html-editor/js/plugins/entities.min.js"></script>
    <script type="text/javascript" src="/assets/admin/js/plugins/html-editor/js/plugins/file.min.js"></script>
    <script type="text/javascript" src="/assets/admin/js/plugins/html-editor/js/plugins/font_family.min.js"></script>
    <script type="text/javascript" src="/assets/admin/js/plugins/html-editor/js/plugins/font_size.min.js"></script>
    <script type="text/javascript" src="/assets/admin/js/plugins/html-editor/js/plugins/fullscreen.min.js"></script>
    <script type="text/javascript" src="/assets/admin/js/plugins/html-editor/js/plugins/image.min.js"></script>
    <script type="text/javascript" src="/assets/admin/js/plugins/html-editor/js/plugins/image_manager.min.js"></script>
    <script type="text/javascript" src="/assets/admin/js/plugins/html-editor/js/plugins/inline_style.min.js"></script>
    <script type="text/javascript" src="/assets/admin/js/plugins/html-editor/js/plugins/line_breaker.min.js"></script>
    <script type="text/javascript" src="/assets/admin/js/plugins/html-editor/js/plugins/link.min.js"></script>
    <script type="text/javascript" src="/assets/admin/js/plugins/html-editor/js/plugins/lists.min.js"></script>
    <script type="text/javascript" src="/assets/admin/js/plugins/html-editor/js/plugins/paragraph_format.min.js"></script>
    <script type="text/javascript" src="/assets/admin/js/plugins/html-editor/js/plugins/paragraph_style.min.js"></script>
    <script type="text/javascript" src="/assets/admin/js/plugins/html-editor/js/plugins/quick_insert.min.js"></script>
    <script type="text/javascript" src="/assets/admin/js/plugins/html-editor/js/plugins/quote.min.js"></script>
    <script type="text/javascript" src="/assets/admin/js/plugins/html-editor/js/plugins/table.min.js"></script>
    <script type="text/javascript" src="/assets/admin/js/plugins/html-editor/js/plugins/save.min.js"></script>
    <script type="text/javascript" src="/assets/admin/js/plugins/html-editor/js/plugins/url.min.js"></script>
    <script type="text/javascript" src="/assets/admin/js/plugins/html-editor/js/plugins/video.min.js"></script>

    <script type="text/javascript" src="/assets/admin/js/plugins/angular-ui-sortable/dist/sortable.min.js"></script>
    <script src="/assets/admin/js/plugins/datepicker/bootstrap-datepicker.js"></script>
    <script src="/assets/admin/js/plugins/timepicker/bootstrap-timepicker.js"></script>
@stop

@section('js-function')

    <script>
    
        $(function() {
            $('#project-date').datepicker ()
            $('div#cheee-admin-editor').froalaEditor({
                toolbarButtons: ['fullscreen', 'bold', 'italic', 'underline', 'strikeThrough', 'subscript', 'superscript', 'fontFamily', 'fontSize', '|', 'color', 'emoticons', 'inlineStyle', 'paragraphStyle', '|', 'paragraphFormat', 'align', 'formatOL', 'formatUL', 'outdent', 'indent', '-', 'insertLink', 'insertImage', 'insertVideo', 'insertFile', 'insertTable', '|', 'quote', 'insertHR', 'undo', 'redo', 'clearFormatting', 'selectAll', 'html'],
                pluginsEnabled: null,
                toolbarSticky: false,
                imageUploadURL: '/content-img-upload.php',
                imageUploadParams: {
                    id: 'cheee-admin-editor',
                    _token: '{{ csrf_token() }}'
                }
            });
        });

        app.controller('adminCtrl', function ($scope, $http){

            var tmpList = [];
  
            for (var i = 1; i <= 6; i++){
                tmpList.push({
                  text: 'Item ' + i,
                  value: i
                });
            }
              
            $scope.list = tmpList;

            $scope.detailArr = [];
            $scope.portfolioType = "Banking";
            $scope.new = function () {
                $http({
                    method: 'POST',
                    url: "/partner-add-action",
                    data: {
                        title: $scope.portfolioTitle,
                        title_cn: $scope.portfolioTitle_cn,
                        description: $scope.portfolioDescription,
                        description_cn: $scope.portfolioDescription_cn,
                        category: $scope.portfolioType,
                        date: $scope.portfolioDate,
                        medias: JSON.stringify($scope.tickMediaAttr)
                    }
                }).then(function successCallback(response) {
                    window.location.href = "/admin-partner";
                }, function errorCallback(response) {
                });
            };

            $scope.folder = {!! json_encode($folder) !!}
            $scope.mediaData = {!! $media !!};
            $scope.mediaData.reverse();
            $scope.tickMediaAttr = [];
            var tempArr = [];
            for(var i = 0 ; i < $scope.mediaData.length; i++){
                if($scope.mediaData[i].father == "0"){
                    tempArr.push($scope.mediaData[i]);
                }
            }
            $scope.mediaData = tempArr;

            $scope.$on('mediaFromModal', function(event, data) {
                $scope.tickMediaAttr = data;
            });

            $scope.$on('mediaAll', function(event, data) {
                $scope.mediaData = data;
            });

            $scope.removePhoto = function(media){
                if ($scope.tickMediaAttr.indexOf(media) >= 0) {
                    $scope.tickMediaAttr.splice($scope.tickMediaAttr.indexOf(media), 1);
                    media.tickClass = "";
                    media.featured = 0;
                    media.narrow = 0;
                }
            };

            $scope.chooseFeatured = function(media){
                media.featured = 1;
                for(var i=0; i<$scope.tickMediaAttr.length; i++){
                    if($scope.tickMediaAttr[i].featured && i != $scope.tickMediaAttr.indexOf(media)){
                        $scope.tickMediaAttr[i].featured = 0;
                    }
                }
            };

            $scope.chooseNarrowImage = function(media){
                media.narrow = (media.narrow == 1)?0:1;
            };

            $scope.showMediaModal = function () {
                $scope.$broadcast('pickMethod', 'multi');
                $scope.$broadcast('mediaFromModal', $scope.tickMediaAttr);
                $scope.$broadcast('mediaAll', $scope.mediaData);
                $("#media_library_modal").modal({
                    backdrop: 'static'
                });
            };

        });

        var map;
        function initAutocomplete() {
            map = new google.maps.Map(document.getElementById('map'), {
                center: {lat: -37.8602828, lng: 145.079616},
                zoom: 8
            });
        }

    </script>

<script>
  $.FroalaEditor.DEFAULTS.key = 'wsywvqD1uxuA2B-11n==';
</script>
@stop



