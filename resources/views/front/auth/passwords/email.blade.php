@extends('front.layouts.base')

@section('content')
    @if (!empty($page))
        @php
            $item = $page;
        @endphp
    @else
        @php
            $item = (object) ['name' => 'forgot password'];
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
                        'id' => 'form-email',
                        'route' => ['user.password.email.post'],
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
                        <div class="form-group form-actions">
                            <div class="col-md-8 mb-2 col-md-offset-4 text-right">
                                <button type="submit" class="btn btn-sm btn-primary"><i class="fa fa-arrow-right"></i>
                                    Send Password Reset Link
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