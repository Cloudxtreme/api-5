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
		
	@endif

	<h2>{{ trans('register.done.title') }}</h2>

	<p>{{ trans('register.done.subtitle') }}</p>
	
	<ul>
		<li>
			<strong>{{ $name or "" }}</strong>
		</li>
	
		<li>
			<strong>{{ trans('register.done.client.id') }}</strong><br />
	        {{ $clientid or "" }}
		</li>
	
		<li>
			<strong>{{ trans('register.done.secret') }}</strong><br />
	        {{ $secret or "" }}
		</li>
	
		<li>
			<strong>{{ trans('register.done.redirect.uri') }}</strong><br />
	        {{ $redirecturi or "" }}
		</li>
	
	</ul>
	
</article>

@stop







