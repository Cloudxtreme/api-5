@extends('layouts.mobile_index')

@section('content')

<article class="glass">

	<div class="title pull-left">Login</div>

	@if ( !empty ($error) )
    	@foreach ($error as $message)
    	<article style="clear: both;">
        	<div class="errors">
    		<p>{{ $message }}</p>
    	    </div>
        </article>
    	@endforeach
    @else

    @endif

	<form class="form-signin pull-right" method="post" action="{{$action or ""}}">

		<input name="email" id='email' type="email" class="input-block-level" placeholder="E-mail">
		<input name="password" id='password' type="password" class="input-block-level" placeholder="Password">
		<input name="login" type="hidden" value="1" />
		<input class="btn btn-block btn-primary" type="submit" value="Login" />

	</form>


	<div class="clear"></div>

</article>

<article>
{{ HTML::linkAction('ViewController@recoverpassword', 'Forgot password?', array(), array('class' => 'forgot-link')) }}
	{{--<a href="#" class="forgot-link" onclick="var ref = window.open('http://api.cloudwalkers.be/login/lostpassword', '_system');">Forgot password?</a>--}}
</article>

@stop