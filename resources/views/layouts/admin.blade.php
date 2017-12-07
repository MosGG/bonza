<!DOCTYPE html>
<html class="no-js">
<head>

    @yield('title')

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <meta name="description" content="">
    <meta name="author" content=""/>

    <link rel="stylesheet"
          href="http://fonts.googleapis.com/css?family=Open+Sans:400italic,600italic,800italic,400,600,800"
          type="text/css">
    <link rel="stylesheet" href="../../assets/admin/css/font-awesome.min.css" type="text/css"/>
    <link rel="stylesheet" href="../../assets/admin/css/bootstrap.min.css" type="text/css"/>
    <link rel="stylesheet" href="../../assets/admin/js/libs/css/ui-lightness/jquery-ui-1.9.2.custom.css"
          type="text/css"/>

    <link rel="stylesheet" href="../../assets/admin/css/App.css" type="text/css"/>

    <link rel="stylesheet" href="../../assets/admin/css/custom.css" type="text/css"/>
    <link href="https://fonts.googleapis.com/css?family=Lato:100" rel="stylesheet" type="text/css">

    <link rel="stylesheet" href="../../assets/admin/js/plugins/icheck/skins/minimal/blue.css" type="text/css"/>

    @yield('css-reference')
    <script src="../../assets/admin/js/libs/jquery-1.9.1.min.js"></script>
    <script src="http://ajax.googleapis.com/ajax/libs/angularjs/1.4.8/angular.min.js"></script>

</head>

<body ng-app="myApp">

