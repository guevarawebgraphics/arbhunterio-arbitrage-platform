@extends('index')

@section('title')

@endsection

@section('extra-css')

@endsection

@section('content')
	<div class="container-fluid">
    <div class="block-header">
        <h2>CONTACTS</h2>
        <div class="pull-right">
            <a class="btn btn-primary" href="{{ route('admin.contacts.index') }}"> Back</a>
        </div>
        <div class="clearfix"></div>
    </div>
    <!-- Body Copy -->
    <div class="row clearfix">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="card">
                <div class="header">
                    <h2>
                        VIEW CONTACT
                    </h2>
                </div>
                <div class="body">
                    <p class="lead">
                        <b>Name:</b> {{ $contact->name }}
                    </p>
                    <p>
                        <b>Email:</b> {{ $contact->email }}
                    </p>
                    <p>
                        <b>Phone:</b> {{ $contact->phone }}
                    </p>
                    @if ($contact->company)
                        <p>
                            <b>Company:</b> {{ $contact->company }}
                        </p>
                    @endif
                    <p>
                        <b>Subject:</b> {{ $contact->subject }}
                    </p>
                    <p>
                        <b>Message:</b> {{ $contact->message }}
                    </p>
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
@endsection