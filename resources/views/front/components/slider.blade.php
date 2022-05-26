<div id="homepageSliders" class="carousel slide" data-bs-ride="carousel">
    <div class="carousel-indicators">
      @foreach($sliders as $slide)
        @if ($loop->first)
          <button type="button" data-bs-target="#homepageSliders" data-bs-slide-to="{{ $loop->index }}" class="active" aria-current="true" aria-label="{{ $slide->title }}"></button>
        @else
          <button type="button" data-bs-target="#homepageSliders" data-bs-slide-to="{{ $loop->index }}" aria-label="{{ $slide->title }}"></button>
        @endif
      @endforeach
    </div>
    <div class="carousel-inner">
      @foreach($sliders as $slide)
        @if ($loop->first)
          <div class="carousel-item active">
            <img src="{{ asset($slide->background_image) }}" class="d-block w-100" alt="{{ $slide->title }}">
            <div class="carousel-caption d-none d-md-block">
              <h5>{{ $slide->title }}</h5>
              <p>{{ $slide->content }}</p>
            </div>
          </div>
        @else
          <div class="carousel-item">
            <img src="{{ asset($slide->background_image) }}" class="d-block w-100" alt="{{ $slide->title }}">
            <div class="carousel-caption d-none d-md-block">
              <h5>{{ $slide->title }}</h5>
              <p>{{ $slide->content }}</p>
            </div>
          </div>
        @endif
      @endforeach
    </div>
    <button class="carousel-control-prev" type="button" data-bs-target="#homepageSliders" data-bs-slide="prev">
      <span class="carousel-control-prev-icon" aria-hidden="true"></span>
      <span class="visually-hidden">Previous</span>
    </button>
    <button class="carousel-control-next" type="button" data-bs-target="#homepageSliders" data-bs-slide="next">
      <span class="carousel-control-next-icon" aria-hidden="true"></span>
      <span class="visually-hidden">Next</span>
    </button>
  </div>