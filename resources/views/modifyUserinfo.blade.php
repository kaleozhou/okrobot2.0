@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <span class="lead">修改信息</span>
                </div>
                <div class="panel-body">
                    <form class="form-horizontal" role="form" method="POST" action="{{ url('/modifyUserinfo') }}">
                        {{ csrf_field() }}
                        <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                            <label for="name" class="col-md-4 control-label">用户名</label>
                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control" name="name" value="{{ $user->name }}" disabled>
                                @if ($errors->has('name'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('name') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                            <label for="email" class="col-md-4 control-label">邮箱</label>
                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control" name="email" value="{{ $user->email }}" disabled>
                                @if ($errors->has('email'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('email') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group{{ $errors->has('api_key') ? ' has-error' : '' }}">
                            <label for="api_key" class="col-md-4 control-label">APIKEY</label>
                            <div class="col-md-6">
                                <input id="api_key" type="text" class="form-control" name="api_key" value="{{$user->api_key}}" required>
                            </div>
                            @if ($errors->has('api_key'))
                            <span class="help-block">
                                <strong>{{ $errors->first('api_key') }}</strong>
                            </span>
                            @endif
                        </div>
                        <div class="form-group{{ $errors->has('secret_key') ? ' has-error' : '' }}">
                            <label for="secret_key" class="col-md-4 control-label">SECRETKEY</label>
                            <div class="col-md-6">
                                <input id="secret_key" type="text" class="form-control" name="secret_key" value="{{$user->secret_key}}"required>
                            </div>
                            @if ($errors->has('secret_key'))
                            <span class="help-block">
                                <strong>{{ $errors->first('secret_key') }}</strong>
                            </span>
                            @endif
                        </div>
                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <button type="submit" class="btn btn-primary">
                                    修改
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div
@endsection
