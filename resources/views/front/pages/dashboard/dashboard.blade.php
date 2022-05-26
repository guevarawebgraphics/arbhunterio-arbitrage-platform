@extends('front.layouts.base')
@section('content')

<section class="page page--dashboard">
    {{-- @include('front.pages.dashboard.sections.dashboard-breadcrumb') --}}
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
                                    <h2>Welcome {{ auth()->user()->first_name . ' ' . auth()->user()->last_name }}</h2>
                                    <p>Lorem ipsum dolor sit, amet consectetur adipisicing elit.</p>
                                    {{-- Static --}}
                                    {{-- <div class="alert alert-warning">
                                        You currently have no orders
                                    </div>
                                    <a href="{{url('shop')}}" class="btn btn--primary mb-5">Start Shopping</a> --}}
                        
                                    {{-- <div class="table-responsive "> --}}
                                    
                        
                                    {{-- <a href="{{ url('orders') }}" class="btn btn--primary">View all orders</a> --}}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
    {{-- @include('front.layouts.sections.footer') --}}
</section>
@endsection