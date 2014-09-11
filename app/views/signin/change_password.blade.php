@extends('layouts.master')

@section('content')

<!-- BEGIN FORGOT PASSWORD FORM -->
<form class="form-vertical forget-form" action="" method="post">
	<h3 class="">Choose a new password</h3>

	@if ( !empty ($error) )
	@foreach ($error as $message)
	<div class="alert alert-error">
		<button class="close" data-dismiss="alert"></button>
		<span><p>{{ $message }}</p></span>
	</div>
	@endforeach
	@else

	@endif

	@if ( !empty ($feedback) )
	@foreach ($feedback as $message)
	<div class="alert alert-error">
		<button class="close" data-dismiss="alert"></button>
		<span><p>{{ $message }}</p></span>
	</div>
	@endforeach
	@else

	@endif

	<p>Almost there. Please choose a new password.</p>
	<div class="control-group">
		<div class="controls">
			<div class="input-icon left">
				<i class="icon-lock"></i>
				<input class="m-wrap placeholder-no-fix" type="password" placeholder="New password" name="password1" />
			</div>
		</div>
	</div>

	<div class="control-group">
		<div class="controls">
			<div class="input-icon left">
				<i class="icon-lock"></i>
				<input class="m-wrap placeholder-no-fix" type="password" placeholder="Repeat password" name="password2" />
			</div>
		</div>
	</div>

	<div class="form-actions">
		<input type="hidden" name="action" value="changepassword" />
		<button type="submit" class="btn green pull-right">
			Submit <i class="m-icon-swapright m-icon-white"></i>
		</button>
	</div>
</form>
<!-- END FORGOT PASSWORD FORM -->


@stop