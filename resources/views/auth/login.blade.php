<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Conecteaza-te - Nova</title>
    <link rel="stylesheet" href="/css/app.css">
</head>
<body id="login-page">
<div class="container">

    <div class="row register-button">
        {{--<div class="register-button">--}}
            <a href="/register"><button class="btn btn-danger pull-right">{{ Lang::get('login.register_button') }}</button></a>
        {{--</div>--}}
    </div>

    <div class="row">
        <!-- BEGIN Login form -->
        <form name="login" method="post" action="{{ url('/login') }}" class="col-md-4 col-md-offset-4 login-form">

            <!-- BEGIN Logo -->
            <div class="login-logo">
                <a href="/"><h2 class="text-center">Nova</h2></a>
            </div>
            <!-- END Logo -->

            <?php $error = ''; ?>

            @foreach ($errors->all() as $errorMessage)
                <?php
                    $error = $errorMessage;
                    break;
                ?>
            @endforeach

            @if (session('error'))
                <?php $error = session('error'); ?>
            @endif

            @if ($error)
                <div class="alert alert-danger">{{ $error }}</div>
            @endif

            <!-- BEGIN Email input -->
            <div class="form-group">
                <input type="text" name="email" class="form-control" placeholder="{{ Lang::get('login.email_placeholder') }}" />
            </div>
            <!-- END Email input -->

            <!-- BEGIN Password input -->
            <div class="form-group">
                <input type="password" name="password" class="form-control" placeholder="{{ Lang::get('login.password_placeholder') }}" />
            </div>
            <!-- END Password input -->

            <input type="hidden" name="_token" value="{{ csrf_token() }}">

            <input type="submit" class="btn btn-primary btn-block" value="{{ Lang::get('common.login_button') }}">
        </form>
        <!-- END Login form -->
    </div>

    <div class="row forgot-password">
        <a href="/recover"><p class="text-center">{{ Lang::get('login.forgot_password') }}</p></a>
    </div>

</div>
</body>
</html>