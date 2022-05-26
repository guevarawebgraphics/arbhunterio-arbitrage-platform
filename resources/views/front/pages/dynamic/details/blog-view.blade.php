@extends('front.layouts.blog')

@section('content')

    <section class="py-5" id="features">
        <div class="container px-5 my-5">
            <div class="row gx-5">
                <div class="col-lg-8">
                    <!-- Post content-->
                    <article>
                        <!-- Post header-->
                        <header class="mb-4">
                            <!-- Post title-->
                            <h1 class="fw-bolder mb-1">{{ $blog->title }}</h1>
                            
                            <!-- Post meta content-->
                            <div class="text-muted fst-italic mb-2">Posted on {{ $blog->created_at->format('M d, Y') }} by {{ $blog->author }}</div>
                            <!-- Post categories-->
                            <a class="badge bg-secondary text-decoration-none link-light" href="#!">{{ $blog->category->name }}</a>
                        </header>
                        <!-- Preview image figure-->
                        <figure class="mb-4"><img class="img-fluid rounded" src="{{ asset($blog->cover_image) }}" alt="{{ $blog->title }}" /></figure>
                        <!-- Post content-->
                        <section class="mb-5">
                            {!! $blog->content !!}
                        </section>
                    </article>
                    <!-- Comments section-->
                    {{-- @include('front.pages.dynamic.details.blog-comments') --}}
                </div>
                <!-- Side widgets-->
                <div class="col-lg-4">
                    <!-- Search widget-->
                    <div class="card mb-4">
                        <div class="card-header">Search</div>
                        <div class="card-body">
                            <div class="input-group">
                                <input class="form-control" type="text" placeholder="Enter search term..." aria-label="Enter search term..." aria-describedby="button-search" />
                                <button class="btn btn-primary" id="button-search" type="button">Go!</button>
                            </div>
                        </div>
                    </div>
                    <!-- Categories widget-->
                    <div class="card mb-4">
                        <div class="card-header">Categories</div>
                        <div class="card-body">
                            <div class="row">
                                @forelse(blogsCategories() as $category)
                                    <div class="col-sm-6">
                                        <a href="{{ route('blog.categories', $category->name) }}">{{ $category->name }}</a>
                                    </div>
                                @empty
                                    <div class="col-sm-6">
                                        <p>No Category available</p>
                                    </div>
                                @endforelse
                            </div>
                        </div>
                    </div>
                    <!-- Side widget-->
                    <div class="card mb-4">
                        <div class="card-header">Side Widget</div>
                        <div class="card-body">You can put anything you want inside of these side widgets. They are easy to use, and feature the Bootstrap 5 card component!</div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection