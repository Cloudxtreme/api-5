@extends('layouts.master')

@section('content')


@if (!empty ($message))

	<div>
	    <span><p>{{ $message }}</p></span>
	</div>

@else

<!-- BEGIN FORGOT PASSWORD FORM -->
<form class="form-vertical forget-form" action="" method="post">
	<h3 class="">{{ trans('change_password.title') }}</h3>


	@if ( !empty ($messages) )
	    <div class="alert alert-error">
            <button class="close" data-dismiss="alert"></button>
		@foreach ($messages as $message)
	        <span><p>{{ $message }}</p></span>
		@endforeach
		</div>
	@endif


	<p>{{ trans('change_password.claim') }}</p>


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