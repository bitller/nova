@extends('layout.welcome.index')
@section('content')
    <div class="container pricing">
        <div class="row">

            <div class="col-md-12 text-center">
                <h3 class="grey-text">{{ trans('pricing.pricing') }}</h3>
            </div>

            <div class="col-md-6 col-md-offset-3">
                <div class="well custom-well">

                    <!-- BEGIN Money icon -->
                    <div class="row">
                        <div class="col-md-4 col-md-offset-4">
                            <img class="img-responsive center-responsive-image" src="/img/money.svg">
                        </div>
                    </div>
                    <!-- END Money icon -->

                    <!-- BEGIN Price -->
                    <div class="row">
                        <div class="col-md-12 text-center grey-text">
                            <h2>12.99</h2>
                            <h3>{{ trans('pricing.per_month') }}</h3>
                        </div>
                    </div>
                    <!-- END Price -->

                    <div class="divider"></div>

                    <!-- BEGIN Free days -->
                    <div class="row">
                        <div class="col-md-12">
                            <img class="img-responsive center-responsive-image" src="/img/medium-star.svg">
                        </div>
                        <div class="col-md-12 text-center">
                            <h3 class="grey-text">{{ trans('pricing.first_90_days_are_free') }}</h3>
                        </div>
                    </div>
                    <!-- END Free days -->

                    <div class="divider"></div>

                    <!-- BEGIN Credit card -->
                    <div class="row">
                        <div class="col-md-3">
                            <img class="img-responsive center-responsive-image" src="/img/credit-card.svg">
                        </div>
                        <div class="col-md-9">
                            <h3 class="grey-text">{{ trans('pricing.pay_online') }}</h3>
                            <h5 class="light-grey-text">{{ trans('pricing.pay_online_description') }}</h5>
                        </div>
                    </div>
                    <!-- END Credit card -->

                    <!-- BEGIN Bank -->
                    <div class="row bank-method">
                        <div class="col-md-3">
                            <img class="img-responsive center-responsive-image" src="/img/globe.svg">
                        </div>
                        <div class="col-md-9">
                            <h3 class="grey-text">{{ trans('pricing.pay_at_the_bank') }}</h3>
                            <h5 class="light-grey-text">{{ trans('pricing.pay_at_the_bank_description') }}</h5>
                        </div>
                    </div>
                    <!-- END Bank -->

                    <div class="row create-account-free">
                        <div class="col-md-12">
                            <a href="/register"><button class="btn btn-block btn-primary">Creeaza-ti cont gratuit acum!</button></a>
                        </div>
                    </div>

                </div>
            </div>

        </div>
    </div>
@endsection