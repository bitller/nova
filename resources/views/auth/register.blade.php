<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta id="token" content="{{ csrf_token() }}">
    <title>{{ trans('register.title') }}</title>
    <link rel="stylesheet" href="/css/app.css">
    <link href='https://fonts.googleapis.com/css?family=Source+Sans+Pro:300' rel='stylesheet' type='text/css'>
</head>

<!-- BEGIN Register page -->
<body id="register-page">

@include('includes.not-logged.navbar')

<!-- BEGIN Top section -->
<div class="jumbotron custom-jumbotron text-center">
    <div class="row">
    <div class="col-md-6 col-md-offset-3 text-center">
        <span class="first-text">{{ trans('register.start_using_nova') }}</span>
        <span class="short-description">{{ trans('register.short_description') }}</span>
    </div></div>
</div>
<!-- END Top section -->

<!-- BEGIN Register form -->
<div class="container" id="register">
    @include('includes.ajax-translations.common')

    <div class="well custom-well col-md-6 col-md-offset-3" style="margin-top:-70px">

        <!-- Price divider -->
        <div class="fancy-divider-white">
            <span>{{ trans('register.subscription_price') }}</span>
        </div>
        <!-- END Price divider -->

        <div class="text-center">
            <span class="price">19.99</span>
            <span class="currency">{{ trans('register.currency') }}</span>
            <span class="period">/{{ trans('register.period') }}</span>
        </div>

        <!-- BEGIN Profile divider -->
        <div class="fancy-divider-white">
            <span>{{ trans('register.your_profile') }}</span>
        </div>
        <!-- END Profile divider -->

        <!-- BEGIN Email -->
        <div class="form-group">
            <input class="form-control border-input" type="text" placeholder="{{ trans('register.what_is_your_email') }}" />
        </div>
        <!-- END Email -->

        <!-- BEGIN Password -->
        <div class="form-group">
            <input class="form-control border-input" type="password" placeholder="{{ trans('register.choose_password') }}" />
        </div>
        <!-- END Password -->

        <!-- BEGIN Confirm password -->
        <div class="form-group">
            <input class="form-control border-input" type="password" placeholder="{{ trans('register.confirm_password') }}" />
        </div>
        <!-- END Confirm password -->

        <!-- BEGIN Billing information -->
        <div class="fancy-divider-white">
            <span>{{ trans('register.billing_information') }}</span>
        </div>
        <!-- END Billing information -->

        <div class="form-group">
            <input class="form-control border-input" type="text" placeholder="{{ trans('register.card_number') }}" />
        </div>

        <div class="form-group">
            <input class="form-control border-input" type="text" placeholder="{{ trans('register.cvv_code') }}" />
        </div>

        <label for="expiry" class="expiry-text">{{ trans('register.expiry_date') }}</label>
        <div class="form-inline" id="expiry">

            <div class="form-group">
                <input type="text" class="form-control border-input" placeholder="{{ trans('register.expiry_month') }}">
            </div>
            /
            <div class="form-group">
                <input type="text" class="form-control border-input" placeholder="{{ trans('register.expiry_year') }}">
            </div>
        </div>
        <div class="form-group register-button">
            <button class="btn-block btn btn-primary">{{ trans('register.join') }}</button>
        </div>

    </div>
</div>
<!-- END Register form -->

</body>
<!-- END Register page -->
<script src="/js/vendor.js"></script>
<script src="/js/register.js"></script>
</html>