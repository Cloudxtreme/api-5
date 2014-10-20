@extends('layouts.master')

@section('content')

	<div class="staticmiddle">
		<div class="staticlogo">
			{{ HTML::image("assets/img/shield+name.png", "Cloudwalkers") }}
		</div>

		<div class="staticmiddle inside">
			<div class="whiteframe">

            @if(!empty ($success))

                <div class="frametitle">
                    <div class="title">
                        {{ trans('recover_password.title') }}
                    </div>
                    <div class="noticehider">
                        <ul class="notice success form">
                            <li>{{ trans('recover_password.success') }}</li>
                        </ul>
                    </div>
                </div>
                <span class="clearfix"></span>
                <a href="{{URL::action('ViewController@login')}}"><button class="btn btn-color pull-right">{{ trans('invitation.go.to.login') }}</button></a>
                <span class="clearfix"></span>

            @else
				<div class="frametitle">
					<div class="title">
						{{ trans('recover_password.title') }}
					</div>
					<span class="small">{{ trans('recover_password.subtitle') }}</span>
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
		                        'placeholder'   => trans('recover_password.email'),
		                        'required'      => 'required'
		                    )) }}
					    </div>

					    @if (!empty ($message))
	                        <div class="noticehider">
	                            <ul class="notice error dialog form">
	                                <li>{{ $message }}</li>
	                            </ul>
	                        </div>
                        @endif

						@if ( !empty ($messages) )
							<div class="noticehider">
		                        <ul class="notice error dialog form">
		                            @foreach ($messages as $message)
		                                    <li>{{ $message }}</li>
		                            @endforeach
		                        </ul>
	                        </div>
	                    @endif

	                    <br>

					    {{ Form::button(trans('change_password.submit'), array('class'=>'btn btn-color pull-right', 'type' => 'submit')) }}

					{{ Form::close() }}

				<span class="clearfix"></span>
				@endif
			</div>
		</div>

		<div id="manuals" class="center">
            <span class="ion-ios7-cloud-outline"></span>
            {{ trans('login.read') }} {{link_to(Config::get('api.manuals_url'), trans('login.manuals') , $attributes = array('target'=>'_blank'), $secure = true)}}
        </div>
	</div>

@stop