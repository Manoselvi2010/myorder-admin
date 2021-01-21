<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Admin Panel | {{ config('app.name') }} </title>
    <!-- favicon !-->
    <link rel="apple-touch-icon" sizes="57x57" href="{{ url('favicon/favicon.png') }}">
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="msapplication-TileImage" content="{{ url('favicon/ms-icon-144x144.png') }}">
    <meta name="theme-color" content="#ffffff">
    <!-- Vendor styles -->
    <link rel="stylesheet" href="{{ url('adminpanel/css/material-design-iconic-font.min.css') }}">
    <link rel="stylesheet" href="{{ url('adminpanel/css/animate.min.css') }}">
    <!-- App styles -->
    <link rel="stylesheet" href="{{ url('adminpanel/css/app.min.css') }}">
</head>
<body data-sa-theme="7">
    <!-- Login -->
    <div class="login">
        <div class="login__block active" id="l-login">
            <img src="{{ url('/images/logo.png') }}" class="logo-text" />
            <div class="login__block__header">
                <i class="zmdi zmdi-account-circle"></i>
                Admin Panel                 
            </div>
            <div class="login__block__body">
                <form class="form-horizontal" role="form" method="POST" action="{{ url('login') }}" autocomplete="nope">
                    {{ csrf_field() }}
                    <div class="form-group">
                        <input type="text" class="form-control text-center" name="email" value="{{ old('email') }}" placeholder="Email">
                        @if ($errors->has('email'))
                        <span class="help-block">
                            <strong>{{ $errors->first('email') }}</strong>
                        </span>
                        @endif
                    </div>
                    <div class="form-group">
                        <input type="password" name="password" class="form-control text-center" placeholder="Password">
                        @if ($errors->has('password'))
                        <span class="help-block">
                            <strong>{{ $errors->first('password') }}</strong>
                        </span>
                        @endif
                    </div>
                    @if(session('status'))
                        <div class="alert alert-danger" role="alert">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        {{ session('status') }}
                        </div>
                    @endif 
                    <button type="submit" name="secure-adminlogin" class="btn btn--icon login__block__btn"><i class="zmdi zmdi-long-arrow-right"></i></button>
                </form>
            </div>
        </div>
    </div>
    <script src="{{ url('adminpanel/js/jquery.min.js') }}"></script>
    <script src="{{ url('adminpanel/js/popper.min.js') }}"></script>
    <script src="{{ url('adminpanel/js/bootstrap.min.js') }}"></script>
    <script src='https://www.google.com/recaptcha/api.js'></script>
    <script src="{{ url('adminpanel/js/app.min.js') }}"></script>
</body>
</html>