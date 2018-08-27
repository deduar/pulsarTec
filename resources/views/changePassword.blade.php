@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
    	@if($errors->any())
			<h4 style="text-align: center;">{{$errors->first()}}</h4>
		@endif
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">@lang('update.password')</div>

                <div class="panel-body">
                    <form class="form-horizontal" method="POST">
                        {{ csrf_field() }}

                        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                            <label for="name" class="col-md-4 control-label">@lang('update.actual_password')</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control" name="password" value="" required autofocus>

                                @if ($errors->has('password'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
						
						<hr style="width: 100%; color: black; height: 1px; background-color:black;" />

						<div class="form-group{{ $errors->has('new_password') ? ' has-error' : '' }}">
                            <label for="name" class="col-md-4 control-label">@lang('update.new_password')</label>

                            <div class="col-md-6">
                                <input id="new_password" type="password" class="form-control" name="new_password" value="" required autofocus>

                                @if ($errors->has('new_password'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('new_password') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('confirm_password') ? ' has-error' : '' }}">
                            <label for="name" class="col-md-4 control-label">@lang('update.confirm_password')</label>

                            <div class="col-md-6">
                                <input id="confir_password" type="password" class="form-control" name="confirm_password" value="" required autofocus>

                                @if ($errors->has('confirm_password'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('confirm_password') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <button type="submit" class="btn btn-primary" formaction={{ route('update_password') }}>
                                    @lang('register.update_password')
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection