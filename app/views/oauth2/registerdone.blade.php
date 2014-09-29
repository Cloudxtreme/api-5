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

	<h2>OAuth2 app registered</h2>

	<p>Please use following Client ID in your OAuth2 application.</p>
	
	<ul>
		<li>
			<strong>{{ $name }}</strong>
		</li>
	
		<li>
			<strong>OAuth2 Client ID:</strong><br />
	        {{ $clientid }}
		</li>
	
		<li>
			<strong>OAuth2 Secret:</strong><br />
	        {{ $secret }}
		</li>
	
		<li>
			<strong>Redirect URI:</strong><br />
	        {{ $redirecturi }}
		</li>
	
	</ul>
	
</article>

@stop







