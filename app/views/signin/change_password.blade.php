@extends('layouts.master')

@section('content')


@if (!empty ($success))

	<div>
	    <span><p>{{ $message }}</p></span>
	</div>

@else

<!-- BEGIN FORGOT PASSWORD FORM -->
<form class="form-vertical forget-form" action="" method="post">
	<h3 class="">{{ trans('change_password.title') }}</h3>


	@if ( !empty ($message) )
	<div class="alert alert-error">
		<button class="close" data-dismiss="alert"></button>
		<span><p>{{ $message }}</p></span>
	</div>
	@else

	@endif


	<p>{{ trans('change_password.claim') }}</p>

	@if (!isset($auth))
	<div class="control-group">
		<div class="controls">
			<div class="input-icon left">
				<i class="icon-lock"></i>
				<input class="m-wrap placeholder-no-fix" type="password" placeholder="{{ trans('change_password.old_password') }}" name="oldpassword" />
			</div>
		</div>
	</div>
	@endif

	<div class="control-group">
		<div class="controls">
			<div class="input-icon left">
				<i class="icon-lock"></i>
				<input class="m-wrap placeholder-no-fix" type="password" placeholder="{{ trans('change_password.new_password') }}" name="newpassword" />
			</div>
		</div>
	</div>

	<div class="control-group">
		<div class="controls">
			<div class="input-icon left">
				<i class="icon-lock"></i>
				<input class="m-wrap placeholder-no-fix" type="password" placeholder="{{ trans('change_password.repeat_password') }}" name="newpassword_confirm" />
			</div>
		</div>
	</div>

	<div class="form-actions">
		<input type="hidden" name="action" value="changepassword" />
		<button type="submit" class="btn green pull-right">
			{{ trans('change_password.submit') }} <i class="m-icon-swapright m-icon-white"></i>
		</button>
	</div>
</form>
<!-- END FORGOT PASSWORD FORM -->


@endif

@stop