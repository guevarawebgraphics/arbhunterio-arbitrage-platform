@extends('front.layouts.base')

@section('content')

    <section class="py-5" id="features">
        <div class="container px-5 my-5">
            <div class="row gx-5">
                <div class="col-lg-12 mb-5 mb-lg-0">
                    @if ($page->attachment)
                        <img src="{{ $page->attachment }}" class="img-fluid" alt="...">
                    @endif
                    <h2 class="fw-bolder mb-0">{{ $page->name }}</h2>
                    <hr>
                    {!! $page->content !!}
                </div>
            </div>
        </div>
    </section>
@endsection