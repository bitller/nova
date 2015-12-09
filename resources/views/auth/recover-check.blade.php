<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta id="token" content="{{ csrf_token() }}">
    <meta id="user_id" content="{{ $id }}">
    <meta id="code" content="{{ $code }}">
    <title>{{ trans('recover.check_title') }}</title>
    <link rel="stylesheet" href="/css/app.css">
    <link href='https://fonts.googleapis.com/css?family=Source+Sans+Pro:300' rel='stylesheet' type='text/css'>
</head>
<body id="recover-page">

@include('includes.not-logged.navbar', ['registerButton' => true])
@include('auth.includes.top-section', [
    'firstText' => trans('recover.choose_new_password'),
    'shortDescription' => trans('recover.choose_new_password_description')
])

<div class="container" id="recover">

    @include('includes.ajax-translations.common')

    <div class="well custom-well recover-form col-md-6 col-md-offset-3">
        <div class="col-md-10 col-md-offset-1">

            <!-- BEGIN Your account divider -->
            <div class="fancy-divider-white">
                <span>{{ trans('recover.change_password') }}</span>
            </div>
            <!-- END Your account divider -->

            <div class="alert alert-danger" v-show="general_error">@{{ general_error }}</div>

            <!-- BEGIN Password input -->
            <div class="form-group has-feedback" v-class="has-error : errors.new_password">
                <input v-model="new_password" type="password" class="form-control" placeholder="{{ trans('recover.new_password') }}">
                <span v-show="errors.new_password" class="text-danger">@{{ errors.new_password }}</span>
                <i class="glyphicon glyphicon-lock form-control-feedback icon-color"></i>
            </div>
            <!-- END Password input -->

            <!-- BEGIN Password confirmation input -->
            <div class="form-group has-feedback" v-class="has-error : errors.new_password_confirmation">
                <input v-model="new_password_confirmation" type="password" class="form-control" placeholder="{{ trans('recover.password_confirmation') }}">
                <span v-show="errors.new_password_confirmation" class="text-danger">@{{ errors.new_password_confirmation }}</span>
                <i class="glyphicon glyphicon-lock form-control-feedback icon-color"></i>
            </div>
            <!-- END Password confirmation input -->

            <!-- BEGIN Change password button -->
            <div class="form-group login-button">
                <button v-attr="disabled : loading" v-on="click: setNewPassword()" class="btn-block btn btn-primary">
                    <span v-show="loading" class="glyphicon glyphicon-refresh glyphicon-spin"></span>
                    <span v-show="!loading">{{ trans('recover.change_password') }}</span>
                </button>
            </div>
            <!-- END Change password button -->
        </div>
    </div>
    <div class="col-md-6 col-md-offset-3 text-center forgot-password">
        <a href="/login">{{ trans('recover.remember_password') }}</a>
    </div>

</div>
</body>
<script src="/js/vendor.js"></script>
<script src="/js/recover.js"></script>
</html>