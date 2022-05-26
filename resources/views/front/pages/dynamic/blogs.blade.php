@extends('front.layouts.base')

@section('content')

    <section class="py-5" id="features">
        <div class="container px-5 my-5">
            <div class="row gx-5">
                <div class="col-lg-12 mb-5 mb-lg-0">
                    @if ($page->attachment)
                        <img src="{{ $page->attachment }}" class="img-fluid" alt="...">
                    @endif
                    <header class="bg-light border-bottom mb-4">
                        <div class="container">
                            <div class="text-center my-5">
                                <h1 class="fw-bolder">Welcome to Blog Home!</h1>
                                <p class="lead mb-0">A My CMS starter layout for your next blog homepage</p>
                            </div>
                        </div>
                    </header>

                    <div class="container">
                        <div class="row">
                            <!-- Blog entries-->
                            <div class="col-lg-8">
                                <!-- Featured blog post-->
                                @if (count(featuredBlogs())) 
                                    @foreach(featuredBlogs()->shuffle()->take(1) as $featured)
                                        <div class="card mb-4">
                                            <a href="{{ route('blog.details', $featured->slug) }}"><img class="card-img-top" src="{{ asset($featured->thumbnail) }}" alt="{{ $featured->title }}" /></a>
                                            <div class="card-body">
                                                <div class="small text-muted">{{ $featured->created_at->format('M d, Y') }}</div>
                                                <h2 class="card-title">{{ $featured->title }}</h2>
                                                <p class="card-text">{{ $featured->content }}</p>
                                                <a class="btn btn-primary" href="{{ route('blog.details', $featured->slug) }}">Read more →</a>
                                            </div>
                                        </div>
                                    @endforeach
                                @endif
                                <!-- Nested row for non-featured blog posts-->
                                <div class="row">
                                    @forelse(isset($blogs) ? $blogs : blogs() as $blog)
                                        <div class="col-lg-6">
                                            <!-- Blog post-->
                                            <div class="card mb-4">
                                                <a href="{{ route('blog.details', $blog->slug) }}"><img class="card-img-top" src="{{ asset($blog->thumbnail) }}" alt="{{ $blog->title }}" /></a>
                                                <div class="card-body">
                                                    <div class="small text-muted">{{ $blog->created_at->format('M d, Y') }}</div>
                                                    <h2 class="card-title h4">{{ $blog->title }}</h2>
                                                    <p class="card-text">{{ str_limit($blog->content, 130) }}</p>
                                                    <a class="btn btn-primary" href="{{ route('blog.details', $blog->slug) }}">Read more →</a>
                                                </div>
                                            </div>
                                        </div>
                                    @empty
                                        <div class="col-lg-12">
                                            <h3>No blogs available</h3>
                                        </div>
                                    @endforelse
                                </div>
                                <!-- Pagination-->
                                <nav aria-label="Pagination">
                                    <hr class="my-0" />
                                    {!! isset($blogs) ? $blogs->links() : blogs()->links() !!}
                                </nav>
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

                </div>
            </div>
        </div>
    </section>
@endsection