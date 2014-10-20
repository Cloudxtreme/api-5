@extends('layouts.auth')

@section('content')

	<div class="staticmiddle">
		<div class="staticlogo">
			{{ HTML::image("assets/img/shield+name.png", "Cloudwalkers") }}
		</div>

		<h1>{{ trans('login.title') }}</h1>

		<div class="whiteframe">
			{{--<div class="frametitle">{{ trans('login.logout') }}</div>--}}

			{{ Form::open(array(
				'url' => '#',
				'method' => 'post',
                'accept-charset' => 'UTF-8',
                'role' => 'form'))
            }}

				{{ Form::button(trans('login.logout'), array('class'=>'btn btn-color', 'type' => 'submit')) }}

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

            @if ( !empty ($message) )
	            <div>
	                <p>{{ $message }}</p>
	            </div>
            @endif

		<div id="manuals" class="center">
            <span class="ion-ios7-cloud-outline"></span>
            {{ trans('login.read') }} {{link_to(Config::get('api.manuals_url'), trans('login.manuals') , $attributes = array('target'=>'_blank'), $secure = true)}}
        </div>
	</div>

@stop