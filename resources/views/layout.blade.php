<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta id="token" content="{{ csrf_token() }}">
    <title>Nova</title>
    <link rel="stylesheet" href="/css/app.css">
    <link href='https://fonts.googleapis.com/css?family=Quicksand' rel='stylesheet' type='text/css'>
    @yield('fonts')
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
                <li><a href="/paid-bills"><span class="glyphicon glyphicon-ok"></span>&nbsp;{{ trans('navbar.paid_bills') }}</a></li>
                <li><a href="/products"><span class="glyphicon glyphicon-th"></span>&nbsp;{{ trans('navbar.products') }}</a></li>
                <li><a href="/clients"><span class="glyphicon glyphicon-user"></span>&nbsp;{{ trans('navbar.clients') }}</a></li>
                <li><a href="/my-products"><span class="glyphicon glyphicon-th-list"></span>&nbsp;{{ trans('navbar.my_products') }}</a></li>
                <li><a href="/help-center"><span class="glyphicon glyphicon-question-sign"></span>&nbsp;{{ trans('navbar.help') }}</a></li>
            </ul>

            <!-- BEGIN Search bar -->
            <form class="navbar-form navbar-left" role="search" id="search-bar-box">
                <div class="form-group has-feedback">
                    <input type="text" id="search-bar" class="form-control flat-input" placeholder="{{ trans('header.search_by_code_or_name') }}" />
                    <i class="glyphicon glyphicon-search form-control-feedback icon-color search-icon"></i>
                    <i class="glyphicon glyphicon-refresh glyphicon-spin form-control-feedback icon-color loading-icon"></i>
                </div>
            </form>
            <!-- END Search bar -->

            <ul class="nav navbar-nav navbar-right">
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><span id="user-email">{{ Auth::user()->email }}</span><span class="caret"></span></a>
                    <ul class="dropdown-menu">
                        @if ($showAdminCenter)
                            <li><a href="/admin-center"><span class="glyphicon glyphicon-wrench icon-color">&nbsp;</span>{{ trans('header.admin_center') }}</a></li>
                            <li role="separator" class="divider"></li>
                        @endif
                        <li><a href="/settings"><span class="glyphicon glyphicon-cog icon-color">&nbsp;</span>{{ trans('header.settings') }}</a></li>
                        <li><a href="/statistics"><span class="glyphicon glyphicon-stats icon-color">&nbsp;</span>{{ trans('header.statistics') }}</a></li>
                        <li><a href="/about"><span class="glyphicon glyphicon-info-sign icon-color">&nbsp;</span>{{ trans('header.about') }}</a></li>
                        <li role="separator" class="divider"></li>
                        <li><a href="/logout"><span class="glyphicon glyphicon-off icon-color">&nbsp;</span>{{ trans('header.logout') }}</a></li>
                    </ul>
                </li>
            </ul>
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