<!DOCTYPE html>
	<head>
		<meta charset="utf-8" />
		<title>{{ $title or "Cloudwalkers" }}</title>

		<meta content="width=device-width, initial-scale=1.0" name="viewport" />

        {{ HTML::style('assets/css/bootstrap.min.css') }}
        {{ HTML::style('assets/css/ionicons.min.css') }}
		{{ HTML::style('assets/css/main.css') }}
        {{ HTML::style('assets/fonts/roboto.css') }}
	</head>

	<body class="mobile">
		<div class="staticpage">

	        @yield('content')

		</div>
	</body>
</html>