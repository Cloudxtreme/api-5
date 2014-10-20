@extends('layouts.master')

@section('content')

	<div class="staticmiddle">
		<div class="staticlogo">
			{{ HTML::image("assets/img/shield+name.png", "Cloudwalkers") }}
		</div>

		<div class="staticmiddle inside">
			<div class="whiteframe">
			@if (!empty ($success))

				<div class="frametitle">
					<div class="title">
						{{ '$user' }}
					</div>
					{{ '$account' }}
				</div>
				<span class="clearfix"></span>
				<button type="submit" class="btn btn-color pull-right">Go to login</button>
				<span class="clearfix"></span>

            @else
				<div class="frametitle">
					<div class="title">
						{{ trans('change_password.title') }}
					</div>
					<span class="small">{{ trans('change_password.claim') }}</span>
				</div>

					{{ Form::open(array(
						'url' => '#',
						'method' => 'post',
		                'accept-charset' => 'UTF-8',
		                'role' => 'form'))
		            }}

					    <div class="form-group">
						    {{ Form::password('newpassword', array(
		                        'class'         => 'form-control',
		                        'placeholder'   => trans('change_password.new_password'),
		                        'required'      => 'required'
		                    )) }}
					    </div>

					    <div class="form-group">
						    {{ Form::password('newpassword_confirm', array(
		                        'class'         => 'form-control',
		                        'placeholder'   => trans('change_password.repeat_password'),
		                        'required'      => 'required'
		                    )) }}
					    </div>

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
			Read our <a href="#">manuals</a></div>
	</div>


@stop