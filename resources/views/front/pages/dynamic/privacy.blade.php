@extends('front.layouts.base')

@section('content')

    <section class="py-5" id="features">
        <div class="container px-5 my-5">
            <div class="row gx-5">
                <div class="col-lg-12 mb-5 mb-lg-0">
                    <h2 class="fw-bolder mb-0">Privacy Policy.</h2>
                    {!! $page->content !!}
                </div>
            </div>
        </div>
    </section>
@endsection