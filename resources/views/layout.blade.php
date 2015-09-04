<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta id="token" content="{{ csrf_token() }}">
    <title>Nova</title>
    {{--<link rel="stylesheet" href="http://css-spinners.com/css/spinner/plus.css" type="text/css">--}}
    <link rel="stylesheet" href="/css/app.css">
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
            <a class="navbar-brand" href="/bills">Nova</a>
        </div>
        <div id="navbar" class="navbar-collapse collapse">
            <ul class="nav navbar-nav">
                <li><a href="/products">{{ trans('navbar.products') }}</a></li>
                <li><a href="/clients">{{ trans('navbar.clients') }}</a></li>
                <li><a href="/my-products">{{ trans('navbar.my_products') }}</a></li>
            </ul>
            <ul class="nav navbar-nav navbar-right">
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">{{ Auth::user()->email }}<span class="caret"></span></a>
                    <ul class="dropdown-menu">
                        <li><a href="/settings">Setari</a></li>
                        <li><a href="/statistics">Statistici</a></li>
                        <li><a href="/about">Despre Nova</a></li>
                        <li role="separator" class="divider"></li>
                        <li><a href="/logout">Deconectare</a></li>
                    </ul>
                </li>
            </ul>
        </div><!--/.nav-collapse -->
    </div>
</nav>

<div class="container">
    @yield('content')
</div>


<script src="/js/vendor.js"></script>
@yield('scripts')

</body>

</html>