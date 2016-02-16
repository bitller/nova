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
                <!---->

                <li>
                    <a id="dLabel" role="button" data-toggle="dropdown" data-target="#" href="/page.html">
                        <i class="glyphicon glyphicon-bell"></i>(3)
                    </a>

                    <ul class="dropdown-menu notifications" role="menu" aria-labelledby="dLabel">

                        <div class="notification-heading"><h4 class="menu-title">Notifications</h4><h4 class="menu-title pull-right">View all<i class="glyphicon glyphicon-circle-arrow-right"></i></h4>
                        </div>
                        <li class="divider"></li>
                        <div class="notifications-wrapper">
                            <a class="content" href="#">

                                <div class="notification-item">
                                    <h4 class="item-title">Evaluation Deadline 1 · day ago</h4>
                                    <p class="item-info">Marketing 101, Video Assignment</p>
                                </div>

                            </a>
                            <a class="content" href="#">
                                <div class="notification-item">
                                    <h4 class="item-title">Evaluation Deadline 1 · day ago</h4>
                                    <p class="item-info">Marketing 101, Video Assignment</p>
                                </div>
                            </a>
                            <a class="content" href="#">
                                <div class="notification-item">
                                    <h4 class="item-title">Evaluation Deadline 1 • day ago</h4>
                                    <p class="item-info">Marketing 101, Video Assignment</p>
                                </div>
                            </a>
                            <a class="content" href="#">
                                <div class="notification-item">
                                    <h4 class="item-title">Evaluation Deadline 1 • day ago</h4>
                                    <p class="item-info">Marketing 101, Video Assignment</p>
                                </div>

                            </a>
                            <a class="content" href="#">
                                <div class="notification-item">
                                    <h4 class="item-title">Evaluation Deadline 1 • day ago</h4>
                                    <p class="item-info">Marketing 101, Video Assignment</p>
                                </div>
                            </a>
                            <a class="content" href="#">
                                <div class="notification-item">
                                    <h4 class="item-title">Evaluation Deadline 1 • day ago</h4>
                                    <p class="item-info">Marketing 101, Video Assignment</p>
                                </div>
                            </a>

                        </div>
                        <li class="divider"></li>
                        <div class="notification-footer"><h4 class="menu-title">View all<i class="glyphicon glyphicon-circle-arrow-right"></i></h4></div>
                    </ul>
                </li>

                <!---->

                <li><a href="/paid-bills"><span class="glyphicon glyphicon-ok"></span>&nbsp;{{ trans('navbar.paid_bills') }}</a></li>
                <li><a href="/products"><span class="glyphicon glyphicon-th"></span>&nbsp;{{ trans('navbar.products') }}</a></li>
                <li><a href="/clients"><span class="glyphicon glyphicon-user"></span>&nbsp;{{ trans('navbar.clients') }}</a></li>
                <li><a href="/my-products"><span class="glyphicon glyphicon-th-list"></span>&nbsp;{{ trans('navbar.my_products') }}</a></li>
                <li><a href="/help-center"><span class="glyphicon glyphicon-question-sign"></span>&nbsp;{{ trans('navbar.help') }}</a></li>
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