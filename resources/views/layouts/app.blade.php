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
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('fontawesome/css/all.css') }}" rel="stylesheet">
    <link href="{{ asset('css/app.css') }}?v=1" rel="stylesheet">
    <link href="{{ asset('css/main.css') }}?v=7" rel="stylesheet">

</head>

<body>
    <div id="app">
        <div id="blackcontriner">
            <div class="container">
                <div class="top">
                    <div class="auth">
                        @guest
                            <a href="/login"><i class="fas fa-sign-in-alt"></i> Login</a>
                            <a href="/register"><i class="fas fa-user-plus"></i> Register</a>
                        @else
                            <a href="/user/orders"><i class="fas fa-table"></i> My Orders</a>
                            <a href="/user/setting"><i class="fas fa-users-cog"></i> Setting</a>
                            <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"><i class="fas fa-sign-out-alt"></i> Logout</a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                @csrf
                            </form>

                            @if(in_array(auth()->id(), config('app.adminID')))
                                <a href="/admin"><i class="fas fa-cog"></i> Admin Panel</a>
                            @endif
                        @endguest
                    </div>
                    <div class="cart">
                        @yield('cart')
                    </div>
                    <a href="/"><img src="{{ asset('images/logo.png') }}"></a>
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
                        <ul class="navbar-nav mx-auto">
                            <div class="loginMobile">
                                <li class="nav-item">
                                    <a class="nav-link" href="/login"><i class="fas fa-sign-in-alt"></i> LOGIN</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="/register"><i class="fas fa-user-plus"></i> REGISTER</a>
                                </li>
                            </div>
                            {{-- <li class="nav-item">
                                <a class="nav-link" href="/product?category=1"><i class="fas fa-star"></i> PROMO</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="/product?category=2"><i class="fas fa-cookie"></i> CHOCOLATE</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="/product?category=3"><i class="fas fa-glass-cheers"></i> BEVERAGES</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="/product?category=4"><i class="fab fa-nutritionix"></i> PILINUTS</a>
                            </li> --}}
                            @foreach ($categories as $category)
                                <li class="nav-item">
                                    <a class="nav-link" href="/product?category={{ $category->id }}"><i class="{{ $category->icon }}"></i> {{ $category->name }}</a>
                                </li>
                            @endforeach
                        </ul>

                    </div>

                </div>
            </nav>
        </div>

        <main class="py-4" style="min-height: 600px;">
            @yield('content')
        </main>

        <footer>
        <div id="footer">

        </div>
        </footer>
    </div>
</body>

</html>