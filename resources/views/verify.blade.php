@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Dashboard</div>

                <div class="panel-body">
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif
                    <h3>Firts verify your account, check your eMail for instructions</h3>
                    <a class="btn btn-link" href="{{ route('resend') }}">
                        Resend email to ability account?
                    </a>
                    <h4>{{ session('resend_message') }}</h4>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
