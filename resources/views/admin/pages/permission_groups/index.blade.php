@extends('index')

@section('title')

@endsection

@section('extra-css')

@endsection

@section('content')
	<div class="container-fluid">
            <div class="block-header ">
                <div class="pull-left">
                    <h2>Permission Group Management</h2>
                </div>
                <div class="pull-right">
                    @can('Create Role')
                        <a class="btn btn-success" href="{{ route('admin.permission_groups.create') }}"> Create New Permission Group</a>
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
                                PERMISSION GROUP LIST
                            </h2>
                        </div>
                        <div class="body">
                            <table id="permission_groups-table" class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Name</th>
                                        <th>Permissions</th>
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
{{Html::script('public/js/bjcdl/libraries/permission_groups.js')}}
@endsection