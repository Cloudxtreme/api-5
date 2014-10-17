@extends('layouts.master')

@section('content')


@if (!empty ($message))

	<div>
	    <span><p>{{ $message }}</p></span>
	</div>

@else

	<div class="staticmiddle">
		<div class="staticlogo">
			{{ HTML::image("assets/img/shield+name.png", "Cloudwalkers") }}
		</div>

		<div class="staticmiddle inside">
			<div class="whiteframe">
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
			</div>
		</div>

		<div id="manuals" class="center">
			<span class="ion-ios7-cloud-outline"></span>
			Read our <a href="#">manuals</a></div>
	</div>

@endif

@stop