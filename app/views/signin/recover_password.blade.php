@extends('layouts.master')

@section('content')

<!-- BEGIN FORGOT PASSWORD FORM -->
<form class="form-vertical forget-form" action="" method="post">
    <h3 class="">Choose a new password</h3>

    @if ( !empty ($error) )
        <div class="alert alert-error">
            <button class="close" data-dismiss="alert"></button>
            <span><p>{{ $error }}</p></span>
        </div>
    @else

    @endif

    @if ( !empty ($msg) )
        <div class="alert alert-error">
            <button class="close" data-dismiss="alert"></button>
            <span><p>{{ $msg }}</p></span>
        </div>
    @else

    @endif

	<p>Enter your e-mail address below to reset your password.</p>
	<div class="control-group">
		<div class="controls">
			<div class="input-icon left">
				<i class="icon-envelope"></i>
				<input class="m-wrap placeholder-no-fix" type="text" placeholder="Email" name="email" />
			</div>
		</div>
	</div>
	<div class="form-actions">
		<a href="login-e" id="register-back-btn" type="button" class="btn">
			<i class="m-icon-swapleft"></i>  Back
		</a>
		<button type="submit" class="btn green pull-right">
			Submit <i class="m-icon-swapright m-icon-white"></i>
		</button>
	</div>

</form>
<!-- END FORGOT PASSWORD FORM -->


@stop