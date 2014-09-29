@extends('layouts.auth')

@section('content')

<article>

	@if ( !empty ($error) )
	@foreach ($error as $message)
	<div class="alert alert-error">
		<button class="close" data-dismiss="alert"></button>
		<span><p>{{ $message }}</p></span>
	</div>
	@endforeach
	@else

	@endif

	@if ( !empty ($msg) )
	<div class="alert alert-error">
		<button class="close" data-dismiss="alert"></button>
		<span><p>{{ $msg }}</p></span>
	</div>
	<script>
        window.localStorage.setItem('access_token', '{{ $msg }}');
    </script>
	@else

	@endif

    <h1 class="pull-left">{{ trans('login.login') }}</h1>

    <form class="form-signin pull-right" method="post" action="">

        <input name="email" id='email' type="email" class="input-block-level" placeholder="@lang('login.email'))">
        <input name="password" id='password' type="password" class="input-block-level" placeholder="@lang('login.password')">
        <input name="login" type="hidden" value="1" />
        <input type="submit" value="@lang('login.login')" />

    </form>

    <div class="clear"></div>

</article>

<article>
    {{ HTML::linkAction('LoginController@recoverPassword', 'Lost Password', array(), array('class' => 'forgot-link')) }}
</article>

@stop