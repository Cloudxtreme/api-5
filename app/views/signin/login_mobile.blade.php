@extends('layouts.master_mobile')

@section('content')

	<div class="staticmiddle">
		<div class="staticlogo">
			{{ HTML::image("assets/img/shield+name.png", "Cloudwalkers") }}
		</div>

		<h1>{{ trans('login.title') }}</h1>

		<div class="staticmiddle inside">
			<div class="whiteframe">
				<div class="frametitle">
                    <div class="title">{{ trans('login.login') }}</div>

				@if(!empty ($success))
	                <div class="noticehider">
	                    <ul class="notice success form">
	                        <li>{{ $message }}</li>
	                    </ul>
	                </div>
	            @endif

	            </div>

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

					@if ( !empty ($error) )
						<div class="noticehider">
				            <ul class="notice error dialog form">
					            @foreach ($error as $message)
						                <li>{{ $message }}</li>
					            @endforeach
					        </ul>
				        </div>
		            @endif

		            <br>

				    {{ Form::button(trans('login.login'), array('class'=>'btn btn-color btn-lg', 'type' => 'submit')) }}

                    <div id="forgotpw" class="muted center" onclick="var ref = window.open('{{URL::action('ViewController@forgotpassword')}}', '_system');">{{trans('login.forgot.password')}}</div>

				{{ Form::close() }}

				<span class="clearfix"></span>
			</div>
		</div>

		<div id="manuals" class="center">
            <span class="ion-ios7-cloud-outline"></span>
            {{ trans('login.read') }} {{link_to(Config::get('api.manuals_url'), trans('login.manuals') , $attributes = array('target'=>'_blank'), $secure = true)}}
        </div>
	</div>

@stop