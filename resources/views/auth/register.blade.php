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
    @include('includes.ajax-translations.register')

    <div class="well custom-well register-form col-md-6 col-md-offset-3">
        <div class="col-md-10 col-md-offset-1">

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

            <div v-show="general_error" class="alert alert-danger">@{{ general_error }}</div>

            <!-- BEGIN Email -->
            <div class="form-group" v-class="has-error : email_error, has-error : errors.email">
                <input v-model="email" class="form-control border-input" type="text" placeholder="{{ trans('register.what_is_your_email') }}" />
                <span v-show="email_error" class="text-danger">@{{ email_error }}</span>
                <span v-show="errors.email" class="text-danger">@{{ errors.email }}</span>
            </div>
            <!-- END Email -->

            <!-- BEGIN Password -->
            <div class="form-group" v-class="has-error : password_error, has-error : errors.password">
                <input v-model="password" class="form-control border-input" type="password" placeholder="{{ trans('register.choose_password') }}" />
                <span v-show="password_error" class="text-danger">@{{ password_error }}</span>
                <span v-show="errors.password" class="text-danger">@{{ errors.password }}</span>
            </div>
            <!-- END Password -->

            <!-- BEGIN Confirm password -->
            <div class="form-group" v-class="has-error : password_confirmation_error, has-error : errors.password_confirmation">
                <input v-model="password_confirmation" class="form-control border-input" type="password" placeholder="{{ trans('register.confirm_password') }}" />
                <span v-show="password_confirmation_error" class="text-danger">@{{ password_confirmation_error }}</span>
                <span v-show="errors.password_confirmation" class="text-danger">@{{ errors.password_confirmation }}</span>
            </div>
            <!-- END Confirm password -->

            <!-- BEGIN Billing information -->
            <div class="fancy-divider-white">
                <span>{{ trans('register.billing_information') }}</span>
            </div>
            <!-- END Billing information -->

            <!-- BEGIN Card number -->
            <div class="form-group" v-class="has-error : card_number_error">
                <input v-model="card_number" class="form-control border-input" type="text" placeholder="{{ trans('register.card_number') }}" />
                <span v-show="card_number_error" class="text-danger">@{{ card_number_error }}</span>
            </div>
            <!-- END Card number -->

            <!-- BEGIN Card cvc code -->
            <div class="form-group" v-class="has-error : card_cvc_error">
                <input v-model="card_cvc" class="form-control border-input" type="text" placeholder="{{ trans('register.cvc_code') }}" />
                <span v-show="card_cvc_error" class="text-danger">@{{ card_cvc_error }}</span>
            </div>
            <!-- END Card cvc code -->

            <!-- BEGIN Card expiry date -->
            <label for="expiry" class="expiry-text">{{ trans('register.expiry_date') }}</label>
            <div class="form-inline" id="expiry">

                <div class="form-group" v-class="has-error : card_expiry_date_error">
                    <input v-model="card_expiry_month" type="text" class="form-control border-input" placeholder="{{ trans('register.expiry_month') }}">
                </div>
                /
                <div class="form-group" v-class="has-error : card_expiry_date_error">
                    <input v-model="card_expiry_year" type="text" class="form-control border-input" placeholder="{{ trans('register.expiry_year') }}">
                </div>
                <span v-show="card_expiry_date_error" class="text-danger">@{{ card_expiry_date_error }}</span>
            </div>
            <!-- END Card expiry date -->

            <div class="form-group register-button">
                <button v-attr="disabled : loading" v-on="click: register()" class="btn-block btn btn-primary">
                    <span v-show="loading" class="glyphicon glyphicon-refresh glyphicon-spin"></span>
                    <span v-show="!loading">{{ trans('register.join') }}</span>
                </button>
            </div>
        </div>
    </div>
    <div class="secure-form col-md-6 col-md-offset-3">
        {{ trans('register.secure_form') }}
    </div>
</div>
<!-- END Register form -->

<div class="jumbotron custom-jumbotron">
    <div class="container">
        <div class="fancy-divider-blue">
            <span>{{ trans('register.got_questions') }}</span>
        </div>

        <!-- BEGIN How to pay question and answer -->
        <div class="col-md-6">
            <div class="well blue-well">
                <div class="question">
                    <strong>{{ trans('register.how_to_pay_question') }}</strong>
                </div>
                <div>{{ trans('register.how_to_pay_answer') }}</div>
            </div>
        </div>
        <!-- END How to pay question and answer -->

        <!-- BEGIN Can i cancel question and answer -->
        <div class="col-md-6">
            <div class="well blue-well">
                <div class="question">
                    <strong>{{ trans('register.can_i_cancel_question') }}</strong>
                </div>
                <div>{{ trans('register.can_i_cancel_answer') }}</div>
            </div>
        </div>
        <!-- END Can i cancel question and answer -->


        <!-- BEGIN Automatically renew question and answer -->
        <div class="col-md-6">
            <div class="well blue-well">
                <div class="question">
                    <strong>{{ trans('register.subscription_automatically_renew_question') }}</strong>
                </div>
                <div>{{ trans('register.subscription_automatically_renew_answer') }}</div>
            </div>
        </div>
        <!-- END Automatically renew question and answer -->

        <!-- BEGIN Need help question and answer -->
        <div class="col-md-6">
            <div class="well blue-well">
                <div class="question">
                    <strong>{{ trans('register.need_help_question') }}</strong>
                </div>
                <div>{{ trans('register.need_help_answer') }}</div>
            </div>
        </div>
        <!-- END Need help question and answer -->

        </div>

    </div>
</div>

<div class="container">
<div class="col-md-12 text-center copyright">
    <span>{{ trans('register.copyright') }}</span>
</div>
</div>

</body>
<!-- END Register page -->
<script src="/js/vendor.js"></script>
<script type="text/javascript" src="https://bridge.paymill.com/"></script>
<script type="text/javascript">
    var PAYMILL_PUBLIC_KEY = '670897165999c7209df7ec84d1d5a55b';
</script>
<script src="/js/register.js"></script>
</html>