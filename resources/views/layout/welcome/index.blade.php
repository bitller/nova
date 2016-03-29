<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Nova</title>
    <link rel="stylesheet" href="/css/app.css">
    <link href='http://fonts.googleapis.com/css?family=Quicksand' rel='stylesheet' type='text/css'>
    <link href='http://fonts.googleapis.com/css?family=Raleway' rel='stylesheet' type='text/css'>
</head>

<body>

<!-- Fixed navbar -->
<nav class="navbar navbar-default navbar-fixed-top">
    <div class="container">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="/">Nova</a>
        </div>
        <div id="navbar" class="navbar-collapse collapse">
            <ul class="nav navbar-nav navbar-right">
                {{--<li>--}}
                {{--<a href="#">{{ trans('welcome.pricing') }}</a>--}}
                {{--</li>--}}
                <li>
                    <p class="navbar-btn">
                        <a href="/login" class="btn custom-button">{{ Lang::get('common.login_button') }}</a>
                    </p>
                </li>
            </ul>
        </div><!--/.nav-collapse -->
    </div>
</nav>

<div id="startchange">

    @yield('content')

    <!-- BEGIN Footer -->
    <div class="fluid-container footer">

        <div class="row">
            <div class="container">

                <!-- BEGIN Nova -->
                <div class="col-xs-6 col-sm-4 col-md-3 col-lg-3">
                    <h3>Nova</h3>
                    <h5>{{ trans('welcome.made_by') }}</h5>
                    <h5>{{ trans('welcome.made_by_company_name') }}</h5>
                    <h5>{{ trans('welcome.registration_id') }}: 12345678</h5>
                </div>
                <!-- END Nova -->

                <!-- BEGIN Contact -->
                <div class="col-xs-6 col-xs-offset-0 col-sm-4 col-sm-offset-0 col-md-3 col-md-offset-3 col-lg-3 col-lg-offset-3">
                    <h3>{{ trans('welcome.contact') }}</h3>
                    <h5><a href="mailto:contact@nova-manager.com">contact@nova-manager.com</a></h5>
                    <h5>{{ trans('welcome.address_1') }}</h5>
                    <h5>{{ trans('welcome.address_2') }}</h5>
                    <h5>{{ trans('welcome.address_3') }}</h5>
                </div>
                <!-- END Contact -->

                <!-- BEGIN About and legal -->
                <div class="col-xs-6 col-xs-offset-0 col-sm-4 col-sm-offset-0 col-md-3 col-lg-3">
                    <h3>{{ trans('welcome.about_and_legal') }}</h3>
                    <h5><a href="/pricing">{{ trans('welcome.pricing') }}</a></h5>
                    <h5><a href="/terms-and-conditions">{{ trans('welcome.terms_and_conditions') }}</a></h5>
                    <h5><a href="/privacy">{{ trans('welcome.privacy_policy') }}</a></h5>
                    <h5><a href="/imprint">{{ trans('welcome.imprint') }}</a></h5>
                </div>
                <!-- END About and legal -->
            </div>

        </div>

    </div>
    <!-- END Footer -->

</div>

<script src="/js/vendor.js"></script>
<script src="js/welcome.js"></script>

</body>

</html>