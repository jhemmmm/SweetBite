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
                    {{-- <div class="auth">
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
                            <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown"
                                aria-haspopup="true" aria-expanded="false" v-pre>
                                Hi, {{ Auth::user()->name }} <span class="caret"></span>
                            </a>

                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item" href="/user/orders"><i class="fas fa-table"></i> My Orders</a>
                                <a class="dropdown-item" href="/user/setting"><i class="fas fa-users-cog"></i> Setting</a>
                                <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                    <i class="fas fa-sign-out-alt"></i> {{ __('Logout') }}
                                </a>
                                @if(in_array(auth()->id(), config('app.adminID')))
                                    <a class="dropdown-item" href="/admin"><i class="fas fa-cog"></i> Admin Panel</a>
                                @endif

                            </div>

                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                @csrf
                            </form>
                        @endguest
                    </div> --}}
                    <div class="cart">
                        <a href="/cart"><i class="fas fa-shopping-cart"></i> ({{ (isset($cart_count)) ? $cart_count : 0 }})</a>
                    </div>
                    <a href="/"><img class="mb-3" src="{{ asset('images/logo.png') }}"></a>
                </div>
            </div>
            <nav class="navbar navbar-expand-sm">
                    <div class="container">
                        {{-- <a class="navbar-brand" href="#">Navbar</a> --}}
                        <button class="navbar-toggler d-lg-none" type="button" data-toggle="collapse" data-target="#collapsibleNavId" aria-controls="collapsibleNavId"
                            aria-expanded="false" aria-label="Toggle navigation">
                            <span class="navbar-toggler-icon"></span>
                        </button>
                        <div class="collapse navbar-collapse" id="collapsibleNavId">
                            <ul class="navbar-nav mr-auto mt-2 mt-lg-0">
                                <li class="nav-item active">
                                    <a class="nav-link" href="/">
                                        <i class="fa fa-home" aria-hidden="true"></i>
                                        Home
                                    </a>
                                </li>
                                <li class="nav-item">
                                    @php
                                        $category = $categories->where('name', 'Promo')->first()
                                    @endphp

                                    <a class="nav-link" href="/product?category={{ $category ? $category->id : 1 }}">
                                        <i class="fa fa-star" aria-hidden="true"></i>
                                        Promo
                                    </a>
                                </li>
                                <li class="nav-item dropdown">
                                    <a class="nav-link dropdown-toggle" href="#" id="dropdownId" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <i class="fa fa-align-justify" aria-hidden="true"></i>
                                        Products
                                    </a>
                                    <div class="dropdown-menu" aria-labelledby="dropdownId">
                                        @foreach ($categories->where('name', '!=', 'Promo') as $category)
                                            <a class="dropdown-item" href="/product?category={{ $category->id }}">{{ $category->name }}</a>
                                        @endforeach
                                    </div>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="/about">
                                        <i class="fa fa-address-book" aria-hidden="true"></i>
                                        About us
                                    </a>
                                </li>
                            </ul>
                            <ul class="navbar-nav ml-auto">
                                @guest
                                <li class="nav-item">
                                    <a class="nav-link" href="/login"><i class="fas fa-sign-in-alt"></i> Login</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="/register"><i class="fas fa-user-plus"></i> Register</a>
                                </li>
                                @else
                                <li class="nav-item dropdown">
                                    <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                        Hi, {{ Auth::user()->name }} <span class="caret"></span>
                                    </a>

                                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                        <a class="dropdown-item" href="/user/orders"><i class="fas fa-table"></i> My Orders</a>
                                        <a class="dropdown-item" href="/user/setting"><i class="fas fa-users-cog"></i> Setting</a>
                                        <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                            <i class="fas fa-sign-out-alt"></i> {{ __('Logout') }}
                                        </a>
                                        @if(in_array(auth()->id(), config('app.adminID')))
                                            <a class="dropdown-item" href="/admin"><i class="fas fa-cog"></i> Admin Panel</a>
                                        @endif

                                    </div>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        @csrf
                                    </form>
                                </li>
                                @endguest
                            </ul>
                        </div>
                    </div>
                </nav>
            </div>

        <main class="py-4" style="min-height: 600px;">
            <div class="container">
                <div class="row">
                    <div class="col-md-4">
                        <div class="list-group">
                            <a href="{{ route('user.setting') }}" class="list-group-item list-group-item-action {{ Route::currentRouteName() == 'user.setting' ? 'active' : '' }}">Setting</a>
                            <a href="{{ route('user.addresses') }}" class="list-group-item list-group-item-action {{ in_array(Route::currentRouteName(), [
                                'user.addresses',
                                'user.addresses.create',
                                'user.addresses.edit',
                            ]) ? 'active' : '' }}">Addresses</a>
                            <a href="{{ route('user.order.list') }}" class="list-group-item list-group-item-action {{ in_array(Route::currentRouteName(), [
                                'user.order.list',
                                'user.order.view',
                            ]) ? 'active' : '' }}">Order History</a>
                        </div>
                    </div>
                    <div class="col-md-8">
                        @yield('content')
                    </div>
                </div>
            </div>
        </main>

        <section id="footer">
            <div class="container">
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12 mt-2 mt-sm-2 text-center text-white">
                        <ul class="list-inline">
                            <li class="list-inline-item">
                                <a href="/">Home</a>
                            </li>
                            <li class="list-inline-item">
                                <a href="/about">About Us</a>
                            </li>
                            <li class="list-inline-item">
                                <a href="/cart">Cart</a>
                            </li>
                        </ul>
                        <p class="h6">&copy All right Reversed.<a class="text-green ml-2" href="/" target="_blank">SweetBites</a></p>
                    </div>
                    </hr>
                </div>
            </div>
        </section>
    </div>
</body>

</html>
