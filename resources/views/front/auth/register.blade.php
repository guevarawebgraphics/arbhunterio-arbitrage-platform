@extends('front.layouts.base')

@section('content')
    @if (!empty($page))
        @php
            $item = $page;
        @endphp
    @else
        @php
            $item = (object) ['name' => 'register'];
        @endphp
    @endif

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
                    <!-- Sign Up Form -->
                    {{  Form::open([
                        'method' => 'POST',
                        'id' => 'form-register',
                        'route' => ['user.register.post'],
                        'class' => 'form-horizontal'
                        ])
                    }}
                        <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                            <div class="col-xs-12 mb-2">
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="gi gi-user"></i></span>
                                    <input type="text" id="name" name="name" class="form-control input-lg"
                                           placeholder="Full name"
                                           value="{{ old('name') }}" autofocus>
                                </div>
                            </div>
                        </div>
                        <div class="form-group{{ $errors->has('user_name') ? ' has-error' : '' }}">
                            <div class="col-xs-12 mb-2">
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="gi gi-user"></i></span>
                                    <input type="text" id="user_name" name="user_name" class="form-control input-lg"
                                           placeholder="Username"
                                           value="{{ old('user_name') }}">
                                </div>
                            </div>
                        </div>
                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                            <div class="col-xs-12 mb-2">
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="gi gi-envelope"></i></span>
                                    <input type="text" id="email" name="email" class="form-control input-lg"
                                           placeholder="Email"
                                           value="{{ old('email') }}">
                                </div>
                            </div>
                        </div>
                        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                            <div class="col-xs-12 mb-2">
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="gi gi-asterisk"></i></span>
                                    <input type="password" id="password" name="password" class="form-control input-lg" placeholder="Password">
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
                            <div class="col-xs-6 mb-2">
                                {{--<label class="switch switch-primary" data-toggle="tooltip" title="Agree to the terms">--}}
                                {{--<input type="checkbox" id="terms" name="terms"><span></span>--}}
                                {{--</label>--}}
                                {{--<a href="#modal-terms" data-toggle="modal" class="terms">--}}
                                {{--<small>View Terms</small>--}}
                                </a>
                            </div>
                            <div class="col-xs-6 text-right">
                                <button type="submit" class="btn btn-sm btn-primary"><i class="fa fa-plus"></i> Sign Up
                                </button>
                            </div>
                        </div>
                    {{ Form::close() }}
                    <!-- END Sign Up Form -->

                </div>
            </div>
        </div>
    </section>

    <!-- Modal Terms -->
    <div id="modal-terms" class="modal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title">Terms &amp; Conditions</h4>
                </div>
                <div class="modal-body">
                    <h4>Title</h4>
                    <p>Donec lacinia venenatis metus at bibendum? In hac habitasse platea dictumst. Proin ac nibh rutrum
                        lectus rhoncus eleifend. Sed porttitor pretium venenatis. Suspendisse potenti. Aliquam quis
                        ligula elit. Aliquam at orci ac neque semper dictum. Sed tincidunt scelerisque ligula, et
                        facilisis nulla hendrerit non. Suspendisse potenti. Pellentesque non accumsan orci. Praesent at
                        lacinia dolor. Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
                    <p>Donec lacinia venenatis metus at bibendum? In hac habitasse platea dictumst. Proin ac nibh rutrum
                        lectus rhoncus eleifend. Sed porttitor pretium venenatis. Suspendisse potenti. Aliquam quis
                        ligula elit. Aliquam at orci ac neque semper dictum. Sed tincidunt scelerisque ligula, et
                        facilisis nulla hendrerit non. Suspendisse potenti. Pellentesque non accumsan orci. Praesent at
                        lacinia dolor. Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
                    <h4>Title</h4>
                    <p>Donec lacinia venenatis metus at bibendum? In hac habitasse platea dictumst. Proin ac nibh rutrum
                        lectus rhoncus eleifend. Sed porttitor pretium venenatis. Suspendisse potenti. Aliquam quis
                        ligula elit. Aliquam at orci ac neque semper dictum. Sed tincidunt scelerisque ligula, et
                        facilisis nulla hendrerit non. Suspendisse potenti. Pellentesque non accumsan orci. Praesent at
                        lacinia dolor. Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
                    <p>Donec lacinia venenatis metus at bibendum? In hac habitasse platea dictumst. Proin ac nibh rutrum
                        lectus rhoncus eleifend. Sed porttitor pretium venenatis. Suspendisse potenti. Aliquam quis
                        ligula elit. Aliquam at orci ac neque semper dictum. Sed tincidunt scelerisque ligula, et
                        facilisis nulla hendrerit non. Suspendisse potenti. Pellentesque non accumsan orci. Praesent at
                        lacinia dolor. Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
                    <h4>Title</h4>
                    <p>Donec lacinia venenatis metus at bibendum? In hac habitasse platea dictumst. Proin ac nibh rutrum
                        lectus rhoncus eleifend. Sed porttitor pretium venenatis. Suspendisse potenti. Aliquam quis
                        ligula elit. Aliquam at orci ac neque semper dictum. Sed tincidunt scelerisque ligula, et
                        facilisis nulla hendrerit non. Suspendisse potenti. Pellentesque non accumsan orci. Praesent at
                        lacinia dolor. Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
                    <p>Donec lacinia venenatis metus at bibendum? In hac habitasse platea dictumst. Proin ac nibh rutrum
                        lectus rhoncus eleifend. Sed porttitor pretium venenatis. Suspendisse potenti. Aliquam quis
                        ligula elit. Aliquam at orci ac neque semper dictum. Sed tincidunt scelerisque ligula, et
                        facilisis nulla hendrerit non. Suspendisse potenti. Pellentesque non accumsan orci. Praesent at
                        lacinia dolor. Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
                </div>
            </div>
        </div>
    </div>
@endsection