<div id="wrapper" ng-controller="adminCtrl">

    @yield('modal')

    <header id="header">
        <h1 id="site-logo">
            <a href="">
                <img src="/assets/img/footerlogo.png" alt="Site Logo"/>
            </a>
        </h1>

        <a href="javascript:;" data-toggle="collapse" data-target=".top-bar-collapse" id="top-bar-toggle"
           class="navbar-toggle collapsed">
            <i class="fa fa-cog"></i>
        </a>

        <a href="javascript:;" data-toggle="collapse" data-target=".sidebar-collapse" id="sidebar-toggle"
           class="navbar-toggle collapsed">
            <i class="fa fa-reorder"></i>
        </a>

    </header>
    <!-- header -->


    <nav id="top-bar" class="collapse top-bar-collapse">

        <ul class="nav navbar-nav pull-right">
            <li class="dropdown">
                <a class="dropdown-toggle" data-toggle="dropdown" href="javascript:;">
                    <i class="fa fa-user"></i>
                    {{$adminName}}
                    <span class="caret"></span>
                </a>

                <ul class="dropdown-menu" role="menu">
                    <li>
                        <a href="/logout-action">
                            <i class="fa fa-sign-out"></i>
                            &nbsp;&nbsp;Logout
                        </a>
                    </li>
                </ul>
            </li>
        </ul>
    </nav>
    <!-- /#top-bar -->

    <div id="sidebar-wrapper" class="collapse sidebar-collapse">

        <div id="search">
            <form>
                <input class="form-control input-sm" type="text" name="search" placeholder="Search..."/>

                <button type="submit" id="search-btn" class="btn"><i class="fa fa-search"></i></button>
            </form>
        </div>
        <!-- #search -->

        <nav id="sidebar">
            <ul id="main-nav" class="open-active">
                <li class="">
                    <a href="/admin-home">
                        <i class="fa fa-home"></i>
                        Home / Admins
                    </a>
                </li>

                <li class="">
                    <a href="/media-library">
                        <i class="fa fa-picture-o"></i>
                        Media Library
                    </a>
                </li>

               <!--  <li class="">
                    <a href="/admin-document">
                        <i class="fa fa-file-pdf-o"></i>
                        Document
                    </a>
                </li> -->

                <li class="">
                    <a href="/admin-category">
                        <i class="fa fa-sitemap"></i>
                        Category
                    </a>
                </li>

                 <li class="">
                    <a href="/admin-tag">
                        <i class="fa fa-tags"></i>
                        Tags
                    </a>
                </li>

                <li class="">
                    <a href="/admin-portfolio">
                        <i class="fa fa-heart"></i>
                        Product
                    </a>
                </li>

                <!-- <li class="">   
                    <a href="/admin-partner">
                        <i class="fa fa-group"></i>
                        Partner
                    </a>
                </li> -->
                <!-- <li class="dropdown">
                    <a href="javascript:;">
                        <i class="fa fa-tasks"></i>
                        Products
                        <span class="caret"></span>
                    </a>

                    <ul class="sub-nav">
                        <li>
                            <a href="/admin-product">
                                <i class="fa fa-beer"></i>
                                Products Management
                            </a>
                        </li>
                        <li>
                            <a href="/category">
                                <i class="fa fa-sort-amount-asc"></i>
                                Category Management
                            </a>
                        </li>

                        <li class="">
                            <a href="/stock">
                                <i class="fa fa-barcode"></i>
                                Stock Management
                            </a>
                        </li>

                        <li class="">
                            <a href="/report">
                                <i class="fa fa-bar-chart"></i>
                                Analytics & Reporting
                            </a>
                        </li>
                    </ul>
                </li> -->

                <li class="">
                    <a href="/admin-order">
                        <i class="fa fa-shopping-cart"></i>
                        Orders Management
                    </a>
                </li>

                <li class="dropdown">
                    <a href="javascript:;">
                        <i class="fa fa-shopping-cart"></i>
                        Orders Management
                        <span class="caret"></span>
                    </a>

                    <ul class="sub-nav">
                        <li class="">
                            <a href="/admin-order/en">
                                <i class="fa fa-dollar"></i>
                                AUD
                            </a>
                        </li>
                        <li class="">
                            <a href="/admin-order/ch">
                                <i class="fa fa-cny"></i>
                                CNY
                            </a>
                        </li>
                    </ul>
                </li>

                <li class="dropdown">
                    <a href="javascript:;">
                        <i class="fa fa-money"></i>
                        Financial Report
                        <span class="caret"></span>
                    </a>

                    <ul class="sub-nav">
                        <li class="">
                            <a href="/admin-finance/en">
                                <i class="fa fa-dollar"></i>
                                AUD
                            </a>
                        </li>
                        <li class="">
                            <a href="/admin-finance/ch">
                                <i class="fa fa-cny"></i>
                                CNY
                            </a>
                        </li>
                    </ul>
                </li>
                
                <li class="">
                    <a href="/admin-refund">
                        <i class="fa fa-reply-all"></i>
                        Refund Management
                    </a>
                </li>

                <li class="">
                    <a href="/admin-member">
                        <i class="fa fa-group"></i>
                        Member Management
                    </a>
                </li>
                <!-- <li class="">
                    <a href="/email">
                        <i class="fa fa-paper-plane-o"></i>
                        Email Service
                    </a>
                </li> -->
            </ul></nav>
        <!-- #sidebar -->
    </div>
    <!-- /#sidebar-wrapper -->

    @yield('content')
</div>
<!-- #wrapper -->

<script src="../../assets/admin/js/libs/jquery-ui-1.9.2.custom.min.js"></script>
<script src="../../assets/admin/js/libs/bootstrap.min.js"></script>

<script src="../../assets/admin/js/libs/raphael-2.1.2.min.js"></script>
<script src="../../assets/admin/js/plugins/morris/morris.min.js"></script>

<script src="../../assets/admin/js/demos/charts/morris/bar.js"></script>
<script src="../../assets/admin/js/demos/charts/morris/line.js"></script>
<script src="../../assets/admin/js/demos/charts/morris/donut.js"></script>
<script src="../../assets/admin/js/demos/charts/morris/area.js"></script>

<script src="../../assets/admin/js/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="../../assets/admin/js/plugins/datatables/DT_bootstrap.js"></script>
<script src="../../assets/admin/js/plugins/tableCheckable/jquery.tableCheckable.js"></script>

<script src="../../assets/admin/js/plugins/icheck/jquery.icheck.min.js"></script>

<script src="../../assets/admin/js/App.js"></script>

@yield('js-reference')
</body>

@yield('js-function')
</html>