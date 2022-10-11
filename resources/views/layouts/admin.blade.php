<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="{{ mix('js/app.js') }}" defer></script>
    <script src="{{ asset('js/tinymce/tinymce.min.js') }}" defer></script>


    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.2/css/all.min.css" integrity="sha512-1sCRPdkRXhBV2PBLUdRb4tMg1w2YPf37qatUFeS7zlBy7jJI8Lf4VHwWfZZfpXtYSLy85pkm9GaYVYMfw5BC1A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ mix('css/app.css') }}" rel="stylesheet">
</head>
<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                    {{ config('app.name', 'Laravel') }}
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav me-auto">

                        <li class="nav-item"><a href="{{ route('home') }}" class="nav-link @if(Route::is('home')) active @endif"><i class="fa fa-fw fa-dashboard"></i> Dashboard</a></li>
                        <li class="nav-item"><a href="{{ route('users.index') }}" class="nav-link @if(Route::is('users.*')) active @endif"><i class="fa fa-fw fa-user-nurse"></i> Operatori</a></li>
                        <li class="nav-item"><a href="{{ route('companies.index') }}" class="nav-link @if(Route::is('companies.*')) active @endif"><i class="fa fa-fw fa-industry"></i> Aziende</a></li>
                        <li class="nav-item"><a href="{{ route('customers.index') }}" class="nav-link @if(Route::is('customers.*')) active @endif"><i class="fa fa-fw fa-user"></i> Clienti</a></li>
                        <li class="nav-item"><a href="{{ route('categories.index') }}" class="nav-link @if(Route::is('categories.*')) active @endif"><i class="fa fa-fw fa-folder-blank"></i> Categorie</a></li>
                        <li class="nav-item"><a href="{{ route('tickets.index') }}" class="nav-link @if(Route::is('tickets.*')) active @endif"><i class="fa fa-fw fa-ticket-simple"></i> Ticket</a></li>
                        <li class="nav-item"><a href="{{ route('tasks.index') }}" class="nav-link @if(Route::is('tasks.*')) active @endif"><i class="fa fa-fw fa-tasks"></i> Attività</a></li>
                        <li class="nav-item"><a href="{{ route('reports.index') }}" class="nav-link @if(Route::is('reports.*')) active @endif"><i class="fa fa-fw fa-chart-area"></i> Report</a></li>

                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ms-auto">
                        <!-- Authentication Links -->
                        @guest
                            @if (Route::has('login'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                                </li>
                            @endif

                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                                </li>
                            @endif
                        @else
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }}
                                </a>

                                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        <main class="py-4">
            @yield('content')
        </main>
    </div>
</body>

@stack('after_scripts')
</html>
