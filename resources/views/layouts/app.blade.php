<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('fontawesome/css/all.css') }}" rel="stylesheet">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/main.css') }}" rel="stylesheet">
</head>

<body>
    <div id="app">
        <div id="blackcontriner">
            <div class="container">
                <div class="top">
                    <div class="auth">
                        <a href="#"><i class="fas fa-sign-in-alt"></i> Login</a>
                        <a href="#"><i class="fas fa-user-plus"></i> Register</a>
                    </div>
                    <img src="{{ asset('images/logo.png') }}">
                </div>
            </div>
            <nav class="navbar navbar-expand-md">
                <div class="container">
                    <button class="navbar-toggler" type="button" data-toggle="collapse"
                        data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                        aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                        <i class="fas fa-bars" style="color: #fff"></i>
                    </button>

                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <!-- Left Side Of Navbar -->
                        <ul class="navbar-nav mx-auto">
                            <div class="loginMobile">
                                <li class="nav-item">
                                    <a class="nav-link" href="#"><i class="fas fa-sign-in-alt"></i> LOGIN</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="#"><i class="fas fa-user-plus"></i> REGISTER</a>
                                </li>
                            </div>
                            <li class="nav-item">
                                <a class="nav-link" href="#"><i class="fas fa-pizza-slice"></i> PROMO</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#"><i class="fas fa-pizza-slice"></i> PIZZA</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#"><i class="fas fa-pizza-slice"></i> PASTA</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#"><i class="fas fa-pizza-slice"></i> CHICKEN</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#"><i class="fas fa-pizza-slice"></i> SIDES</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#"><i class="fas fa-pizza-slice"></i> COUPONS</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#"><i class="fas fa-pizza-slice"></i> PIZZA</a>
                            </li>
                        </ul>

                    </div>

                </div>
            </nav>
        </div>

        <main class="py-4">
            @yield('content')
        </main>
    </div>
</body>

</html>
