<!DOCTYPE html>
<html>
@include('auth.includes.head', ['pageTitle' => trans('login.title')])

<!-- BEGIN Login page -->
<body id="login-page">

{{-- Include navbar --}}
@include('includes.not-logged.navbar', ['registerButton' => true])
{{-- Include top section --}}
@include('auth.includes.top-section', [
    'firstText' => trans('login.login'),
    'shortDescription' => trans('login.short_description')
])

<!-- BEGIN Login form -->
<div class="container" id="login">
    @include('includes.ajax-translations.common')
    <div class="well custom-well login-form col-md-6 col-md-offset-3">
        <div class="col-md-10 col-md-offset-1">

            <!-- BEGIN Your account divider -->
            <div class="fancy-divider-white">
                <span>{{ trans('login.your_account') }}</span>
            </div>
            <!-- END Your account divider -->

            <div class="alert alert-danger" v-show="general_error">@{{ general_error }}</div>

            <!-- BEGIN Email input -->
            <div class="form-group has-feedback" v-class="has-error : errors.email">
                <input id="login-email" v-model="email" v-on="keyup:login | key 13" type="text" class="form-control" placeholder="{{ trans('login.email_placeholder') }}">
                <span v-show="errors.email" class="text-danger">@{{ errors.email }}</span>
                <i class="glyphicon glyphicon-user form-control-feedback icon-color"></i>
            </div>
            <!-- END Email input -->

            <!-- BEGIN Password input -->
            <div class="form-group has-feedback" v-class="has-error : errors.password">
                <input v-model="password" v-on="keyup:login | key 13" type="password" class="form-control" placeholder="{{ trans('login.password_placeholder') }}">
                <span v-show="errors.password" class="text-danger">@{{ errors.password }}</span>
                <i class="glyphicon glyphicon-lock form-control-feedback icon-color"></i>
            </div>
            <!-- END Password input -->

            <!-- BEGIN Login button -->
            <div class="form-group login-button">
                <button v-attr="disabled : loading" v-on="click: login()" class="btn-block btn btn-primary">
                    <span v-show="loading" class="glyphicon glyphicon-refresh glyphicon-spin"></span>
                    <span v-show="!loading">{{ trans('login.login') }}</span>
                </button>
            </div>
            <!-- END Login button -->
        </div>
    </div>
    <div class="col-md-6 col-md-offset-3 text-center forgot-password">
        <a href="/recover">{{ trans('login.forgot_password') }}</a>
    </div>
</div>
<!-- END Login form -->

<script src="/js/vendor.js"></script>
<script src="/js/login.js"></script>

</body>
<!-- END Login page -->

</html>