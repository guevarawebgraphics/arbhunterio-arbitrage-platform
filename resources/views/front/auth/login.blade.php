@extends('front.layouts.base')

@section('content')
    @if (!empty($page))
        @php
            $item = $page;
        @endphp
    @else
        @php
            $item = (object) ['name' => 'login'];
        @endphp
    @endif

    <!-- Log In -->
    <section class="py-5" id="features">
        <div class="container px-5 my-2">
            <div class="row gx-5">
                <div class="col-lg-5 mb-5 mb-lg-0">
                    <h2 class="fw-bolder mb-5">Login.</h2>

                    @if (count($errors))
                        <ul class="errors">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>    
                    @endif

                    <!-- Log In Form -->
                    {{  Form::open([
                        'method' => 'POST',
                        'id' => 'form-login',
                        'route' => ['user.login.post'],
                        'class' => 'form-horizontal'
                        ])
                    }}
                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                            <div class="col-xs-12 mb-2">
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="gi gi-envelope"></i></span>
                                    <input type="text" id="email" name="email"
                                           class="form-control input-lg" placeholder="Email"
                                           value="{{ old('email') }}" autofocus>
                                </div>
                            </div>
                        </div>
                        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                            <div class="col-xs-12 mb-2">
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="gi gi-asterisk"></i></span>
                                    <input type="password" id="password" name="password"
                                           class="form-control input-lg" placeholder="Password">
                                </div>
                            </div>
                        </div>
                        <div class="form-group form-actions">
                            <div class="col-xs-6 mb-2">
                                <label class="switch switch-primary">
                                    <input type="checkbox" id="remember" name="remember" {{ old('remember') ? 'checked' : ''}}>
                                    <span></span>
                                </label>
                                <small>Remember me</small>
                            </div>
                            <div class="col-xs-6 text-right">
                                <button type="submit" class="btn btn-sm btn-primary"><i class="fa fa-arrow-right"></i>
                                    Log In
                                </button>
                            </div>
                        </div>
                        <div class="form-group">

                        </div>
                    {{ Form::close() }}
                    <div class="text-center">
                        <a href="{{ url('user/password/email') }}">
                            <small>Forgot password?</small>
                        </a>
                        
                    </div>
                    <div class="container text-center">
                         <a href="{{ url('user/register') }}">
                            <small>No Account yet? Register Here</small>
                        </a>
                    </div>
                    
                </div>
            </div>
        </div>
    </section>
@endsection
