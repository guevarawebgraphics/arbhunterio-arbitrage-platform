@extends('index')

@section('title')

@endsection

@section('extra-css')

@endsection

@section('content')
	<div class="container-fluid">
            <div class="block-header ">
                <div class="pull-left">
                    <h2>Edit Product Category: {{ $coupon->name }}</h2>
                </div>
                <div class="pull-right">
                    <a class="btn btn-primary" href="{{ route('admin.coupon_codes.index') }}"> Back</a>
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
                                EDIT COUPON CODE FORM
                            </h2>
                        </div>
                        <div class="body">
                            {!! Form::model($coupon, ['method' => 'PATCH','route' => ['admin.coupon_codes.update', $coupon->id]]) !!}
                            <div class="row clearfix">
                                <div class="col-lg-2 col-md-2 col-sm-4 col-xs-5 form-control-label">
                                    <label for="name">Name</label>
                                </div>
                                <div class="col-lg-10 col-md-10 col-sm-8 col-xs-7">
                                    <div class="form-group">
                                        <div class="form-line">
                                            {!! Form::text('name', old('name'), array('placeholder' => 'Name','class' => 'form-control')) !!}
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row clearfix">
                                <div class="col-lg-2 col-md-2 col-sm-4 col-xs-5 form-control-label">
                                    <label for="name">Code</label>
                                </div>
                                <div class="col-lg-10 col-md-10 col-sm-8 col-xs-7">
                                    <div class="form-group">
                                        <div class="form-line">
                                            {!! Form::text('code', old('code'), array('placeholder' => 'Code','class' => 'form-control')) !!}
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row clearfix" id="page">
                                <div class="col-lg-2 col-md-2 col-sm-4 col-xs-5 form-control-label">
                                    <label for="group">Type</label>
                                </div>
                                <div class="col-lg-10 col-md-10 col-sm-8 col-xs-7">
                                    <div class="form-group">
                                        <div class="form-line">
                                            <select name="type" class="form-control">
                                                <option value="1">Percentage</option>
                                                <option value="2">Amount</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row clearfix">
                                <div class="col-lg-2 col-md-2 col-sm-4 col-xs-5 form-control-label">
                                    <label for="name">Value</label>
                                </div>
                                <div class="col-lg-10 col-md-10 col-sm-8 col-xs-7">
                                    <div class="form-group">
                                        <div class="form-line">
                                            {!! Form::text('value', old('value'), array('placeholder' => 'Value','class' => 'form-control')) !!}
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row clearfix">
                                <div class="col-lg-2 col-md-2 col-sm-4 col-xs-5 form-control-label">
                                    <label for="name">Times of Use <small>(0 = Unlimited until the end of coupon)</small></label>
                                </div>
                                <div class="col-lg-10 col-md-10 col-sm-8 col-xs-7">
                                    <div class="form-group">
                                        <div class="form-line">
                                            {!! Form::number('times_of_use', old('times_of_use'), array('placeholder' => 'Times of Use', 'class' => 'form-control')) !!}
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row clearfix">
                                <div class="col-lg-2 col-md-2 col-sm-4 col-xs-5 form-control-label">
                                    <label for="name">Date</label>
                                </div>
                                <div class="col-lg-10 col-md-10 col-sm-8 col-xs-7">
                                    <div class="form-group">
                                        <div class="form-line">
                                            <div class="input-daterange input-group" id="bs_datepicker_range_container">
                                                <div class="form-line">
                                                    <input type="text" name="date_start" value="{{ date('m/d/Y', strtotime($coupon->date_start)) }}" class="form-control" placeholder="Date start...">
                                                </div>
                                                <span class="input-group-addon">to</span>
                                                <div class="form-line">
                                                    <input type="text" name="date_end" value="{{ date('m/d/Y', strtotime($coupon->date_end)) }}" class="form-control" placeholder="Date end...">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row clearfix">
                                <div class="col-lg-2 col-md-2 col-sm-4 col-xs-5 form-control-label">
                                    <label for="name">Dont expire?</label>
                                </div>
                                <div class="col-lg-10 col-md-10 col-sm-8 col-xs-7">
                                    <div class="form-group">
                                        <div class="form-line">
                                            <div class="switch">
                                                <label>
                                                    <input type="checkbox" value="1" name="is_no_time_limit" {{ Request::old('is_featured') ? : ($coupon->is_no_time_limit ? 'checked' : '') }}><span class="lever switch-col-blue"></span>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row clearfix">
                                <div class="col-lg-2 col-md-2 col-sm-4 col-xs-5 form-control-label">
                                    <label for="name">Once per customer</label>
                                </div>
                                <div class="col-lg-10 col-md-10 col-sm-8 col-xs-7">
                                    <div class="form-group">
                                        <div class="form-line">
                                            <div class="switch">
                                                <label>
                                                    <input type="checkbox" value="1" name="once_per_customer" {{ Request::old('is_featured') ? : ($coupon->once_per_customer ? 'checked' : '') }}><span class="lever switch-col-blue"></span>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row clearfix">
                                <div class="col-lg-2 col-md-2 col-sm-4 col-xs-5 form-control-label">
                                    <label for="name">Apply to product/s <small>(blank means apply to all)</small></label>
                                </div>
                                <div class="col-lg-10 col-md-10 col-sm-8 col-xs-7">
                                    <div class="form-group">
                                        <div class="form-line">
                                            @php
                                                $array_prods = [];
                                                $prods = json_decode($coupon->apply_product);
                                                if ($prods != null) {
                                                    $array_prods = $prods;
                                                }
                                            @endphp

                                            <select name="apply_product[]" class="form-control show-tick" multiple>
                                                @foreach ($products as $product)
                                                    <option {{in_array($product->id, $array_prods) ? 'selected' : ''}} data="{{$product->id}}" value="{{$product->id}}">{{$product->title}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row clearfix">
                                <div class="col-lg-offset-2 col-md-offset-2 col-sm-offset-4 col-xs-offset-5">
                                    <button type="submit" class="btn btn-primary">Submit</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
                            
            {!! Form::close() !!}
            <!-- #END# Body Copy -->
        </div>
@endsection

@section('extra-script')
<script type="text/javascript" src="{{ asset('public/js/ckeditor/ckeditor.js') }}"></script>
{{Html::script('public/js/swal.js')}}
<script> 
    window.permissions = '<?php echo $permissions; ?>';
    $('#bs_datepicker_range_container').datepicker({
        autoclose: true,
        container: '#bs_datepicker_range_container'
    });
</script>
{{Html::script('public/js/bjcdl/libraries/menu_dropdowns.js')}}
@endsection