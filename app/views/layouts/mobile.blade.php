<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta content='True' name='HandheldFriendly' />
    <meta name="format-detection" content="telephone=no" />
    <meta name="viewport" content="user-scalable=no, initial-scale=1, maximum-scale=1, minimum-scale=1, width=device-width, height=device-height, target-densitydpi=device-dpi" />
    <title>{{ $title or "Cloudwalkers" }}</title>
    {{ HTML::style('assets/mobile/app/base.css') }}
    {{ HTML::style('assets/mobile/theme/css/style.css') }}
    {{ HTML::style('assets/mobile/theme/css/bootstrap.min.css') }}
    {{ HTML::style('assets/mobile/theme/css/font-awesome.min.css') }}
    {{ HTML::style('assets/mobile/theme/css/OpenSans.css') }}
</head>
<body>

<div id='app' class="login-view">

    <div id='header'>

        <h1>Cloudwalkers</h1>

    </div>
    <div id='container'>

        @yield('content')

    </div>

</div>

<!-- Plugins -->
{{ HTML::script('assets/mobile/plugins/zepto.min.js') }}
<!-- App -->
<script type="text/javascript">

</script>

</body>
</html>


