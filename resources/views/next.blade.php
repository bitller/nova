@extends('layout')
@section('content')
    <div id="next">

        <div class="alert alert-success welcome-alert">
            <span class="glyphicon glyphicon-ok"></span>&nbsp;
            {{ trans('next.welcome') }}
        </div>

        <div class="fancy-divider">
            <span>{{ trans('next.what_is_next') }}</span>
        </div>

        <div class="first-step">
            <div class="well custom-well">
                <h4>{{ trans('next.start_creating_bills') }} - <a href="#">{{ trans('next.click_here_to_see_the_video') }}</a></h4>
                <h5 class="grey-text">{{ trans('next.how_to_create_my_first_bill') }}</h5>
            </div>
        </div>

        <div class="second-step">
            <div class="well custom-well">
                <h4>{{ trans('next.add_products_to_bill') }} - <a href="#">{{ trans('next.click_here_to_see_the_video') }}</a></h4>
            </div>
        </div>

        <div>
            <div class="well custom-well">
                <h4>{{ trans('next.print_bill_title') }} - <a href="#">{{ trans('next.click_here_to_see_the_video') }}</a></h4>
                <h5 class="grey-text">{{ trans('next.print_bill') }}</h5>
            </div>
        </div>

    </div>
@endsection

@section('scripts')
@endsection