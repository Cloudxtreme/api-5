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

	<form method="post" action="{{ $action or "" }}">
		<label>{{ trans('authorize.title') }}</label><br />
		<input type="submit" name="authorized" value="{{ trans('authorize.yes') }}">
		<input type="submit" name="authorized" value="{{ trans('authorize.no') }}">
	</form>
	
</article>

@stop