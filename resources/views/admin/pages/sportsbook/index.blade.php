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
                SportsBook
            </li>
        </ol>
        
        <div class="se-pre-con"></div>
        <!-- load custom page -->

        <div class="row">
            <div class="col-sm-12">
                <div class="panel panel-bd lobidrag">
                    <div class="panel-heading">
                        <div class="panel-title">
                            <span>SportsBook</span>
                            @can('Create SportsBook')
                                <span class="padding-lefttitle">
                                    <a href="{{ route('admin.sportsbooks.create') }}" class="btn btn-info m-b-5 m-r-2"><i class="ti-plus"> </i> Add New SportsBook</a>
                                </span>
                            @endcan
                        </div>
                    </div>
                    
                    <div class="panel-body">
                        @if ($message = Session::get('success'))
                            <div class="alert alert-success alert-important" role="alert">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                <p>{!! $message !!}</p>
                            </div>
                        @endif
                        <table id="sportsbook-table" class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Name</th>
                                    <th>Is active</th>
                                    <th width="280px">Action</th>
                                </tr>
                            </thead>
                        </table>   
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>


<!-- /.content -->
@endsection

@section('extra-script')
{{Html::style('public/css/jquery.dataTables.min.css')}}
{{Html::script('public/js/jquery.dataTables.min.js')}}
{{Html::script('public/js/swal.js')}}
<script> window.permissions = '<?php echo $permissions; ?>'; </script>
{{Html::script('public/js/bjcdl/libraries/sportsbooks.js')}}
@endsection