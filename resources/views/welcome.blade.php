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
            <h2 class="text-center welcome-text">{{ Lang::get('welcome.welcome') }}</h2>
            <h4 class="text-center description-text">{{ Lang::get('welcome.what_is_nova') }}</h4>

            <div class="video col-md-12">
                <iframe src="http://www.youtube.com/embed/s2Q439DKqHE?rel=0;3&amp;autohide=1&amp;showinfo=0" frameborder="0" width="635" height="353"></iframe>
            </div>

            <div class="col-md-12 text-center start-button">
                <a href="/register"><button class="btn btn-default custom-button">{{ Lang::get('welcome.start') }}</button></a>
            </div>
        </div>
    </div>

    <div class="second-section">

        <div class="container">
            <h3 class="text-center why-nova">{{ Lang::get('welcome.why') }}</h3>
            <div class="col-md-4">
                <img class="img-center center-block" src="{{ url('/img/add.png') }}">
                <h4 class="text-center">{{ Lang::get('welcome.fast_bill_creation') }}</h4>
                <h5 class="text-center gray-color">{{ Lang::get('welcome.fast_bill_creation_long') }}</h5>
            </div>
            <div class="col-md-4">
                <img class="img-center center-block" src="{{ url('/img/easy-access.png') }}">
                <h4 class="text-center">{{ Lang::get('welcome.fast_access') }}</h4>
                <h5 class="text-center gray-color">{{ Lang::get('welcome.fast_access_long') }}</h5>
            </div>
            <div class="col-md-4">
                <img class="img-center center-block" src="{{ url('/img/print.png') }}">
                <h4 class="text-center">{{ Lang::get('welcome.print_bills') }}</h4>
                <h5 class="text-center gray-color">{{ Lang::get('welcome.print_bills_long') }}</h5>
            </div>
        </div>

        <div class="container">
            <div class="col-md-4">
                <img class="img-center center-block" src="{{ url('/img/code.png') }}">
                <h4 class="text-center">{{ Lang::get('welcome.add_products_by_code') }}</h4>
                <h5 class="text-center gray-color">{{ Lang::get('welcome.add_products_by_code_long') }}</h5>
            </div>

            <div class="col-md-4">
                <img class="img-center center-block" src="{{ url('/img/stats.png') }}">
                <h4 class="text-center">{{ Lang::get('welcome.statistics') }}</h4>
                <h5 class="text-center gray-color">{{ Lang::get('welcome.statistics_long') }}</h5>
            </div>

            <div class="col-md-4">
                <img class="img-center center-block" src="{{ url('/img/search.png') }}">
                <h4 class="text-center">{{ Lang::get('welcome.search_by_code') }}</h4>
                <h5 class="text-center gray-color">{{ Lang::get('welcome.search_by_code_long') }}</h5>
            </div>
        </div>

    </div>

    <div class="third-section">

        <div class="container col-md-6 col-md-offset-3">

                <div class="container col-md-6"><img class="col-md-offset-1" src="{{ url('/img/customer.png') }}"></div>
                <div class="container col-md-6">
                    <div class="row">
                        <h3 class="col-md-9 col-md-offset-1 title">Access rapid la istoricul fiecarui client.</h3>
                    </div>
                    <div class="row">
                        <h5 class="col-md-9 col-md-offset-1 description">Doresti sa afli cate comenzi a efectuat un client? Suma totala a comenzilor? Cati bani a economisit prin discount-ul primit? Cand a efectuat ultima comanda? Numarul lui de telefon? Cu Nova ai access la istoricul tuturor clienților.</h5>
                    </div>
                </div>

        </div>

    </div>

</div>

<script src="/js/vendor.js"></script>
<script src="js/welcome.js"></script>

</body>

</html>