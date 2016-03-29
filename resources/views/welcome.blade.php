@extends('layout.welcome.index')
@section('content')
    <div class="first-section">
        <div class="container">
            <h2 class="text-center welcome-text">{{ trans('welcome.principal_title') }}</h2>
            <div class="col md-12 text-center image-video-container">
                <img src="http://placehold.it/800x400">
            </div>
        </div>
    </div>


    <div class="fluid-container second-section">

        <div class="row">

            <div class="col-md-12 text-center">
                <img src="{{ url('/img/star.svg') }}">
            </div>

            <div class="col-md-4 col-md-offset-4 text-center">
                <h3 class="free-text grey-text">{{ trans('welcome.free_period') }}</h3>
                <h4 class="free-text-description light-grey-text">{{ trans('welcome.free_period_description') }}</h4>
            </div>


            <div class="col-md-4 col-md-offset-4 big-button-container">
                <a class="no-underline-href" href="/register"><div class="btn btn-block btn-primary big-button">{{ trans('welcome.start') }}</div></a>
            </div>



        </div>
    </div>

    <!-- BEGIN Campaign statistics -->
    <div class="container-fluid campaign-statistics">

        <div class="row">

            <div class="col-md-6 col-md-offset-3">

                <!-- BEGIN Feature title and description -->
                <div class="col-md-8">

                    <!-- BEGIN Feature title -->
                    <div class="row">
                        <h3 class="grey-text">{{ trans('welcome.statistics_for_campaigns') }}</h3>
                    </div>
                    <!-- END Feature title -->

                    <!-- BEGIN Feature description -->
                    <div class="row">
                        <h4 class="light-grey-text">{{ trans('welcome.statistics_for_campaigns_description') }}</h4>
                    </div>
                    <!-- END Feature description -->

                </div>
                <!-- END Feature title and description -->

                <!-- BEGIN Feature image -->
                <div class="col-md-3 col-md-offset-1">
                    <img src="{{ url('/img/stats.svg') }}">
                </div>
                <!-- END Feature image -->

            </div>

        </div>

    </div>
    <!-- END Campaign statistics -->

    <!-- BEGIN Fast access to client history feature -->
    <div class="container-fluid client-history-feature">
        <div class="row">

            <div class="col-md-6 col-md-offset-3">

                <div class="col-md-4">
                    <img class="img-responsive col-md-offset-1" src="{{ url('/img/easy-access.svg') }}" />
                </div>

                <div class="col-md-8">
                    <div class="row">
                        <h3 class="col-md-11 col-md-offset-1 title grey-text">{{ trans('welcome.access_to_client_history') }}</h3>
                    </div>
                    <div class="row">
                        <h4 class="col-md-11 col-md-offset-1 description light-grey-text">{{ trans('welcome.access_to_client_history_description') }}</h4>
                    </div>
                </div>

            </div>
        </div>
    </div>
    <!-- END Fast access to client history feature -->

    <!-- BEGIN Customized bills for your clients feature -->
    <div class="container-fluid customized-bills-feature">
        <div class="row">

            <div class="col-md-6 col-md-offset-3">

                <!-- BEGIN Feature title and description -->
                <div class="col-md-8">

                    <!-- BEGIN Feature title -->
                    <div class="row">
                        <h3 class="grey-text">{{ trans('welcome.personalized_bills') }}</h3>
                    </div>
                    <!-- END Feature title -->

                    <!-- BEGIN Feature description -->
                    <div class="row">
                        <h4 class="light-grey-text">{{ trans('welcome.personalized_bills_description') }}</h4>
                    </div>
                    <!-- END Feature description -->

                </div>
                <!-- END Feature title and description -->

                <!-- BEGIN Feature image -->
                <div class="col-md-3 col-md-offset-1">
                    <img src="{{ url('/img/news.svg') }}">
                </div>
                <!-- END Feature image -->

            </div>

        </div>
    </div>
    <!-- END Customized bills for your clients feature -->

    <!-- BEGIN Create bills in seconds and statistics features -->
    <div class="fluid-container create-bills-in-seconds-and-statistics-features">

        <div class="row">
            <div class="container text-center">
                <div class="col-md-4 col-md-offset-2">
                    <img src="{{ url('/img/time.svg') }}">
                    <h3 class="grey-text">{{ trans('welcome.bills_in_seconds') }}</h3>
                    <h5 class="grey-text">{{ trans('welcome.bills_in_seconds_description') }}</h5>
                </div>
                <div class="col-md-4">
                    <img src="{{ url('/img/money.svg') }}">
                    <h3 class="grey-text">{{ trans('welcome.details_about_earnings') }}</h3>
                    <h5 class="grey-text">{{ trans('welcome.details_about_earnings_description') }}</h5>
                </div>
            </div>
        </div>

    </div>
    <!-- END Create bills in seconds and statistics features -->

    <!-- BEGIN 30 seconds away -->
    <div class="fluid-container first-three-months-free">

        <div class="row">
            <div class="container">

            </div>
        </div>

    </div>
    <!-- END 30 seconds away -->
@endsection