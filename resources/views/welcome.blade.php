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
            <a class="navbar-brand" href="#">Nova</a>
        </div>
        <div id="navbar" class="navbar-collapse collapse">
            <ul class="nav navbar-nav navbar-right">
                <li>
                    <p class="navbar-btn">
                        <a href="/login" class="btn btn-default custom-button">{{ Lang::get('common.login_button') }}</a>
                    </p>
                </li>
            </ul>
        </div><!--/.nav-collapse -->
    </div>
</nav>

<div id="startchange">

    <div class="first-section">
        <div class="container">
            <h2 class="text-center welcome-text">{{ trans('welcome.principal_title') }}</h2>
            <div class="col md-12 text-center image-video-container">
                <img src="http://placehold.it/800x400">
            </div>
        </div>
    </div>


    <div class="fluid-container second-section">

        <div class="row">

            <div class="col-md-4 col-md-offset-4 big-button-container">
                <div class="btn btn-block btn-primary big-button">{{ trans('welcome.start') }}</div>
            </div>

            <div class="col-md-4 col-md-offset-4 text-center">
                <h3 class="free-text">{{ trans('welcome.free_period') }}</h3>
                <h4 class="free-text-description grey-text">{{ trans('welcome.free_period_description') }}</h4>
            </div>

        </div>
    </div>

    <!-- BEGIN Fast access to client history feature -->
    <div class="container-fluid client-history-feature">
    <div class="row">

        <div class="col-md-6 col-md-offset-3">

            <div class="col-md-3">
                <img class="img-responsive col-md-offset-1" src="http://placehold.it/200x200" />
            </div>

            <div class="col-md-9">
                <div class="row">
                    <h3 class="col-md-11 col-md-offset-1 title grey-text">{{ trans('welcome.access_to_client_history') }}</h3>
                </div>
                <div class="row">
                    <h4 class="col-md-11 col-md-offset-1 description light-grey-text">{{ trans('welcome.access_to_client_history_description') }}</h4>
                </div>
            </div>

        </div>
    </div>
    </div>
    <!-- END Fast access to client history feature -->

    <!-- BEGIN Customized bills for your clients feature -->
    <div class="container-fluid customized-bills-feature">
        <div class="row">

            <div class="col-md-6 col-md-offset-3">

                <!-- BEGIN Feature title and description -->
                <div class="col-md-9">

                    <!-- BEGIN Feature title -->
                    <div class="row">
                        <h3 class="grey-text">{{ trans('welcome.personalized_bills') }}</h3>
                    </div>
                    <!-- END Feature title -->

                    <!-- BEGIN Feature description -->
                    <div class="row">
                        <h4 class="light-grey-text">{{ trans('welcome.personalized_bills_description') }}</h4>
                    </div>
                    <!-- END Feature description -->

                </div>
                <!-- END Feature title and description -->

                <!-- BEGIN Feature image -->
                <div class="col-md-3">
                    <img src="http://placehold.it/200x200">
                </div>
                <!-- END Feature image -->

            </div>

        </div>
    </div>
    <!-- END Customized bills for your clients feature -->

    <!-- BEGIN Create bills in seconds and statistics features -->
    <div class="fluid-container create-bills-in-seconds-and-statistics-features">

        <div class="row">
            <div class="container text-center">
            <div class="col-md-4 col-md-offset-2">
                <img src="http://placehold.it/210x210">
                <h3 class="grey-text">{{ trans('welcome.bills_in_seconds') }}</h3>
                <h5 class="grey-text">{{ trans('welcome.bills_in_seconds_description') }}</h5>
            </div>
            <div class="col-md-4">
                <img src="http://placehold.it/210x210">
                <h3 class="grey-text">{{ trans('welcome.details_about_earnings') }}</h3>
                <h5 class="grey-text">{{ trans('welcome.details_about_earnings_description') }}</h5>
            </div>
                </div>
        </div>

    </div>
    <!-- END Create bills in seconds and statistics features -->

    <!-- BEGIN 30 seconds away -->
    <div class="fluid-container first-three-months-free">

        <div class="row">
            <div class="container">
                <h5>{{ trans('welcome.first_three_months_are_free') }}</h5>
            </div>
        </div>

    </div>
    <!-- END 30 seconds away -->

    <!-- BEGIN Footer -->
    <div class="fluid-container footer">

        <div class="row">
            <div class="container">

                <!-- BEGIN Nova -->
                <div class="col-md-3">
                    <h3>Nova</h3>
                    <h5>Made with passion in Europe by:</h5>
                    <h5>Bitller S.R.L</h5>
                    <h5>Registration id: 12345678</h5>
                </div>
                <!-- END Nova -->

                <!-- BEGIN Contact -->
                <div class="col-md-3 col-md-offset-3">
                    <h3>Contact</h3>
                    <h5><a href="mailto:contact@nova-manager.com">contact@nova-manager.com</a></h5>
                    <h5>44 Caragiale street</h5>
                    <h5>Bl. 4 Ap. 8, 259178</h5>
                    <h5>Timisoara, Romania</h5>
                </div>
                <!-- END Contact -->

                <!-- BEGIN About and legal -->
                <div class="col-md-3">
                    <h3>About and legal</h3>
                    <h5><a href="#">About</a></h5>
                    <h5><a href="#">Pricing</a></h5>
                    <h5><a href="#">Terms and conditions</a></h5>
                    <h5><a href="#">Privacy policy</a></h5>
                    <h5><a href="#">Imprint</a></h5>
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