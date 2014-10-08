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

	<p> </p>
	<form class="form-signin pull-right" method="post" action="">

		<input name="logout" type="hidden" value="1" />
		<input type="submit" value="{{ trans('login.logout') }}" />

	</form>

	<div class="clear"></div>

</article>

@stop