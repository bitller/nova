<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta id="token" content="{{ csrf_token() }}">
    <title>Nova</title>
    <link rel="stylesheet" href="/css/app.css">
    @yield('styles')
    <link href='https://fonts.googleapis.com/css?family=Quicksand' rel='stylesheet' type='text/css'>
    @yield('fonts')

    @yield('top-scripts')

</head>

<body id="layout">

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
            <a class="navbar-brand app-logo" href="/bills">Nova</a>
        </div>
        <div id="navbar" class="navbar-collapse collapse">

            <ul class="nav navbar-nav">
                @include('layout.partials._notifications-navbar-item')
                @include('layout.partials._products-navbar-item')
                @include('layout.partials._clients-navbar-item')
                @include('layout.partials._my-products-navbar-item')
                @include('layout.partials._help-navbar-item')
            </ul>

            @include('layout.partials._email-navbar-dropdown')

        </div><!--/.nav-collapse -->
    </div>
</nav>

@yield('full-width')

<div class="container">
    @yield('content')
</div>


<script src="/js/vendor.js"></script>
@yield('scripts')

</body>

</html>