@extends('index')

@section('title')

@endsection


@section('extra-css')
<style>
    .image-preview-input {
        position: relative;
        overflow: hidden;
        margin: 0px;    
        color: #333;
        background-color: #fff;
        border-color: #ccc;    
    }
    .image-preview-input input[type=file] {
        position: absolute;
        top: 0;
        right: 0;
        margin: 0;
        padding: 0;
        font-size: 20px;
        cursor: pointer;
        opacity: 0;
        filter: alpha(opacity=0);
    }
    .image-preview-input-title {
        margin-left:2px;
    }	
</style>
@endsection

@section('content')
	<div class="container-fluid">
            <div class="block-header ">
                <div class="pull-left">
                    <h2>Edit System Setting: {{ $system_setting->name }}</h2>
                </div>
                <div class="pull-right">
                    <a class="btn btn-primary" href="{{ route('admin.system_settings.index') }}"> Back</a>
                </div>
                <div class="clearfix"></div>
            </div>

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
            <!-- Body Copy -->
            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="header">
                            <h2>
                                EDIT SYSTEM SETTING FORM
                            </h2>
                        </div>
                        <div class="body">
                            {!! Form::model($system_setting, ['method' => 'PATCH','route' => ['admin.system_settings.update', $system_setting->id], 'files' => true]) !!}

                            <div class="row clearfix">
                                <div class="col-lg-2 col-md-2 col-sm-4 col-xs-5 form-control-label">
                                    <label for="name">Code</label>
                                </div>
                                <div class="col-lg-10 col-md-10 col-sm-8 col-xs-7">
                                    <div class="form-group">
                                        <div class="form-line">
                                            {!! Form::text('code', !empty($max_code) ? $max_code : old('code'), array('placeholder' => 'Code','class' => 'form-control', 'readonly')) !!}
                                        </div>
                                    </div>
                                </div>
                            </div>


                            <div class="row clearfix">
                                <div class="col-lg-2 col-md-2 col-sm-4 col-xs-5 form-control-label">
                                    <label for="name">Name</label>
                                </div>
                                <div class="col-lg-10 col-md-10 col-sm-8 col-xs-7">
                                    <div class="form-group">
                                        <div class="form-line">
                                            {!! Form::text('name', null, array('placeholder' => 'Name','class' => 'form-control')) !!}
                                        </div>
                                    </div>
                                </div>
                            </div>

                            @include('admin.pages.system_settings.value')

                            <div class="row clearfix">
                                <div class="col-lg-offset-2 col-md-offset-2 col-sm-offset-4 col-xs-offset-5">
                                    <button type="submit" class="btn btn-primary">Submit</button>
                                </div>
                            </div>
                            
                            {!! Form::close() !!}
                        </div>
                    </div>
                </div>
            </div>
            <!-- #END# Body Copy -->
        </div>
@endsection

@section('extra-script')
<script type="text/javascript" src="{{ asset('public/js/ckeditor/ckeditor.js') }}"></script>
{{Html::script('public/js/swal.js')}}
<script> 
window.permissions = '<?php echo $permissions; ?>'; 
window.file = '<?php echo url('/') . '/' . $system_setting->value; ?>';
</script>
{{Html::script('public/js/bjcdl/libraries/system_settings.js')}}
@endsection