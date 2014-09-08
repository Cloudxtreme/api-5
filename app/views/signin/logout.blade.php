@extends('layouts.auth')

@section('content')

<article>

    <h1 class="pull-left">{{ trans('login.logout') }}</h1>

    {{ $output }}

    <div class="clear"></div>

</article>


@stop