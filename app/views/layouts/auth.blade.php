<!DOCTYPE html>
	<head>
		<meta charset="utf-8" />
		<title>{{ $title or "Cloudwalkers" }}</title>

		<meta content="width=device-width, initial-scale=1.0" name="viewport" />

        {{ HTML::style('http://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css') }}
		{{--<link href="http://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css" rel="stylesheet">--}}
		<link href="http://code.ionicframework.com/ionicons/1.5.2/css/ionicons.min.css" rel="stylesheet">
		<link href='http://fonts.googleapis.com/css?family=Open+Sans:400,600,700' rel='stylesheet' type='text/css'>
		<link href='http://fonts.googleapis.com/css?family=Roboto:400,700,300' rel='stylesheet' type='text/css'>
		{{--<link href="main.css" rel="stylesheet">--}}
		{{ HTML::style('assets/css/main.css') }}
	</head>

	<body>
		<div class="staticpage">

	        @yield('content')

		</div>
	</body>
</html>