@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">@lang('home.dashboard')</div>

                <div class="panel-body">
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif
                    <h4>@lang('home.welcome_message')</h4>
                    <a class="btn btn-link" href="{{ route('resend') }}">
                        @lang('home.resend_email')
                    </a>
                    <h4>{{ session('resend_message') }}</h4>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
