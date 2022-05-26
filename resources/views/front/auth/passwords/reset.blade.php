@extends('front.layouts.base')

@section('content')
    @if (!empty($page))
        @php
            $item = $page;
        @endphp
    @else
        @php
            $item = (object) ['name' => 'Reset Password'];
        @endphp
    @endif

    <section class="py-5" id="features">
        <div class="container px-5 my-2">
            <div class="row gx-5">
                <div class="col-lg-5 mb-5 mb-lg-0">
                    <h2 class="fw-bolder mb-5">Forgot Password.</h2>
                    @if (session()->has('status'))
                        <div class="flash-success">
                            {{ session()->get('status') }}
                        </div>
                    @endif
                    
                    @if (count($errors))
                        <ul class="errors">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>    
                    @endif

                    {{  Form::open([
                        'method' => 'POST',
                        'id' => 'form-reset',
                        'route' => ['user.password.reset.post'],
                        'class' => 'form-horizontal'
                        ])
                    }}
                        @if (session()->has('status'))
                            <div class="alert alert-success">
                                {{ session()->get('status') }}
                            </div>
                        @endif
                        <input type="hidden" name="token" value="{{ $token }}">
                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                            <div class="col-xs-12 mb-2">
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="gi gi-envelope"></i></span>
                                    {{-- <input type="text" id="email" name="email"
                                           class="form-control input-lg" placeholder="Email"
                                           value="{{ $email or old('email') }}" autofocus> --}}
                                    <input type="text" id="email" name="email"
                                           class="form-control input-lg" placeholder="Email"
                                           value="{{  old('email') ? : $email }}" autofocus>
                                </div>
                                @if ($errors->has('email'))
                                    <span id="email-error" class="help-block animation-slideDown">
                                    {{ $errors->first('email') }}
                                </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                            <div class="col-xs-12 mb-2">
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="gi gi-asterisk"></i></span>
                                    <input type="password" id="password" name="password" class="form-control input-lg"
                                           placeholder="Password">
                                    @if ($errors->has('password'))
                                        <span id="password-error" class="help-block animation-slideDown">
                                        {{ $errors->first('password') }}
                                    </span>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-xs-12 mb-2">
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="gi gi-asterisk"></i></span>
                                    <input type="password" id="password_confirmation" name="password_confirmation"
                                           class="form-control input-lg" placeholder="Verify Password">
                                </div>
                            </div>
                        </div>
                        <div class="form-group form-actions">
                            <div class="col-md-6 col-md-offset-6 text-right">
                                <button type="submit" class="btn btn-sm btn-primary"><i class="fa fa-arrow-right"></i>
                                    Reset Password
                                </button>
                            </div>
                        </div>
                    {{ Form::close() }}
                    <div class="form-group">
                        <div class="col-xs-12 mb-2 text-center">
                            <small>Did you remember your password?</small>
                            <a href="{{ url('/user/login') }}"{{-- id="link-reminder"--}}>
                                <small>Login</small>
                            </a>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </section>
@endsection