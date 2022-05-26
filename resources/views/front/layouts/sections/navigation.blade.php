<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container px-5">
        <a class="navbar-brand" href="{{ url('/') }}">{!! $seo_meta['name'] !!}</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                @forelse(menu() as $menu)
                    @if (count(dropdown($menu)) > 0)
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" id="navbarDropdown{{ $menu->id }}" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">Sample Pages</a>
                                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdownBlog{{ $menu->id }}">
                                    @forelse(dropdown($menu) as $dropdown)
                                        <li><a class="dropdown-item" href="{{ $dropdown->is_page == 0 ? $dropdown->link : $dropdown->page->slug }}" {{ $dropdown->open_in_new_tab == 1 ? 'target="_blank"' : '' }}>{{ $dropdown->name }}</a></li>
                                    @empty
                                    @endforelse
                                </ul>  
                            </a>
                        </li>
                    @else 
                        <li class="nav-item">
                            <a class="nav-link" href="{{ $menu->is_page == 0 ? $menu->link : $menu->page->slug }}" {{ $menu->open_in_new_tab == 1 ? 'target="_blank"' : '' }}>{{ $menu->name }}</a>
                        </li>
                    @endif
                @empty
                @endforelse
            </ul>
        </div>
    </div>
</nav>