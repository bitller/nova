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
            <a href="/register"><button class="btn btn-danger pull-right">Creaza cont</button></a>
        {{--</div>--}}
    </div>

    <div class="row">
        <!-- BEGIN Login form -->
        <form class="col-md-4 col-md-offset-4 login-form">

            <!-- BEGIN Logo -->
            <div class="login-logo">
                <a href="/"><h2 class="text-center">Nova</h2></a>
            </div>
            <!-- END Logo -->

            <!-- BEGIN Email input -->
            <div class="form-group">
                <input type="text" class="form-control" placeholder="Email" />
            </div>
            <!-- END Email input -->

            <!-- BEGIN Password input -->
            <div class="form-group">
                <input type="password" class="form-control" placeholder="Password" />
            </div>
            <!-- END Password input -->

            <input type="submit" class="btn btn-primary btn-block" value="Conecteaza-te">
        </form>
        <!-- END Login form -->
    </div>

    <div class="row forgot-password">
        <a href="/recover"><p class="text-center">Ai uitat parola?</p></a>
    </div>

</div>
</body>
</html>