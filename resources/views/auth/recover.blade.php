<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta id="token" content="{{ csrf_token() }}">
    <title>{{ trans('recover.title') }}</title>
    <link rel="stylesheet" href="/css/app.css">
</head>
<body id="login-page">
<div class="container" id="recover">

    @include('includes.ajax-translations.common')

    <div class="row register-button">
        <a href="/login"><button class="btn btn-danger pull-right">{{ trans('register.login') }}</button></a>
    </div>

    <div class="row">

        <!-- BEGIN Recover form -->
        <div class="login-form col-md-4 col-md-offset-4">

            <!-- BEGIN Logo -->
            <div class="login-logo">
                <div class="text-center register-logo">
                    <div class="glyphicon glyphicon-refresh text-center icon-color"></div>
                    <h2 class="icon-color">{{ trans('recover.forgot_password') }}</h2>
                </div>
            </div>
            <!-- END Logo -->

            <!-- BEGIN Email input -->
            <div v-class="has-error: error" class="form-group has-error has-feedback">
                <input v-model="email" type="text" class="form-control" placeholder="{{ trans('register.what_is_your_email') }}" />
                <i class="glyphicon glyphicon-envelope form-control-feedback icon-color"></i>
                <span v-show="error" class="text-danger">@{{ error }}</span>
            </div>
            <!-- END Email input -->

            <button v-on="click: recover()" v-attr="disabled: loading" class="btn btn-primary btn-block">
                <span v-show="loading" class="glyphicon glyphicon-refresh glyphicon-spin"></span>
                <span v-show="!loading">{{ trans('recover.reset_password') }}</span>
            </button>
        </div>
        <!-- END Recover form -->
    </div>

    <div class="row forgot-password">
        <a href="/register"><p class="text-center">{{ trans('recover.no_account') }}</p></a>
    </div>

</div>
</body>
<script src="/js/vendor.js"></script>
<script src="/js/recover.js"></script>
</html>