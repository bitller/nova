@extends('layout.index')
@section('content')

@include('includes.ajax-translations.common')

<!-- BEGIN Create subscription with credit card -->
<div id="credit-card-subscription">

    <div class="col-sm-12 col-md-12 col-lg-12">

        <div class="well custom-well">

            <div class="row">
                @include('subscribe.card-partials._info')
            </div>

            <!-- BEGIN Card number and card holder row -->
            <div class="row">
                @include('subscribe.index-partials._card-number')
                @include('subscribe.index-partials._card-holder')
            </div>
            <!-- END Card number and card holder row -->

            <!-- BEGIN Card expiry month and year row -->
            <div class="row">
                @include('subscribe.index-partials._card-expiry-month')
                @include('subscribe.index-partials._card-expiry-year')
            </div>
            <!-- END Card expiry month and year row -->

            <!-- BEGIN Cvc and pay button row -->
            <div class="row">
                @include('subscribe.index-partials._cvc')
                @include('subscribe.index-partials._pay-button')
            </div>
            <!-- END Cvc and pay button row -->

            <div class="divider"></div>

            <!-- BEGIN Questions row -->
            <div class="row">
                @include('subscribe.card-partials._questions')
            </div>
            <!-- END Questions row -->

        </div>
    </div>

</div>
<!-- END Create subscription with cred card -->

@endsection

@section('scripts')

@endsection