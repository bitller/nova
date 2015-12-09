@extends('layout')
@section('content')
    <div id="next">

        <div class="alert alert-success welcome-alert">{{ trans('next.welcome') }}</div>

        <div class="fancy-divider">
            <span>{{ trans('next.how_to_create_my_first_bill') }}</span>
        </div>

        <div class="first-step">
            <h4>1. {{ trans('next.first_step') }}</h4>
            <div class="well custom-well">
                <img src="http://s17.postimg.org/4bts3c4jv/imageedit_4_7742351602.png">
                <h5 style="display: inline-block;vertical-align: top">Go to <a href="#">Nova homepage</a> and click "Create bill" button</h5>
            </div>
        </div>

        <div class="second-step">
            <h4>2. {{ trans('next.second_step') }}</h4>
            <div class="well custom-well">
                <img src="http://new.learnhigher.ac.uk/blog/wp-content/uploads/300x200px.png">
                <h5 style="display: inline-block;vertical-align: top">Go to Nova homepage and click "Create bill" button</h5>
            </div>
        </div>

    </div>
@endsection

@section('scripts')
@endsection