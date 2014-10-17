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
			@if (!empty ($success))

                <div class="frametitle">
                    <div class="title">
                        {{ ($success==1)? trans('invitation.success.1', array('firstname'=> $firstname)) : trans('invitation.success.2', array('firstname'=> $firstname))}}
                    </div>
                    {{ ($success == 1)? trans('invitation.success.12', array('account'=> $account)) : trans('invitation.success.22', array('account'=> $account))}}
                </div>
                <span class="clearfix"></span>
                <button type="submit" class="btn btn-color pull-right">Go to login</button>
                <span class="clearfix"></span>

            @else
				<div class="frametitle">
					<div class="title">
						{{ trans('invitation.title') }}
					</div>
					<span class="small">{{ trans('invitation.account.details') }}</span>
				</div>

					{{ Form::open(array(
						'url' => '#',
						'method' => 'post',
		                'accept-charset' => 'UTF-8',
		                'role' => 'form'))
		            }}

					    <div class="form-group">
						    {{ Form::email('email', $email, array(
		                        'class'         => 'form-control',
		                        'readonly'      => '',
		                        'placeholder'   => trans('invitation.email'),
		                        'required'      => 'required'
		                    )) }}
					    </div>

					    <div class="form-group">
						    {{ Form::text('name', '', array(
		                        'class'         => 'form-control',
		                        'placeholder'   => trans('invitation.name'),
		                        'required'      => 'required'
		                    )) }}
					    </div>

					    <div class="form-group">
						    {{ Form::text('firstname', '', array(
		                        'class'         => 'form-control',
		                        'placeholder'   => trans('invitation.first.name'),
		                        'required'      => 'required'
		                    )) }}
					    </div>

					    <div class="form-group">
						    {{ Form::password('register_password', array(
		                        'class'         => 'form-control',
		                        'placeholder'   => trans('invitation.password'),
		                        'required'      => 'required'
		                    )) }}
					    </div>

					    <div class="form-group">
						    {{ Form::password('password2', array(
		                        'class'         => 'form-control',
		                        'placeholder'   => trans('invitation.retype.password'),
		                        'required'      => 'required'
		                    )) }}
					    </div>

					    <div class="checkbox small">
                            <label>
                                <input type="checkbox"> {{ trans('invitation.terms') }}
                            </label>
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

@endif

@stop