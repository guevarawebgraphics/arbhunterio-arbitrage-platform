@extends('index')

@section('title')

@endsection

@section('extra-css')

@endsection

@section('content')
	<div class="container-fluid">
        <!-- Body Copy -->
        <div class="row clearfix">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="card">
                    <div class="header">
                        <h2>
                            NEWSLETTER SUBSCRIBERS LIST
                        </h2>
                        <p>MailChimp can be integrated here.</p>
                    </div>
                    <div class="body">
                        <table id="newsletters-table" class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Email</th>
                                    <th>Subscribed At</th>
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
{{Html::script('public/js/bjcdl/libraries/newsletters.js')}}
@endsection