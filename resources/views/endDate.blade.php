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
                    <h3>@lang('home.end_date')</h3>
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-md-4">
                                @if (Lang::locale() == "en")
                                    <a class="btn btn-default" href="{{ route('pay',['amt'=>1,'lang'=>'en']) }}" role="button">
                                @else
                                    <a class="btn btn-default" href="{{ route('pay',['amt'=>1,'lang'=>'es']) }}" role="button">
                                @endif
                                    <p>@lang('endDate.basic')</p>
                                    <p>@lang('endDate.amt_Basic') @lang('endDate.currency')</p>
                                </a>
                            </div>
                            <div class="col-md-4">
                                @if (Lang::locale() == "en")
                                    <a class="btn btn-default" href="{{ route('pay',['amount'=>2,'lang'=>'en']) }}" role="button">
                                @else
                                    <a class="btn btn-default" href="{{ route('pay',['amount'=>2,'lang'=>'es']) }}" role="button">
                                @endif
                                    <p>@lang('endDate.silver')</p>
                                    <p>@lang('endDate.amt_Silver') @lang('endDate.currency')</p>
                                </a>
                            </div>
                            <div class="col-md-4">
                                @if (Lang::locale() == "en")
                                    <a class="btn btn-default" href="{{ route('pay',['amount'=>3,'lang'=>'en']) }}" role="button">
                                @else
                                    <a class="btn btn-default" href="{{ route('pay',['amount'=>3,'lang'=>'es']) }}" role="button">
                                @endif
                                    <p>@lang('endDate.premium')</p>
                                    <p>@lang('endDate.amt_Premium') @lang('endDate.currency')</p>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
