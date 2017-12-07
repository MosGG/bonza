@extends('layouts.admin')

@section('title')<title>Product Edit - Fine Food Group Admin</title>@stop

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

    <div class="modal fade" id="tag-modal" role="dialog">
        <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Select Tags (max 10)</h4>
                </div>
                <div class="modal-body row" id="admin-add-body">
                    <div ng-repeat="t in tag" class="col-md-4">
                        <label>
                            <input class="tag-select" type="checkbox" name="tags" ng-value="t.id" ng-model="tagsSelected">
                            <span ng-bind='t.tag'></span>
                            <span ng-bind='t.tag_cn'></span>
                        </label>
                    </div>
                </div>
                <div class="modal-footer">
                    <a class="btn btn-secondary btn-default" ng-click="selectTags()" data-dismiss="modal">
                        <i class="fa fa-pencil"></i> Confirm
                    </a>
                    <button type="button" class="btn btn-default btn-warning" data-dismiss="modal">
                        <i class="fa fa-power-off"></i> CLOSE
                    </button>
                </div>
            </div>
        </div>
    </div>
@stop

@section('content')

    <div id="content">
        <div id="content-header">
            <h1>Edit Product</h1>
        </div>
        <!-- #content-header -->

        <div id="content-container">
            <div class="portlet">
                <div class="portlet-header">
                    <h3>
                        <i class="fa fa-tasks"></i>
                        Product Information
                    </h3>
                </div>
                <!-- /.portlet-header -->
                <div class="portlet-content">
                    <!-- /.table-responsive -->

                    <div class="row">
                        <div class="col-sm-4">
                            <div class="from-group">
                                <label>Product Title</label>
                                <input type="text" ng-model="portfolio.title" class="form-control">
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="from-group">
                                <label>Product Subtitle</label>
                                <input type="text" ng-model="portfolio.subtitle" class="form-control">
                            </div>
                        </div>
                        <div class="col-sm-2">
                            <div class="from-group">
                                <label>Product Type</label>
                                <select class="form-control" id="ctg">
                                    <?php 
                                    foreach ($tree as $t) {
                                        echo "<option value='".$t->id."'>";
                                        for ($i=0; $i < $t->level; $i++) { 
                                            echo "&nbsp;&nbsp;";
                                        }
                                        echo $t->name;
                                        echo "</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>

                        <div class="col-sm-2">
                            <div class="from-group">
                                <label>Project Date</label>
                                <div id="project-date" class="input-group date" data-auto-close="true" data-date="@{{portfolio.date}}" data-date-format="dd-mm-yyyy" data-date-autoclose="true">
                                    <input class="form-control" type="text" ng-model="portfolio.date">
                                    <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-sm-2">
                            <div class="from-group">
                                <label>Price</label>
                                <input type="text" ng-model="portfolio.price" class="form-control">
                            </div>
                        </div>
                        <div class="col-sm-2">
                            <div class="from-group">
                                <label>Discount Price</label>
                                <input type="text" ng-model="portfolio.discount_price" class="form-control">
                            </div>
                        </div>
                        
                        <div class="col-sm-2">
                            <div class="from-group">
                                <label>Designer</label>
                                <input type="text" ng-model="portfolio.origin" class="form-control">
                            </div>
                        </div>
                        <div class="col-sm-2">
                            <div class="from-group">
                                <label>Color</label>
                                <input type="text" ng-model="portfolio.sales" class="form-control">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <table class="size-table">
                            <tr><th>Size</th><th>Stock</th><th>Action</th></tr>
                            <tr ng-repeat="size in portfolio.size track by $index">
                                <td>
                                    <input type="text" ng-model="size.id" class="form-control">
                                </td>
                                <td>
                                    <input type="text" ng-model="size.title" class="form-control">
                                </td>
                                <td>
                                    <button type="button" class="btn btn-danger" ng-click="removeProduct($index)">Delete</button>
                                </td>
                            </tr>
                            <tr><td><button type="button" class="btn btn-info" ng-click="addProduct()">Add</button></td></tr>
                        </table>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="from-group">
                                <label>Short Description</label>
                                <input type="text" ng-model="portfolio.content" class="form-control">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="from-group">
                                <label>Portfolio Brief</label>
                                <div id="project-content" class="cheee-admin-editor"></div>
                            </div>
                        </div>
                    </div>
                    <div class="row photo-gallery">
                        <div class="col-sm-12">
                            <div style="padding-bottom: 16px">
                                <button class="btn btn-secondary" ng-click="showMediaModal()">Insert Photo From Media Library</button>
                                <button class="btn btn-secondary" ng-click="openTags()" href="#tag-modal" data-toggle="modal">Select Tags</button>
                            </div>
                            <div ui-sortable="sortableOptions" ng-model="tickMediaAttr">
                                <div class="media-modal-item" ng-repeat="media in tickMediaAttr" >
                                    <div class="media-img">
                                        <button class="media-left-top-btn" ng-class="{'mediaTickBlue': media.narrow == 1}" ng-click="chooseNarrowImage(media)"><i class="fa fa-th"></i></button>
                                        <img ng-src="@{{ media.src_thumb }}" alt="media img">
                                        <button class="media-tick-btn" ng-class="{'mediaTick': media.featured == 1}" ng-click="chooseFeatured(media)">
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
                        <button class="btn btn-info pull-left" ng-click="update()">Update
                        </button>
                         <a type="button" class="btn btn-default btn-warning pull-left" href="/admin-portfolio" style="margin-left: 10px;">Cancel
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
            $('div.cheee-admin-editor').froalaEditor({
                toolbarButtons: ['fullscreen', 'bold', 'italic', 'underline', 'strikeThrough', 'subscript', 'superscript', 'fontFamily', 'fontSize', '|', 'color', 'emoticons', 'inlineStyle', 'paragraphStyle', '|', 'paragraphFormat', 'align', 'formatOL', 'formatUL', 'outdent', 'indent', '-', 'insertLink', 'insertImage', 'insertVideo', 'insertFile', 'insertTable', '|', 'quote', 'insertHR', 'undo', 'redo', 'clearFormatting', 'selectAll', 'html'],
                pluginsEnabled: null,
                toolbarSticky: false,
                imageUploadURL: '/content-img-upload.php',
                imageUploadParams: {
                    id: 'cheee-admin-editor',
                    _token: '{{ csrf_token() }}'
                }
            });
            $('#project-content').froalaEditor('html.set', {!! $portfolio !!}[0]['brief']);
        });

        app.controller('adminCtrl', function($scope, $http) {
            
            $scope.portfolio = {!! $portfolio !!}[0];
            $scope.tag = {!! $tag !!};
            $scope.portfolio['size'] = JSON.parse($scope.portfolio['size']);
            $scope.portfolio['tag'] = JSON.parse($scope.portfolio['tag']);
            $("#ctg").val($scope.portfolio['category']);

            $scope.update = function(){
                $scope.portfolio['medias'] = $scope.tickMediaAttr;
                $scope.portfolio['brief'] = $('#project-content').froalaEditor('html.get', true);
                $scope.portfolio['category'] = $("#ctg").val();
                var data = JSON.stringify($scope.portfolio);
                $http({
                    method: 'POST',
                    url: "/portfolio-edit-action",
                    data:data
                }).then(function successCallback(response) {
                    location.reload();
                },  function errorCallback(response) {
                });
            }

            var initialLoadNum = 20;
            $scope.folder = {!! json_encode($folder) !!};
            $scope.mediaData = {!! $media !!};
            $scope.mediaData.reverse();
            $scope.media = $scope.mediaData.slice(0, initialLoadNum);
            $scope.showLoadMore = ($scope.mediaData.length > $scope.media.length) ? true : false;

            $scope.tickMediaAttr = [];

            var tempArr = [];
            for(var i = 0 ; i < $scope.mediaData.length; i++){
                if($scope.mediaData[i].tickClass == "mediaTick"){
                    $scope.tickMediaAttr.push($scope.mediaData[i]);
                }
                if($scope.mediaData[i].father == "0"){
                    tempArr.push($scope.mediaData[i]);
                }
            }
            $scope.mediaData = tempArr;

            function compare(a,b) {
              if (a.sortID < b.sortID)
                return -1;
              else if (a.sortID > b.sortID)
                return 1;
              else 
                return 0;
            }

            $scope.tickMediaAttr.sort(compare);

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

            $scope.openTags = function(){
                for(i in $scope.portfolio['tag']){
                    $(".tag-select[value="+$scope.portfolio['tag'][i]+"]").prop('checked', true);
                }
            }

            $scope.selectTags = function(){
                var tagsArr = [];
                for (var i = $(".tag-select:checked").length - 1; i >= 0; i--) {
                    tagsArr.push($(".tag-select:checked")[i].value);
                }
                $scope.portfolio['tag'] = tagsArr;
            }

            $scope.addProduct = function(){
                var newline = {"id":"","title":""};
                $scope.portfolio['size'].push(newline);
            }

            $scope.removeProduct = function(index){
                $scope.portfolio['size'].splice(index,1);
            }

        });
    </script>

<script>
  $.FroalaEditor.DEFAULTS.key = 'wsywvqD1uxuA2B-11n==';
</script>
@stop



