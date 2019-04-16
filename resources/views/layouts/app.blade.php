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
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet" type="text/css">

    <!-- Styles -->
    @yield('stylesheets')
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light navbar-laravel">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                    {{ config('app.name', 'Laravel') }}
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>
                @auth
                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <ul class="navbar-nav">
                            <li class="nav-item active">
                                <a class="nav-link" href="{{ route('home') }}">Inicio <span class="sr-only">(current)</span></a>
                            </li>
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    Contratos
                                </a>
                                <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                                    @can('listContracts')
                                        <a class="dropdown-item" href="{{ route('contract.index') }}">Listar</a>
                                    @endcan

                                    @can('viewContract')
                                        <!--<a class="dropdown-item" href="{{ route('contract.index') }}">Mostrar<sup class="text-danger"> Pendiente</sup></a>-->
                                    @endcan

                                    @can('newContract')
                                        <a class="dropdown-item" href="{{ route('contract.create') }}">Agregar</a>
                                    @endcan
                                </div>
                            </li>
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    Estimaciones
                                </a>
                                <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                                    @can('listEstimates')
                                        <a class="dropdown-item" href="{{ route('estimate.index') }}">Listar</a>
                                    @endcan

                                    @can('viewEstimate')
                                    <!--<a class="dropdown-item" href="{{ route('estimate.index') }}">Mostrar<sup class="text-danger"> Pendiente</sup></a>-->
                                    @endcan

                                    @can('newEstimate')
                                        <a class="dropdown-item" href="{{ route('estimate.create') }}">Agregar</a>
                                    @endcan

                                    @can('monitoringEstimates')
                                        <a class="dropdown-item" href="{{ route('monitoring.index') }}">Monitorear Estimaciones</a>
                                    @endcan

                                </div>
                            </li>
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    Catálogos
                                </a>
                                <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                                    @can('listConcepts')
                                        <a class="dropdown-item" href="{{ route('concept.index') }}">Listar</a>
                                    @endcan

                                    @can('viewConcept')
                                    <!--<a class="dropdown-item" href="{{ route('concept.index') }}">Mostrar<sup class="text-danger"> Pendiente</sup></a>-->
                                    @endcan

                                    @can('newConcept')
                                            <a class="dropdown-item" href="{{ route('concept.create') }}">Agregar concepto</a>
                                    @endcan
                                </div>
                            </li>
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    Frentes
                                </a>
                                <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                                    @can('listLocations')
                                        <a class="dropdown-item" href="{{ route('location.index') }}">Listar</a>
                                    @endcan

                                    @can('viewLocation')
                                    <!--<a class="dropdown-item" href="{{ route('location.index') }}">Mostrar<sup class="text-danger"> Pendiente</sup></a>-->
                                    @endcan

                                    @can('newLocation')
                                        <a class="dropdown-item" href="#" data-toggle="modal" data-target="#addLocation">Agregar frente</a>
                                    @endcan
                                </div>
                            </li>
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    Empresas
                                </a>
                                <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                                    @can('listCompanies')
                                        <a class="dropdown-item" href="{{ route('contract.index') }}">Listar<sup class="text-danger"> Pendiente</sup></a>
                                    @endcan

                                    @can('viewCompany')
                                        <a class="dropdown-item" href="{{ route('contract.index') }}">Mostrar<sup class="text-danger"> Pendiente</sup></a>
                                    @endcan

                                    @can('newCompany')
                                        <a class="dropdown-item" href="{{ route('contract.index') }}">Agregar<sup class="text-danger"> Pendiente</sup></a>
                                    @endcan
                                </div>
                            </li>
                        </ul>
                    </div>
                @endauth
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav mr-auto">

                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <!-- Authentication Links -->
                        @guest
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                            </li>
                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                                </li>
                            @endif
                        @else
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }} <span class="caret"></span>
                                </a>

                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        <main class="py-3">
            @include('partials.alerts')
            @yield('content')
        </main>
        <footer class="footer">
            <div class="container">
                <p class="text-center">
                    <span class="float-right text-muted"><a href="#">Back to top</a></span>
                    <span class="text-muted">© 2017-2018 ADX Software SA de CV. · <a href="#">Privacy</a> · <a href="#">Terms</a></span>
                </p>
            </div>
        </footer>
    </div>
    @yield('scripts')
</body>
</html>
