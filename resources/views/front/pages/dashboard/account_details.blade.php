@extends('front.layouts.base')

@section('content')
    <section class="page page--dashboard">
        <div id="dashboard">
            <section class="dashboard default-content">
                <div class="wrapper">
                    <div class="row">
                        <div class="col-md-3">
                            @include('front.pages.dashboard.sections.nav')
                        </div>
                        <div class="col-md-9">
                            <div class="row">
                                <div class="col-md-3">
                                    @include('front.pages.dashboard.sections.profile-nav')
                                </div>
                                <div class="col-md-9">
                                    asd
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </section>
@endsection