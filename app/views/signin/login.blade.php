@extends('layouts.auth')

@section('content')

	<div class="staticmiddle">
		<div class="staticlogo">
			{{ HTML::image("assets/img/shield+name.png", "Cloudwalkers logo") }}
		</div>

		<h1>{{ trans('login.title') }}</h1>

		<div class="whiteframe">
			<div class="frametitle">{{ trans('login.login') }}</div>
			<form role="form">
			    <div class="form-group">
				    <!--<label for="exampleInputEmail1">Email</label>-->
				    <input type="email" class="form-control" id="exampleInputEmail1" placeholder="{{ trans('login.email') }}" required>
			    </div>
			    <div class="form-group">
				   <!-- <label for="exampleInputEmail1">Password</label>-->
				    <input type="password" class="form-control" id="exampleInputEmail1" placeholder="{{ trans('login.password') }}" required>
			    </div>
			    <br>
			    <button type="submit" class="btn btn-color pull-right">{{ trans('login.login') }}</button>
			    {{ HTML::linkAction('ViewController@forgotpassword', trans('login.forgot.password'), array(), array('class' => 'muted pull-left', 'id' => 'forgotpw')) }}
			</form>
			<span class="clearfix"></span>
		</div>

		<div id="manuals" class="center">
			<span class="ion-ios7-cloud-outline"></span>
			{{ trans('login.read') }} {{link_to(Config::get('api.manuals_url'), trans('login.manuals') , $attributes = array(), $secure = true)}}
		</div>
	</div>

@stop

{{--<article>--}}

	{{--@if ( !empty ($error) )--}}
	{{--@foreach ($error as $message)--}}
	{{--<div class="alert alert-error">--}}
		{{--<button class="close" data-dismiss="alert"></button>--}}
		{{--<span><p>{{ $message }}</p></span>--}}
	{{--</div>--}}
	{{--@endforeach--}}
	{{--@else--}}

	{{--@endif--}}

	{{--@if ( !empty ($msg) )--}}
	{{--<div class="alert alert-error">--}}
		{{--<button class="close" data-dismiss="alert"></button>--}}
		{{--<span><p>{{ $msg }}</p></span>--}}
	{{--</div>--}}
	{{--<script>--}}
        {{--//window.localStorage.setItem('access_token', '{{ $msg }}');--}}
    {{--</script>--}}
	{{--@else--}}

	{{--@endif--}}

    {{--<h1 class="pull-left">{{ trans('login.login') }}</h1>--}}

    {{--<form class="form-signin pull-right" method="post" action="">--}}

        {{--<input name="email" id='email' type="email" class="input-block-level" placeholder="{{ trans('login.email') }}">--}}
        {{--<input name="password" id='password' type="password" class="input-block-level" placeholder="{{ trans('login.password') }}">--}}
        {{--<input name="login" type="hidden" value="1" />--}}
        {{--<input type="submit" value="{{ trans('login.login') }}" />--}}

    {{--</form>--}}

    {{--<div class="clear"></div>--}}

{{--</article>--}}

{{--<article>--}}
    {{--{{ HTML::linkAction('ViewController@forgotpassword', trans('login.forgot.password'), array(), array('class' => 'forgot-link')) }}--}}
{{--</article>--}}

{{--@stop--}}