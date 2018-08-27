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
                    <h3>@lang('home.welcome_odoo')</h3>
                </div>
            </div>
            <a href="{{ route('pay_renew') }}">
                <button type="button" class="btn btn-success pull-right">{{trans('home.pay_renew')}}</button>
            </a>
        </div>
    </div>
</div>
@endsection
