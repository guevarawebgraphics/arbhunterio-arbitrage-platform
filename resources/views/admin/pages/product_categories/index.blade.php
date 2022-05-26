@extends('index')

@section('title')

@endsection

@section('extra-css')

@endsection

@section('content')
	<div class="container-fluid">
            <div class="block-header ">
                <div class="pull-left">
                    <h2>Product Category Management</h2>
                </div>
                <div class="pull-right">
                    @can('Create Role')
                        <a class="btn btn-success" href="{{ route('admin.product_categories.create') }}"> Create New Product Category</a>
                    @endcan
                </div>
                <div class="clearfix"></div>
            </div>

            @if ($message = Session::get('success'))
                <div class="alert alert-success">
                    <p>{!! $message !!}</p>
                </div>
            @endif
            <!-- Body Copy -->
            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="header">
                            <h2>
                                PRODUCT CATEGORY LIST
                            </h2>
                        </div>
                        <div class="body">
                            <table id="product_categories-table" class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Title</th>
                                        <th width="280px">Action</th>
                                    </tr>
                                </thead>
                              </table>
                        </div>
                    </div>
                </div>
            </div>
            <!-- #END# Body Copy -->
        </div>
@endsection

@section('extra-script')
{{Html::style('public/css/jquery.dataTables.min.css')}}
{{Html::script('public/js/jquery.dataTables.min.js')}}
{{Html::script('public/js/swal.js')}}
<script> window.permissions = '<?php echo $permissions; ?>'; </script>
{{Html::script('public/js/bjcdl/libraries/product_categories.js')}}
@endsection