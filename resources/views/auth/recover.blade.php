<!DOCTYPE html>
<html>
@include('auth.includes.head', ['pageTitle' => trans('recover.title')])

<!-- BEGIN Recover page -->
<body id="recover-page">

@include('includes.not-logged.navbar')
@include('auth.includes.top-section', [
    'firstText' => trans('login.forgot_password'),
    'shortDescription' => trans('recover.short_description')
])

<!-- BEGIN Recover form -->
<div class="container" id="recover">
    @include('includes.ajax-translations.common')

    <div class="well custom-well recover-form col-md-6 col-md-offset-3">
        <div class="col-md-10 col-md-offset-1">

            <!-- BEGIN Your account divider -->
            <div class="fancy-divider-white">
                <span>{{ trans('recover.your_email') }}</span>
            </div>
            <!-- END Your account divider -->

            <div class="alert alert-danger" v-show="general_error">@{{ general_error }}</div>

            <!-- BEGIN Email input -->
            <div class="form-group has-feedback" v-class="has-error : errors.email">
                <input v-model="email" v-on="keyup:recover | key 13" type="text" class="form-control" placeholder="{{ trans('login.email_placeholder') }}">
                <span v-show="errors.email" class="text-danger">@{{ errors.email }}</span>
                <i class="glyphicon glyphicon-user form-control-feedback icon-color"></i>
            </div>
            <!-- END Email input -->

            <!-- BEGIN Login button -->
            <div class="form-group recover-button">
                <button v-attr="disabled : loading" v-on="click: recover()" class="btn-block btn btn-primary">
                    <span v-show="loading" class="glyphicon glyphicon-refresh glyphicon-spin"></span>
                    <span v-show="!loading">{{ trans('recover.recover') }}</span>
                </button>
            </div>
            <!-- END Login button -->
        </div>
    </div>

</div>
<!-- END Recover form -->
<script src="/js/vendor.js"></script>
<script src="/js/recover.js"></script>
</body>
<!-- END Recover page -->

</html>