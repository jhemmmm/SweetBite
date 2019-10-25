<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name') }} - Admin Panel</title>
    <link rel="dns-prefetch" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet" type="text/css">
    <link href="{{ asset('css/admin.css') }}" rel="stylesheet">
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
</head>
<body>
    <div id="app" class="page">
        <div class="page-main">
            <div class="header py-4">
                <div class="container">
                    <div class="d-flex">
                    <a class="header-brand" href="">
                        {{ config('app.name') }} Admin Panel
                    </a>
                    <div class="d-flex order-lg-2 ml-auto">
                        <div class="nav-item d-none d-md-flex">
                            <a class="btn btn-sm btn-outline-primary" href="{{ url('/') }}">Visit Homepage</a>
                        </div>
                        <div class="nav-item d-none d-md-flex">
                            <a class="btn btn-sm btn-outline-danger" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Logout</a>
                        </div>

                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                    </div>
                    <a href="#" class="header-toggler d-lg-none ml-3 ml-lg-0" data-toggle="collapse" data-target="#headerMenuCollapse">
                        <span class="header-toggler-icon"></span>
                    </a>
                    </div>
                </div>
            </div>
            <div class="header collapse d-lg-flex p-0" id="headerMenuCollapse">
                <div class="container">
                    <div class="row align-items-center">
                        <div class="col-lg order-lg-first">
                            <ul class="nav nav-tabs border-0 flex-column flex-lg-row">
                                <li class="nav-item">
                                    <a href="" class="nav-link"><i class="fa fa-home fa-fw"></i> Home</a>
                                </li>
                                <li class="nav-item dropdown">
                                    <a href="Javascript:void(0)" class="nav-link" data-toggle="dropdown"><i class="fa fa-users"></i> Products</a>
                                    <div class="dropdown-menu dropdown-menu-arrow">
                                        <a href="{{ route('admin.product.list') }}" class="dropdown-item ">View All</a>
                                        <a href="{{ route('admin.product.create') }}" class="dropdown-item ">Add New Product</a>
                                    </div>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('admin.order.list') }}" class="nav-link"><i class="fa fa-table fa-fw"></i> Order History</a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('admin.order.list') }}" class="nav-link"><i class="fa fa-file-invoice fa-fw"></i> Invoices</a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('admin.user.list') }}" class="nav-link"><i class="fa fa-users fa-fw"></i> Users</a>
                                </li>
                                {{-- <li class="nav-item dropdown">
                                    <a href="Javascript:void(0)" class="nav-link" data-toggle="dropdown"><i class="fa fa-users"></i> Users</a>
                                    <div class="dropdown-menu dropdown-menu-arrow">
                                        <a href="{{ route('admin.user.list') }}" class="dropdown-item ">View All</a>
                                        <a href="{{ route('admin.user.create') }}" class="dropdown-item ">Create</a>
                                    </div>
                                </li> --}}
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <main class="pt-5">
                <div class="container">
                    @yield('content')
                </div>
            </main>
            <footer class="container mt-5">
                <p>© {{ config('app.name') }} 2018</p>
            </footer>
        </div>
    </div>
    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>
</body>
</html>
