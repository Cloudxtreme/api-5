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

	<form method="post" action="{{ $action }}">
		<label>Do You Authorize [this app - <em>please create a appname field in oauth2/register and db</em>]?</label><br />
		<input type="submit" name="authorized" value="yes">
		<input type="submit" name="authorized" value="no">
	</form>
	
</article>

@stop