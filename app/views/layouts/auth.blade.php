<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="user-scalable=no, initial-scale=1, maximum-scale=1, minimum-scale=1, width=device-width, height=device-height, target-densitydpi=device-dpi" />
    <title>{{ $title or "Cloudwalkers" }}</title>
    {{ HTML::style('assets/mobile/theme/css/platform-login.css') }}
</head>
<body>

<div id="content" style="width: 380px; margin: 0 auto;">
    @yield('content')
</div>

</body>
</html>