<!DOCTYPE html>
<head>
    <title>Login - The Map Admin</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <meta name="description" content="">
    <meta name="author" content=""/>

    <link rel="stylesheet"
    href="http://fonts.googleapis.com/css?family=Open+Sans:400italic,600italic,800italic,400,600,800"
    type="text/css">
    <link rel="stylesheet" href="../../assets/admin/css/font-awesome.min.css" type="text/css"/>
    <link rel="stylesheet" href="../../assets/admin/css/bootstrap.min.css" type="text/css"/>
    <link rel="stylesheet" href="../../assets/admin/js/libs/css/ui-lightness/jquery-ui-1.9.2.custom.css" type="text/css"/>

    <link rel="stylesheet" href="../../assets/admin/css/App.css" type="text/css"/>
    <link rel="stylesheet" href="../../assets/admin/css/Login.css" type="text/css"/>

    <link rel="stylesheet" href="../../assets/admin/css/custom.css" type="text/css"/>

</head>

<body>

    <div id="login-container">

        <div id="logo">
            <a href="/admin-login">
                <i class="fa fa-heart logo-heart"></i>
            </a>
        </div>

        <div id="login">

            <h3>Welcome to The Map Admin.</h3>

            <h5>Please sign in to get access.</h5>

            <form id="login-form" action="/login-action" class="form" method="post">

                <input type="hidden" name="_token" value="{{ csrf_token() }}">

                <div class="form-group">
                    <label for="login-username">Username</label>
                    <input type="text" class="form-control" id="login-username" placeholder="Username" name="username">
                </div>

                <div class="form-group">
                    <label for="login-password">Password</label>
                    <input type="password" class="form-control" id="login-password" placeholder="Password" name="pwd">
                </div>

                <div class="form-group">
                    <button type="submit" id="login-btn" class="btn btn-primary btn-block">Sign in &nbsp; <i class="fa fa-sign-in"></i></button>
                </div>
            </form>

            <p>The Map Admin System - powered by <a target="_blank" href="http://cheee.com.au">CHEEE studio</a></p>
        </div>
        <!-- /#login -->

    </div>
    <!-- /#login-container -->

    <script src="../../assets/admin/js/libs/jquery-1.9.1.min.js"></script>
    <script src="../../assets/admin/js/libs/jquery-ui-1.9.2.custom.min.js"></script>
    <script src="../../assets/admin/js/libs/bootstrap.min.js"></script>

    <script src="../../assets/admin/js/App.js"></script>

    <script src="../../assets/admin/js/Login.js"></script>

</body>

</html>

