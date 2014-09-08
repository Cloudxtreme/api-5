<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9"> <![endif]-->
<!--[if !IE]><!--> <html lang="en"> <!--<![endif]-->
<!-- BEGIN HEAD -->
<head>
    <meta charset="utf-8" />
    <title>Cloudwalkers | Login Page</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <meta content="" name="description" />
    <meta content="" name="author" />

    <!-- BEGIN GLOBAL MANDATORY STYLES -->
    {{ HTML::style('assets/plugins/bootstrap/css/bootstrap.min.css') }}
    {{ HTML::style('assets/plugins/bootstrap/css/bootstrap-responsive.min.css') }}
    {{ HTML::style('assets/plugins/font-awesome/css/font-awesome.min.css') }}
    {{ HTML::style('assets/css/style-metro.css') }}
    {{ HTML::style('assets/css/style.css') }}
    {{ HTML::style('assets/css/style-responsive.css') }}
    {{ HTML::style('assets/css/themes/default.css') }}
    {{ HTML::style('assets/plugins/uniform/css/uniform.default.css') }}
    <!-- END GLOBAL MANDATORY STYLES -->

    <!-- BEGIN PAGE LEVEL STYLES -->
    {{ HTML::style('assets/css/pages/login.css') }}
    <!-- END PAGE LEVEL STYLES -->
    <link rel="shortcut icon" href="{{ asset('favicon.ico') }}" />

</head>
<!-- END HEAD -->

<!-- BEGIN BODY -->
<body class="login">
<!-- BEGIN LOGO -->
<div class="logo">
    {{ HTML::image('assets/img/logo-big.png') }}
</div>

<!-- END LOGO -->
<!-- BEGIN LOGIN -->
<div class="content">

    <div id="content">
        @yield('content')
    </div>

</div>
<!-- END LOGIN -->

<!-- BEGIN COPYRIGHT -->
<div class="copyright">
    2014 &copy; Cloudwalkers
</div>



</body>

</html>