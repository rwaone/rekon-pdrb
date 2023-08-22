<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,400&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="{{ url('') }}/login-page/fonts/icomoon/style.css">

    <link rel="stylesheet" href="{{ url('') }}/login-page/css/owl.carousel.min.css">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="{{ url('') }}/login-page/css/bootstrap.min.css">

    <!-- Style -->
    <link rel="stylesheet" href="{{ url('') }}/login-page/css/style.css">
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <title>{{ config('app.name', 'Laravel') }}</title>
    <link rel="icon" href="{{ url('') }}/dist/img/karlota-logo.png">
</head>

<body>



    <div class="content">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <img src="{{ url('') }}/login-page/images/bg-1.png" alt="Image"
                        class="img-fluid">
                </div>
                <div class="col-md-6 contents">
                    <div class="row justify-content-center">
                        <div class="col-md-8">
                            <div class="mb-2">
                                <img src="{{ url('') }}/dist/img/karlota-logo-long.png" alt="Image"
                                    class="img-fluid">
                                {{-- <h4>Sign In</h4> --}}
                            </div>
                            <form method="POST" action="{{ route('login') }}">
                              @csrf
                                <div class="form-group first">
                                    <label for="username">Username</label>
                                    <input type="username" class="form-control" id="username" name="username">

                                </div>
                                <div class="form-group last mb-4">
                                    <label for="password">Password</label>
                                    <input type="password" class="form-control" id="password" name="password">

                                </div>

                                <div class="d-flex mb-5 align-items-center">
                                    <label class="control control--checkbox mb-0"><span class="caption">Remember
                                            me</span>
                                        <input type="checkbox" checked="checked" name="remember"/>
                                        <div class="control__indicator"></div>
                                    </label>
                                    <span class="ml-auto"><a href="#" class="forgot-pass">Forgot
                                            Password</a></span>
                                </div>

                                <input type="submit" value="Log In" class="btn btn-block btn-success">

                                {{-- <span class="d-block text-center my-4 text-muted">&mdash; or login with &mdash;</span>

                                <div class="text-center social-login">
                                    <a href="#" class="facebook">
                                        <span class="icon-facebook mr-3"></span>
                                    </a>
                                    <a href="#" class="twitter">
                                        <span class="icon-twitter mr-3"></span>
                                    </a>
                                    <a href="#" class="google">
                                        <span class="icon-google mr-3"></span>
                                    </a> --}}
                                </div>
                            </form>
                        </div>
                    </div>

                </div>

            </div>
        </div>
    </div>


    <script src="{{ url('') }}/plugins/jquery/jquery.min.js"></script>
    <script src="{{ url('') }}/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="{{ url('') }}/login-page/js/main.js"></script>
</body>

</html>
