<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta id="token" content="{{ csrf_token() }}">
    <title>{{ trans('register.title') }}</title>
    <link rel="stylesheet" href="/css/app.css">
</head>
<body id="login-page">
<div class="container" id="register">
    @include('includes.ajax-translations.common')
    <div class="row register-button">
        <a href="/login"><button class="btn btn-danger pull-right">{{ trans('register.login') }}</button></a>
    </div>

    <div class="row">

        <!-- BEGIN Login form -->
        <div class="login-form col-md-4 col-md-offset-4">

            <!-- BEGIN Logo -->
            <div class="login-logo">
                {{--<span class="glyphicon glyphicon-list-alt text-center icon-color" style="font-size: 40px"></span>--}}
                {{--<a href="/register">--}}
                    <div class="text-center register-logo">
                        <div class="glyphicon glyphicon-list-alt text-center icon-color"></div>
                        <h2 class="icon-color">{{ trans('register.create_account') }}</h2>
                    </div>
                {{--</a>--}}
            </div>
            <!-- END Logo -->


            <!-- BEGIN First name input -->
            <div v-class="has-error: errors.first_name" class="form-group has-feedback">
                <input v-model="first_name" type="text" class="form-control" placeholder="{{ trans('register.what_is_your_first_name') }}" />
                <i class="glyphicon glyphicon-user form-control-feedback icon-color"></i>
                <span v-show="errors.first_name" class="text-danger">@{{ errors.first_name }}</span>
            </div>
            <!-- END First name input -->

            <!-- BEGIN Last name input -->
            <div v-class="has-error: errors.last_name" class="form-group has-feedback">
                <input v-model="last_name" type="text" class="form-control" placeholder="{{ trans('register.what_is_your_last_name') }}" />
                <i class="glyphicon glyphicon-user form-control-feedback icon-color"></i>
                <span v-show="errors.last_name" class="text-danger">@{{ errors.last_name }}</span>
            </div>
            <!-- END Last name -->

            <!-- BEGIN Email input -->
            <div v-class="has-error: errors.email" class="form-group has-error has-feedback">
                <input v-model="email" type="text" class="form-control" placeholder="{{ trans('register.what_is_your_email') }}" />
                <i class="glyphicon glyphicon-envelope form-control-feedback icon-color"></i>
                <span v-show="errors.email" class="text-danger">@{{ errors.email }}</span>
            </div>
            <!-- END Email input -->

            <!-- BEGIN Password input -->
            <div v-class="has-error: errors.password" class="form-group has-error has-feedback">
                <input v-model="password" type="password" class="form-control" placeholder="{{ trans('register.choose_password') }}" />
                <i class="glyphicon glyphicon-lock form-control-feedback icon-color"></i>
                <span v-show="errors.password" class="text-danger">@{{ errors.password }}</span>
            </div>
            <!-- END Password input -->

            <!-- BEGIN Confirm password -->
            <div v-class="has-error: errors.password_confirmation" class="form-group has-error has-feedback">
                <input v-model="password_confirmation" type="password" class="form-control" placeholder="{{ trans('register.confirm_password') }}" />
                <i class="glyphicon glyphicon-lock form-control-feedback icon-color"></i>
                <span v-show="errors.password_confirmation" class="text-danger">@{{ errors.password_confirmation }}</span>
            </div>
            <!-- END Confirm password -->

            <button v-on="click: register()" v-attr="disabled: loading" class="btn btn-primary btn-block">
                <span v-show="loading" class="glyphicon glyphicon-refresh glyphicon-spin"></span>
                <span v-show="!loading">{{ trans('register.create_account') }}</span>
            </button>
            {{--<input v-attr="disabled: loading" v-on="click: register()" type="submit" class="btn btn-primary btn-block" value="{{ trans('register.create_account') }}">--}}
        </div>
        <!-- END Login form -->
    </div>

    <div class="row forgot-password">
        <a href="/recover"><p class="text-center">{{ trans('login.forgot_password') }}</p></a>
    </div>

</div>
</body>
<script src="/js/vendor.js"></script>
<script src="/js/register.js"></script>
</html>