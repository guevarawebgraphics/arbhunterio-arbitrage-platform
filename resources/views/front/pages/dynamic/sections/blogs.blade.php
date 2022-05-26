@forelse(blogs() as $blog)
    <div class="col-lg-4 mb-5">
        <div class="card h-100 shadow border-0">
            <img class="card-img-top" src="{{ asset($blog->thumbnail) }}" alt="{{ $blog->title }}" />
            <div class="card-body p-4">
                <div class="badge bg-primary bg-gradient rounded-pill mb-2">{{ $blog->category->name }}</div>
                <a class="text-decoration-none link-dark stretched-link" href="{{ route('blog.details', $blog->slug) }}"><h5 class="card-title mb-3">{{ $blog->title }}</h5></a>
                <p class="card-text mb-0">{{ $blog->content }}</p>
            </div>
            <div class="card-footer p-4 pt-0 bg-transparent border-top-0">
                <div class="d-flex align-items-end justify-content-between">
                    <div class="d-flex align-items-center">
                        <div class="small">
                            <div class="fw-bold">{{ $blog->author }}</div>
                            <div class="text-muted">{{ $blog->created_at->format('M d, Y') }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@empty
    <div class="col-lg-12 mb-5">
        <h3>No blogs available</h3>
    </div>
@endforelse