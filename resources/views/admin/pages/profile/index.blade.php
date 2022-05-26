@extends('index')

@section('title')
	Dashboard
@endsection

@section('extra-css')

@endsection

@section('content')
<div class="container-fluid">
    <div class="row clearfix">
        <div class="col-xs-12 col-sm-3">
            <div class="card profile-card">
                <div class="profile-header">&nbsp;</div>
                <div class="profile-body">
                    <div class="image-area">
                        <img src="{{ asset('public/bsbmd/images/user.png') }}" alt="AdminBSB - Profile Image" />
                    </div>
                    <div class="content-area">
                        <h3>{{ auth()->user()->name }}</h3>
                        <p>{{ auth()->user()->email }}</p>
                        <p>{{ auth()->user()->roles()->pluck('name')->implode(', ') }}</p>
                    </div>
                </div>
                <div class="profile-footer">
                    <ul>
                        <li>
                            <span>Registered</span>
                            <span>{{ date('M d, Y', strtotime(auth()->user()->created_at)) }}</span>
                        </li>
                        <li>
                            <span>Last updated</span>
                            <span>{{ date('M d, Y', strtotime(auth()->user()->updated_at)) }}</span>
                        </li>
                    </ul>
                    {{-- <button class="btn btn-primary btn-lg waves-effect btn-block">FOLLOW</button> --}}
                </div>
            </div>

        </div>
        <div class="col-xs-12 col-sm-9">
            <div class="card">
                <div class="body">
                    <div>
                        <ul class="nav nav-tabs" role="tablist">
                            <li role="presentation" class="active"><a href="#profile_settings" aria-controls="settings" role="tab" data-toggle="tab">Profile Settings</a></li>
                            <li role="presentation"><a href="#change_password_settings" aria-controls="settings" role="tab" data-toggle="tab">Change Password</a></li>
                        </ul>

                        <div class="tab-content">
                            <div role="tabpanel" class="tab-pane fade in active" id="profile_settings">

                                @if (count($errors) > 0)
                                    <div class="alert alert-danger">
                                        <strong>Whoops!</strong> There were some problems with your input.<br><br>
                                        <ul>
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                        </ul>
                                    </div>
                                @endif

                                @if ($message = Session::get('success'))
                                    <div class="alert alert-success">
                                        <p>{!! $message !!}</p>
                                    </div>
                                @endif

                                {!! Form::model(auth()->user(), ['method' => 'POST','route' => ['admin.profile.update', auth()->user()->id], 'class' => 'form-horizontal']) !!}
                                    <div class="form-group">
                                        <label for="NameSurname" class="col-sm-2 control-label">Name</label>
                                        <div class="col-sm-10">
                                            <div class="form-line">
                                                <input type="text" class="form-control" id="NameSurname" name="name" placeholder="Name Surname" value="{{ auth()->user()->name }}" required>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="Email" class="col-sm-2 control-label">Email</label>
                                        <div class="col-sm-10">
                                            <div class="form-line">
                                                <input type="email" class="form-control" id="Email" name="email" placeholder="Email" value="{{ auth()->user()->email }}" required>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="InputSkills" class="col-sm-2 control-label">Username</label>

                                        <div class="col-sm-10">
                                            <div class="form-line">
                                                <input type="text" class="form-control" name="user_name" value="{{ auth()->user()->user_name }}" placeholder="Skills">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <div class="col-sm-offset-2 col-sm-10">
                                            <button type="submit" class="btn btn-danger">SUBMIT</button>
                                        </div>
                                    </div>
                                {!! Form::close() !!}
                            </div>
                            <div role="tabpanel" class="tab-pane fade in" id="change_password_settings">
                                {!! Form::model(auth()->user(), ['method' => 'POST','route' => ['admin.profile.update_password', auth()->user()->id], 'class' => 'form-horizontal']) !!}
                                    <div class="form-group">
                                        <label for="OldPassword" class="col-sm-3 control-label">Old Password</label>
                                        <div class="col-sm-9">
                                            <div class="form-line">
                                                <input type="password" class="form-control" id="OldPassword" name="old_password" placeholder="Old Password" required>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="NewPassword" class="col-sm-3 control-label">New Password</label>
                                        <div class="col-sm-9">
                                            <div class="form-line">
                                                <input type="password" class="form-control" id="NewPassword" name="password" placeholder="New Password" required>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="NewPasswordConfirm" class="col-sm-3 control-label">New Password (Confirm)</label>
                                        <div class="col-sm-9">
                                            <div class="form-line">
                                                <input type="password" class="form-control" id="NewPasswordConfirm" name="confirm-password" placeholder="New Password (Confirm)" required>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <div class="col-sm-offset-3 col-sm-9">
                                            <button type="submit" class="btn btn-danger">SUBMIT</button>
                                        </div>
                                    </div>
                                {!! Form::close() !!}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('extra-script')
@endsection