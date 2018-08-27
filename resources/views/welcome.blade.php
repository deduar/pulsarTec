<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/pulsar.css') }}" rel="stylesheet">
</head>
<body>
    <div id="app">
        <nav class="navbar navbar-default navbar-static-top">
            <div class="container">
                <div class="navbar-header">

                    <!-- Collapsed Hamburger -->
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-navbar-collapse">
                        <span class="sr-only">Toggle Navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>

                    <!-- Branding Image -->
                    <a class="navbar-brand" href="{{ url('/') }}">
                        {{-- config('app.name', 'Laravel') --}}
                        <a class="navbar-brand logo" href="{{ url('/') }}">
                            <img src={{ asset('images/logo.png') }} alt="Pulsar Tec">
                        </a>
                    </a>
                </div>

                <div class="collapse navbar-collapse" id="app-navbar-collapse">
                    <!-- Right Side Of Navbar -->
                    <ul class="nav navbar-nav navbar-right">
                        <!-- Authentication Links -->
                        @if (Auth::guest())
                            {{--!! Session::get('_locale') !!--}}
                            <div class="col-md-4"><a href="{{ route('login') }}">@lang('welcome.login')</a></div>
                            <div class="col-md-4"><a href="{{ route('register') }}">@lang('welcome.register')</a></div>
                            <div class="col-md-1"><a href="{{ route('setLocale','es') }}"><img class="img-rounded" style="width: 30px; height: 20px;" src={{ asset('images/es.png') }} alt="Español"></a></div>
                            <div class="col-md-1"><a href="{{ route('setLocale','en') }}"><img class="img-rounded" style="width: 30px; height: 20px;" src={{ asset('images/us.png') }} alt="English"></a></div>
                        @else
                            @if (Auth::user())
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                                    {{ Auth::user()->name }} <span class="caret"></span>
                                </a>

                                <ul class="dropdown-menu" role="menu">
                                    <li>
                                        <a href="{{ route('logout') }}"
                                            onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                            @lang('welcome.logout')
                                        </a>

                                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                            {{ csrf_field() }}
                                        </form>
                                    </li>
                                    <li>
                                        <a href="{{ route('edit_profile') }}">@lang('welcome.edit_profile')</a>
                                    </li>
                                    <li>
                                        <a href="{{ route('change_password') }}">@lang('welcome.change_password')</a>
                                    </li>
                                </ul>
                            </li>
                            <li><a href="{{ route('setLocale','es') }}"><img class="img-rounded" src={{ asset('images/es.png') }} alt="Español"></a></li>
                            <li><a href="{{ route('setLocale','en') }}"><img class="img-rounded" src={{ asset('images/us.png') }} alt="English"></a></li>
                            @endif
                        @endif
                    </ul>
                </div>

            </div>
        </nav>

        @yield('content')
        <div class="panel panel-default" style="height: 180px; width: 480px; margin: auto;">
        <div class="content">
            <h1 style="background: #fff, border: 1px solid #000; text-align: center; margin-top: 50px; font-weight: bold;">PulsarTec</h1>
            <h3 style="text-align: center; margin-top: 0px;">Tecnologies</h3>
        </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}"></script>
</body>
</html>
