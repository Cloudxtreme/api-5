@extends('layouts.auth')

@section('content')

<article>

	<h2>OAuth2 application registration</h2>
	
	@if ( !empty ($error) )
	@foreach ($error as $message)
	<div class="alert alert-error">
		<span><p>{{ $message }}</p></span>
	</div>
	@endforeach 
	
	@else
	
	<p>Please provide a valid redirect URI. This application ID must be equal to the redirect URI that you use in your authorization call.</p>
	
	@endif

	<form method="post">
	
		<ol>
			<li>
				<label for="name">App name:</label>
				<input type="text" id="name" name="name" />
			</li>
			
			<li>
				<label for="redirect">Redirect URI:</label>
				<input type="url" id="redirect" name="redirect" />
			</li>
	
			<li>
				<label for="layout">Login design:</label>
				<select id="layout" name="layout">
					<option value="default">default</option>
					<option value="mobile">mobile</option>
					<option value="platform">platform</option>
				</select>
			</li>
	
			<li>
				<input type="submit" value='Register OAuth2 app' />
			</li>
		</ol>
	
	</form>
	
</article>

@stop