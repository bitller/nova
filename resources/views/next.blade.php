@extends('layout.index')
@section('content')
    <!-- BEGIN Next page -->
    <div id="next">

        <!-- BEGIN Welcome alert -->
        <div class="alert alert-success welcome-alert">
            <span class="glyphicon glyphicon-ok"></span>&nbsp;
            {{ trans('next.welcome') }}
        </div>
        <!-- END Welcome alert -->

        <!-- BEGIN Divider -->
        <div class="fancy-divider">
            <span>{{ trans('next.what_is_next') }}</span>
        </div>
        <!-- END Divider -->

        <!-- BEGIN First step -->
        <div class="first-step">
            <div class="well custom-well">
                <h4>{{ trans('next.start_creating_bills') }} - <a href="/bills?first-time=true">{{ trans('next.click_here_to_start') }}</a></h4>
                <h5 class="grey-text">{{ trans('next.start_using_nova') }}</h5>
            </div>
        </div>
        <!-- END First step -->

    </div>
    <!-- END Next page -->
@endsection

@section('scripts')
@endsection