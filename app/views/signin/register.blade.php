@extends('layouts.master')

@section('content')

@if (!empty ($success))

	<div>
	    <span><p>{{ $message }}</p></span>
	</div>

@else

<!-- BEGIN REGISTRATION FORM -->
<form class="form-vertical register-form" action="" method="post">

    <h3>
        {{ trans('invitation.title') }}
    </h3>

	@if ( !empty ($messages) )
	    <div class="alert alert-error">
            <button class="close" data-dismiss="alert"></button>
		@foreach ($messages as $message)
	        <span><p>{{ $message }}</p></span>
		@endforeach
		</div>
	@endif

    <p>{{ trans('invitation.account.details') }}</p>
    <div class="control-group">
        <!--ie8, ie9 does not support html5 placeholder, so we just show field title for that-->
        <label class="control-label visible-ie8 visible-ie9">{{ trans('invitation.email') }}</label>
        <div class="controls">
            <div class="input-icon left">
                <i class="icon-envelope"></i>
                <input class="m-wrap placeholder-no-fix" type="text" placeholder="{{ trans('invitation.email') }}" name="email" value="{{ $email or "" }}" readonly />
            </div>
        </div>
    </div>

    <div class="control-group">
        <label class="control-label visible-ie8 visible-ie9">{{ trans('invitation.name') }}</label>
        <div class="controls">
            <div class="input-icon left">
                <i class="icon-user"></i>
                <input class="m-wrap placeholder-no-fix" type="text" placeholder="{{ trans('invitation.name') }}" name="name" value="{{ $name or "" }}" required/>
            </div>
        </div>
    </div>

    <div class="control-group">
        <label class="control-label visible-ie8 visible-ie9">{{ trans('invitation.first.name') }}</label>
        <div class="controls">
            <div class="input-icon left">
                <i class="icon-user"></i>
                <input class="m-wrap placeholder-no-fix" type="text" placeholder="{{ trans('invitation.first.name') }}" name="firstname" value="{{ $firstname or "" }}" required/>
            </div>
        </div>
    </div>

    <div class="control-group">
        <label class="control-label visible-ie8 visible-ie9">{{ trans('invitation.password') }}</label>
        <div class="controls">
            <div class="input-icon left">
                <i class="icon-lock"></i>
                <input class="m-wrap placeholder-no-fix" type="password" id="register_password" placeholder="{{ trans('invitation.password') }}" name="password" required/>
            </div>
        </div>
    </div>
    <div class="control-group">
        <label class="control-label visible-ie8 visible-ie9">{{ trans('invitation.retype.password') }}</label>
        <div class="controls">
            <div class="input-icon left">
                <i class="icon-ok"></i>
                <input class="m-wrap placeholder-no-fix" type="password" placeholder="{{ trans('invitation.retype.password') }}" name="password2" required/>
            </div>
        </div>
    </div>
    <div class="control-group">
        <div class="controls">
            <label class="checkbox">
                <input type="checkbox" name="tnc"/> {{ trans('invitation.terms') }}
            </label>
            <div id="register_tnc_error"></div>
        </div>
    </div>
    <div class="form-actions">
        <a href="{{ URL::to('login-e') }}" id="register-back-btn" type="button" class="btn">
            <i class="m-icon-swapleft"></i>
            {{ trans('invitation.to.login') }}
        </a>
        <button type="submit" id="register-submit-btn" class="btn green pull-right" name="register" value="1">
            {{ trans('invitation.signup') }} <i class="m-icon-swapright m-icon-white"></i>
        </button>
    </div>
</form>
<!-- END REGISTRATION FORM -->

@endif

@stop