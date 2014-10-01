@extends('layouts.auth')

@section('content')

<article>

	<h2>{{ trans('register.title') }}</h2>

	@if ( !empty ($error) )
	@foreach ($error as $message)
	<div class="alert alert-error">
		<span><p>{{ $message }}</p></span>
	</div>
	@endforeach 
	
	@else
	
	<p>{{ trans('register.subtitle') }}</p>
	
	@endif

	<form method="post" action="">
	
		<ol>
			<li>
				<label for="name">{{ trans('register.app') }}</label>
				<input type="text" id="name" name="name" />
			</li>
			
			<li>
				<label for="redirect">{{ trans('register.redirect') }}</label>
				<input type="url" id="redirect" name="redirect" />
			</li>
	
			<li>
				<label for="layout">{{ trans('register.design') }}</label>
				<select id="layout" name="layout">
					<option value="default">{{ trans('register.design.default') }}</option>
					<option value="mobile">{{ trans('register.design.mobile') }}</option>
					<option value="platform">{{ trans('register.design.platform') }}</option>
				</select>
			</li>
	
			<li>
				<input type="submit" value='{{ trans('register.submit.button') }}' />
			</li>
		</ol>
	
	</form>
	
</article>

@stop