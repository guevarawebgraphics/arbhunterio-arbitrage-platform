@extends('auth.app')

@section('content')

<form id="sign_in" role="form" method="POST" action="{{ route('admin.login.post') }}">
    {{ csrf_field() }}
    <div class="msg">Sign in to start your session</div>
    <div class="input-group">
        <span class="input-group-addon">
        <i class="material-icons">person</i>
        </span>
        <div class="form-line {{ $errors->has('email') ? ' error' : '' }}">
            <input type="text" class="form-control" name="email" value="{{old('email')}}" placeholder="Username" required autofocus>
            {{-- <input type="text" class="form-control{{ $errors->has('username') || $errors->has('email') ? ' is-invalid' : '' }}" name="login" value="{{ old('username') ?: old('email') }}" required autofocus> --}}
        </div>
        @if ($errors->has('user_name') || $errors->has('email'))
            <span class="invalid-feedback">
                <strong>{{ $errors->first('user_name') ?: $errors->first('email') }}</strong>
            </span>
        @endif
    </div>
    <div class="input-group">
        <span class="input-group-addon">
        <i class="material-icons">lock</i>
        </span>
        <div class="form-line {{ $errors->has('password') ? ' error' : '' }}">
            <input type="password" class="form-control" name="password" placeholder="Password" required>
        </div>
        @if ($errors->has('password'))
        <label id="name-error" class="error" for="name">{{ $errors->first('password') }}</label>
        @endif
    </div>
    <div class="row">
        <div class="col-xs-8 p-t-5">
            <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }} class="filled-in chk-col-pink">
            <label for="rememberme">Remember Me</label>
        </div>
        <div class="col-xs-4">
            <button class="btn btn-block bg-pink waves-effect" type="submit">SIGN IN</button>
        </div>
    </div>
    <div class="row m-t-15 m-b--20">
        <div class="col-xs-6">
        </div>
        <div class="col-xs-6 align-right">
        </div>
    </div>
</form>
@endsection
