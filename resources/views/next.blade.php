@extends('layout')
@section('content')
    <div id="next">
        <h3 class="text-info">{{ trans('next.welcome') }}, {{ Auth::user()->first_name .' '. Auth::user()->last_name }}!</h3>
        <div class="alert alert-info">{{ trans('next.one_more_thing') }}</div>

        <h4 class="icon-color">Apoi poti incepe sa:</h4>

    </div>
@endsection

@section('scripts')
@endsection