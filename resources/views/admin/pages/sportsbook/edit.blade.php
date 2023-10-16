@extends('index')

@section('title')
	Dashboard
@endsection

@section('extra-css')

@endsection

@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <!-- Main content -->
    <div class="content">
        <ol class="breadcrumb">
            <li>
                <a href="{{url('/admin/pages')}}">
                    <i class="pe-7s-home"></i> Pages
                </a>
            </li>
{{-- <li><a href="{{ route('admin.dashboard') }}">Dashboard</a></li> --}}
            <li class="active">
                Edit SportsBook
            </li>
        </ol>
        
        <div class="se-pre-con"></div>
        <!-- load custom page -->

        <div class="row">
            <div class="col-sm-12">
                <div class="panel panel-bd lobidrag">
                    <div class="panel-heading">
                        <div class="panel-title">
                            <span>Edit SportsBook</span>
                        </div>
                    </div>
                    
                    <div class="panel-body">
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
                        {!! Form::model($sportsBook, ['method' => 'PATCH','route' => ['admin.sportsbooks.update', $sportsBook->id]]) !!}
                            <div class="form-group row">
                                <label for="title" class="col-sm-2 text-right col-form-label">Name <i class="text-danger"> * </i>:</label>
                                <div class="col-sm-6">
                                    <div class="">
                                        {!! Form::text('name', null, array('placeholder' => 'Name','class' => 'form-control')) !!}
                                    </div>
                                </div>
                            </div>

                            <div class="form-group row"> 
                                <label for="attachment" class="col-sm-2 text-right col-form-label">Is Active:</label>
                                <div class="col-sm-6">
                                    <div class="flex">
                                        <div class="onoffswitch4">
                                            <input type="checkbox" name="is_active" class="onoffswitch1-checkbox" id="myonoffswitch1" {{ Request::old('is_active') ? : ($sportsBook->is_active ? 'checked' : '') }}>
                                            <label class="onoffswitch1-label" for="myonoffswitch1">
                                                <span class="onoffswitch1-inner"></span>
                                                <span class="onoffswitch1-switch"></span>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="form-group row">
                                <div class="col-sm-6 text-right"></div>
                                <div class="col-sm-6 text-right">
                                    <div class="">
                                        <button type="submit" class="btn btn-success">Save</button>
                                    </div>
                                </div>
                            </div>
                        {!! Form::close() !!}     
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>


<!-- /.content -->
@endsection

@section('extra-script')
@endsection