@extends('layouts.auth')

@section('content')

	<div class="staticmiddle">
		<div class="staticlogo">
			{{ HTML::image("assets/img/shield+name.png", "Cloudwalkers") }}
		</div>

		<h1>{{ trans('login.title') }}</h1>

		<div class="whiteframe">
			<div class="frametitle">{{ trans('login.login') }}</div>

			{{ Form::open(array(
				'url' => '#',
				'method' => 'post',
                'accept-charset' => 'UTF-8',
                'role' => 'form'))
            }}
			    <div class="form-group">
				    {{ Form::email('email', '', array(
                        'class'         => 'form-control',
                        'placeholder'   => trans('login.email'),
                        'required'      => 'required'
                    )) }}
			    </div>
			    <div class="form-group">
				    {{ Form::password('password', array(
                        'class'         => 'form-control',
                        'placeholder'   => trans('login.password'),
                        'required'      => 'required'
                    )) }}
			    </div>
			    <br>
			    {{ Form::button(trans('login.login'), array('class'=>'btn btn-color pull-right', 'type' => 'submit')) }}

			    {{ HTML::linkAction('ViewController@forgotpassword', trans('login.forgot.password'), array(), array('class' => 'muted pull-left', 'id' => 'forgotpw')) }}

			{{ Form::close() }}

			<span class="clearfix"></span>
		</div>

            @if ( !empty ($error) )
	            @foreach ($error as $message)
		            <div>
		                <p>{{ $message }}</p>
		            </div>
	            @endforeach
            @endif

		<div id="manuals" class="center">
			<span class="ion-ios7-cloud-outline"></span>
			{{ trans('login.read') }} {{link_to(Config::get('api.manuals_url'), trans('login.manuals') , $attributes = array(), $secure = true)}}
		</div>
	</div>

@stop