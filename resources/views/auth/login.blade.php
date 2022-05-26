@extends('auth.app')

@section('content')

<form id="sign_in" role="form" method="POST" action="{{ route('admin.login.post') }}">
    {{ csrf_field() }}
    <div class="msg">Sign in to start your session</div>
    <div class="input-group">
        <span class="input-group-addon">
        <i class="material-icons">person</i>
        </span>
        <div  class="form-line{{ $errors->has('login') || $errors->has('email') ? ' is-invalid' : '' }}">
            {{-- <input type="text" class="form-control" name="email" value="{{old('email')}}" placeholder="Username" required autofocus> --}}
            <input type="text" class="form-control{{ $errors->has('user_name') || $errors->has('email') ? ' is-invalid' : '' }}" name="login" value="{{ old('user_name') ?: old('email') }}" required autofocus>
        </div>
        @if ($errors->has('login') || $errors->has('email'))
            <span class="invalid-feedback">
                <strong>{{ $errors->first('login') ?: $errors->first('email') }}</strong>
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
        </div>
        <div class="col-xs-4">
            <button class="btn btn-block bg-pink waves-effect" type="submit">SIGN IN</button>
        </div>
    </div>
    <div class="row m-t-15 m-b--20">
    </div>
</form>
@endsection
