@extends('layouts.master')

@section('content')


@if (!empty ($success))

	<div>
	    <span><p>{{ $message }}</p></span>
	</div>

@else

<!-- BEGIN FORGOT PASSWORD FORM -->
<form class="form-vertical forget-form" action="" method="post">
    <h3 class="">{{ trans('recover_password.title') }}</h3>

	@if ( !empty ($messages) )
	    <div class="alert alert-error">
            <button class="close" data-dismiss="alert"></button>
		@foreach ($messages as $message)
	        <span><p>{{ $message }}</p></span>
		@endforeach
		</div>
	@endif

    {{--@if ( isset ($message) )--}}
        {{--<div class="alert alert-error">--}}
            {{--<button class="close" data-dismiss="alert"></button>--}}
            {{--<span><p>{{ $message }}</p></span>--}}
        {{--</div>--}}
    {{--@endif--}}

	<p>{{ trans('recover_password.subtitle') }}</p>
	<div class="control-group">
		<div class="controls">
			<div class="input-icon left">
				<i class="icon-envelope"></i>
				<input class="m-wrap placeholder-no-fix" type="email" placeholder="{{ trans('recover_password.email') }}" name="email" required />
			</div>
		</div>
	</div>
	<div class="form-actions">
		<a href="login-e" id="register-back-btn" type="button" class="btn">
			<i class="m-icon-swapleft"></i>  {{ trans('recover_password.back') }}
		</a>
		<button type="submit" class="btn green pull-right">
			{{ trans('recover_password.submit') }} <i class="m-icon-swapright m-icon-white"></i>
		</button>
	</div>

</form>
<!-- END FORGOT PASSWORD FORM -->

@endif

@stop