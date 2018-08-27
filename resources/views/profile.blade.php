@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">@lang('update.title')</div>

                <div class="panel-body">
                    <!--form class="form-horizontal" method="POST" action="{{ route('register') }}"-->
                    <form class="form-horizontal" method="POST">
                        {{ csrf_field() }}

                        <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                            <label for="name" class="col-md-4 control-label">@lang('update.name')</label>

                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control" name="name" value="{{ $user['name'] }}" required autofocus>

                                @if ($errors->has('name'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                            <label for="email" class="col-md-4 control-label">@lang('update.email')</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control" name="email" value="{{ $user['email'] }}" disabled>

                                @if ($errors->has('email'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('address') ? ' has-error' : '' }}">
                            <label for="name" class="col-md-4 control-label">@lang('update.address')</label>

                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control" name="address" value="{{ $user['address'] }}" required autofocus>

                                @if ($errors->has('address'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('address') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('language') ? ' has-error' : '' }}">
                            <label for="name" class="col-md-4 control-label">@lang('update.language')</label>
                            <div class="col-md-6">
                                @if ($errors->has('language'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('language') }}</strong>
                                    </span>
                                @endif
                                <label class="container">
                                    <img class="img-rounded" src={{ asset('images/es.png') }} alt="España">
                                    <input type="radio" name="language" @if ($user->language=="es") checked="checked" @endif value="es" >
                                    <span class="checkmark" ></span>
                                </label>

                                <label class="container">
                                    <img class="img-rounded" src={{ asset('images/us.png') }} alt="English">
                                    <input type="radio" name="language" @if ($user->language=="en") checked="checked" @endif value="en">
                                    <span class="checkmark"></span>
                                </label>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <button type="submit" class="btn btn-primary" formaction={{ route('update_profile') }}>
                                    @lang('register.sent')
                                </button>
                                <!--button type="submit" class="btn btn-primary" formaction={{ route('change_password') }}>
                                    @lang('register.update_password')
                                </button-->
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
