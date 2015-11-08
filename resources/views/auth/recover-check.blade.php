<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta id="token" content="{{ csrf_token() }}">
    <meta id="user_id" content="{{ $id }}">
    <meta id="code" content="{{ $code }}">
    <title>{{ trans('recover.title') }}</title>
    <link rel="stylesheet" href="/css/app.css">
</head>
<body id="login-page">
<div class="container" id="recover">

    @include('includes.ajax-translations.common')

    <div class="row">

        <!-- BEGIN Recover form -->
        <div class="login-form col-md-4 col-md-offset-4">

            <!-- BEGIN Logo -->
            <div class="login-logo">
                <div class="text-center register-logo">
                    <div class="glyphicon glyphicon-lock text-center icon-color"></div>
                    <h2 class="icon-color">{{ trans('recover.choose_new_password') }}</h2>
                </div>
            </div>
            <!-- END Logo -->

            <!-- BEGIN New password input -->
            <div v-class="has-error: errors.new_password" class="form-group has-feedback">
                <input type="password" class="form-control" v-model="new_password" placeholder="{{ trans('recover.new_password') }}" />
                <i class="glyphicon glyphicon-lock form-control-feedback icon-color"></i>
                <span v-show="errors.new_password" class="text-danger">@{{ errors.new_password }}</span>
            </div>
            <!-- END New password input -->

            <!-- BEGIN Password confirmation input -->
            <div v-class="has-error: errors.password_confirmation" class="form-group has-feedback">
                <input type="password" class="form-control" v-model="password_confirmation" placeholder="{{ trans('recover.password_confirmation') }}" />
                <i class="glyphicon glyphicon-lock form-control-feedback icon-color"></i>
                <span v-show="errors.password_confirmation" class="text-danger">@{{ errors.password_confirmation }}</span>
            </div>
            <!-- END Password confirmation input -->

            <button v-on="click: setNewPassword()" v-attr="disabled: loading" class="btn btn-primary btn-block">
                <span v-show="loading" class="glyphicon glyphicon-refresh glyphicon-spin"></span>
                <span v-show="!loading">{{ trans('recover.change_password') }}</span>
            </button>
        </div>
        <!-- END Recover form -->
    </div>

    <div class="row forgot-password">
        <a href="/login"><p class="text-center">{{ trans('recover.login') }}</p></a>
    </div>

</div>
</body>
<script src="/js/vendor.js"></script>
<script src="/js/recover.js"></script>
</html>