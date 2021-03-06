<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>PulsarTec</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">

        <!-- Styles -->
        <style>
            html, body {
                background-color: #fff;
                color: #636b6f;
                font-family: 'Raleway', sans-serif;
                font-weight: 100;
                height: 100vh;
                margin: 0;
            }

            .full-height {
                height: 100vh;
            }

            .flex-center {
                align-items: center;
                display: flex;
                justify-content: center;
            }

            .position-ref {
                position: relative;
            }

            .top-right {
                position: absolute;
                right: 10px;
                top: 18px;
            }

            .content {
                text-align: center;
            }

            .title {
                font-size: 84px;
            }

            .links > a {
                color: #636b6f;
                padding: 0 12px;
                font-size: 12px;
                font-weight: 600;
                letter-spacing: .1rem;
                text-decoration: none;
                text-transform: uppercase;
            }

            .m-b-md {
                margin-bottom: 30px;
            }

            a.logo {
                padding-right: 400px;
            }

            .img-rounded{
                border-radius: 5px;
            }

            a.flag{
                padding-left: 5px;
                padding-right: 5px;
            }


        </style>
    </head>
    <body>
        <div class="flex-center position-ref full-height">
            @if (Route::has('login'))
                <div class="top-right links">
                    @if (Auth::check())
                        <a href="{{ url('/home') }}">Odoo</a>
                    @else
                        <a class="logo" href="{{ url('/') }}">
                            <img src={{ asset('images/logo.png') }} alt="Pulsar Tec">
                        </a>
                        <a href="{{ url('/login') }}">@lang('welcome.login')</a>
                        <a href="{{ url('/register') }}">@lang('welcome.register')</a>
                        <a class="flag" href="?_locale=es"><img class="img-rounded" src={{ asset('images/es.png') }} alt="España"></a>
                        <a class="flag" href="?_locale=en"><img class="img-rounded" src={{ asset('images/us.png') }} alt="English"></a>
                    @endif
                </div>
            @endif

            <div class="content">
                <div class="title m-b-md">
                    PulsarTec
                </div>
            </div>
        </div>
    </body>
</html>
