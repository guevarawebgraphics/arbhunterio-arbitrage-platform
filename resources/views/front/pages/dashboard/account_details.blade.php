@extends('front.layouts.base')
@section('content')

<section class="page page--dashboard">
    <div id="dashboard">
        <section class="dashboard default-content">
            <div class="wrapper">
                <div class="row">
                    <div class="col-md-3">
                        @include('front.pages.dashboard.sections.nav')
                    </div>
                    <div class="col-md-9">
                        <div class="dashboard__content">
                            <div class="row">
                                <div class="col-md-12">
                                    <h2>Account Details</h2>
                                    @if ($message = Session::get('success'))
                                        <div class="alert alert-success">
                                            <p>{!! $message !!}</p>
                                        </div>
                                    @endif
                                    <div class="account-details">
                                        {{  Form::open([
                                            'method' => 'PUT',
                                            'id' => 'edit-front_user',
                                            'route' => ['account-details.update', auth()->user()->id],
                                            'class' => ''
                                            ])
                                        }}
                                            {{-- Details--}}
                                            <div class="row ">
                                                <div class="col-md-6 form-group{{ $errors->has('first_name') ? ' has-error' : '' }}">
                                                    <label for="firstName">First Name</label>
                                                    <input type="text" id="firstName" name="first_name" class="form-control" value="{{ auth()->user()->first_name }}">
                                                    @if ($errors->has('first_name'))
                                                        <span id="first_name-error" class="help-block animation-slideDown">
                                                            {{ $errors->first('first_name') }}
                                                        </span>
                                                    @endif
                                                </div>
                                                <div class="col-md-6 form-group{{ $errors->has('last_name') ? ' has-error' : '' }}">
                                                    <label for="lastName">Last Name</label>
                                                    <input type="text" id="lastName" name="last_name" class="form-control" value="{{ auth()->user()->last_name }}">
                                                    @if ($errors->has('last_name'))
                                                        <span id="last_name-error" class="help-block animation-slideDown">
                                                            {{ $errors->first('last_name') }}
                                                        </span>
                                                    @endif
                                                </div>
                                                <div class="col-md-6 form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                                                    <label for="emailAdress">Email Address</label>
                                                    <input type="text" id="emailAdress" name="email" class="form-control" value="{{ auth()->user()->email }}">
                                                    @if ($errors->has('email'))
                                                        <span id="email-error" class="help-block animation-slideDown">
                                                            {{ $errors->first('email') }}
                                                        </span>
                                                    @endif
                                                </div>
                                            </div>

                                            {{-- Change Password--}}
                                            <div class="row ">
                                                <div class="col-md-12">
                                                    <h4 class="switch switch-primary">
                                                        Change Password?
                                                        <input type="checkbox" id="change_password" name="change_password"
                                                            value="1" {{ $errors->has('password') || $errors->has('old_password') ? 'checked' : ''}}>
                                                        <span class="checkmark"></span>
                                                    </h4>
                                                </div>
                                                <div class="col-md-12 form-group">
                                                    <label for="currentPassword">Current Password</label>
                                                    <input type="password" id="currentPassword" name="old_password" class="form-control">
                                                    @if($errors->has('old_password'))
                                                        <span class="help-block animation-slideDown">{{ $errors->first('old_password') }}</span>
                                                    @endif
                                                </div>
                                                <div class="col-md-6 form-group">
                                                    <label for="newPassword">New Passowrd</label>
                                                    <input type="password" id="newPassword" name="password" class="form-control">
                                                    @if($errors->has('password'))
                                                        <span class="help-block animation-slideDown">{{ $errors->first('password') }}</span>
                                                    @endif
                                                </div>
                                                <div class="col-md-6 form-group{{ $errors->has('password_confirmation') ? ' has-error' : '' }}">
                                                    <label for="confirmPassowrd">Confirm Passowrd</label>
                                                    <input type="password" id="confirmPassowrd" name="password_confirmation" class="form-control">
                                                </div>
                                            </div>
                                            <div class="row mt-2">
                                                <div class="col-md-12 form-group">
                                                    <button type="submit" class="btn btn-primary">Submit</button>
                                                </div>
                                            </div>
                                        {{ Form::close() }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
</section>
@endsection