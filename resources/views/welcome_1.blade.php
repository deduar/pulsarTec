<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>PulsarTec</title>

        <!-- Styles -->
        <style>
            html, body {
                background-color: #fff !important;
                color: #636b6f;
                font-family: 'Raleway', sans-serif;
                font-weight: 100;
                height: 100vh;
                margin: 0;
            }
        </style>

        {!! Html::style('assets/css/bootstrap.css') !!}
        {!! Html::style('assets/css/app.css') !!}
        {!! Html::style('assets/css/pulsar.css') !!}

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Lato:400,700" rel="stylesheet">
        <link rel="shortcut icon" type="image/x-icon" href="{{asset('assets/images/Favicon.png')}}">
        <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">
    
    </head>
    <body>
      <div class="content">
          <dir class="row">
              @if (Route::has('login'))
                  @if (Auth::check())
                      <a href="{{ url('/home') }}">Odoo</a>
                  @else
                      <dir class="col-md-4">
                          <a href="{{ url('/') }}">
                              <img src={{ asset('images/logo.png') }} alt="Pulsar Tec">
                          </a>
                      </dir>
                      <dir class="col-md-8">                            
                          <a href="{{ url('/login') }}">@lang('welcome.login')</a>
                          <a href="{{ url('/register') }}">@lang('welcome.register')</a>
                          <!--li><a href="{{ route('setLocale',array('locale'=>'es')) }}"><img class="img-rounded" src={{ asset('images/es.png') }} alt="Español"></a></li>
                          <li><a href="{{ route('setLocale',array('locale'=>'en')) }}"><img class="img-rounded" src={{ asset('images/us.png') }} alt="English"></a></li-->
                          <!--a href="?_locale=es"><img class="img-rounded" src={{ asset('images/es.png') }} alt="España"></a>
                          <a href="?_locale=en"><img class="img-rounded" src={{ asset('images/us.png') }} alt="English"></a-->

                          <li style="margin-top: 15px;"><a href="{{ route('setLocale','es') }}"><img class="img-rounded" src={{ asset('assets/images/es.png') }} alt="Español"></a></li>
                          <li style="margin-top: 15px;"><a href="{{ route('setLocale','en') }}"><img class="img-rounded" src={{ asset('assets/images/us.png') }} alt="English"></a></li>
                      </dir>
                  @endif
              @endif
          </dir>
          <div class="row">
              <div class="title m-b-md">
                  PulsarTec
              </div>
          </div>
      </div>
    </body>
</html>
