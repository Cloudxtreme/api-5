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

<!--	<h1 class="pull-left">{{ trans('login.login') }}</h1>-->
	<p> </p>
	<form class="form-signin pull-right" method="post" action="">

<!--		<input name="email" id='email' type="email" class="input-block-level" placeholder="@lang('login.email')">-->
<!--		<input name="password" id='password' type="password" class="input-block-level" placeholder="@lang('login.password')">-->
		<input name="logout" type="hidden" value="1" />
		<input type="submit" value="@lang('login.logout')" />

	</form>

	<div class="clear"></div>

</article>

@stop