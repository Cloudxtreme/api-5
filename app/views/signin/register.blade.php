@extends('layouts.master')

@section('content')

<!-- BEGIN REGISTRATION FORM -->
<form class="form-vertical register-form" action="" method="post">

    @if ( !empty ($invitation) )
        <h3>
            You are invited!
        </h3>

        <p>If you already have a Cloudwalkers account, don't bother with this registration form and head straight to the <a href="{{ URL::to('login') }}">login form</a>.</p>
    @else

    @endif

    @if ( !empty ($error) )
        @foreach ($error as $message)
            <div class="alert alert-error">
                <!-- <button class="close" data-dismiss="alert"></button> -->
                <span><p>{{ $error['message'] }}</p></span>
            </div>
        @endforeach
    @else

    @endif

    <p>Enter your account details below:</p>
    <div class="control-group">
        <!--ie8, ie9 does not support html5 placeholder, so we just show field title for that-->
        <label class="control-label visible-ie8 visible-ie9">Email</label>
        <div class="controls">
            <div class="input-icon left">
                <i class="icon-envelope"></i>
                <input class="m-wrap placeholder-no-fix" type="text" placeholder="Email" name="email" value="{{ Session::get('invitation_email') }}"/>
            </div>
        </div>
    </div>

    <div class="control-group">
        <label class="control-label visible-ie8 visible-ie9">Name</label>
        <div class="controls">
            <div class="input-icon left">
                <i class="icon-user"></i>
                <input class="m-wrap placeholder-no-fix" type="text" placeholder="Name" name="name"/>
            </div>
        </div>
    </div>

    <div class="control-group">
        <label class="control-label visible-ie8 visible-ie9">First name</label>
        <div class="controls">
            <div class="input-icon left">
                <i class="icon-user"></i>
                <input class="m-wrap placeholder-no-fix" type="text" placeholder="First name" name="firstname"/>
            </div>
        </div>
    </div>

    <div class="control-group">
        <label class="control-label visible-ie8 visible-ie9">Password</label>
        <div class="controls">
            <div class="input-icon left">
                <i class="icon-lock"></i>
                <input class="m-wrap placeholder-no-fix" type="password" id="register_password" placeholder="Password" name="password"/>
            </div>
        </div>
    </div>
    <div class="control-group">
        <label class="control-label visible-ie8 visible-ie9">Re-type Your Password</label>
        <div class="controls">
            <div class="input-icon left">
                <i class="icon-ok"></i>
                <input class="m-wrap placeholder-no-fix" type="password" placeholder="Re-type Your Password" name="password2"/>
            </div>
        </div>
    </div>
    <div class="control-group">
        <div class="controls">
            <label class="checkbox">
                <input type="checkbox" name="tnc"/> I agree to the <a href="#">Terms of Service</a> and <a href="#">Privacy Policy</a>
            </label>
            <div id="register_tnc_error"></div>
        </div>
    </div>
    <div class="form-actions">
        <a href="{{ URL::to('login') }}" id="register-back-btn" type="button" class="btn">
            <i class="m-icon-swapleft"></i>
            @if ( !empty ($invitation) )
                To login
            @else
                Back
            @endif
        </a>
        <button type="submit" id="register-submit-btn" class="btn green pull-right" name="register" value="1">
            Sign Up <i class="m-icon-swapright m-icon-white"></i>
        </button>
    </div>
</form>
<!-- END REGISTRATION FORM -->

@stop