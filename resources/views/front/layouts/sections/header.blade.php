<!-- Navigation-->
@include('front.layouts.sections.navigation')

@if( !in_array(url()->current() , [ url('dashboard'),  url('account-details'), url('account-details/overview') ] ))
    <!-- Header-->
    <header class="bg-dark py-5">
        <div class="container px-5">
            <div class="row gx-5 align-items-center justify-content-center">

                <div class="col-lg-8 col-xl-7 col-xxl-6">
                    <div class="my-5 text-center text-xl-start">
                        <h1 class="display-5 fw-bolder text-white mb-2">A powerfull, no-coding required application</h1>
                        <p class="lead fw-normal text-white-50 mb-4">Perfect for your web needs that requires almost no support from developers. You can maintain it all by yourself, even without a broad knowledge about coding.</p>
                        <div class="d-grid gap-3 d-sm-flex justify-content-sm-center justify-content-xl-start">
                            <a class="btn btn-primary btn-lg px-4 me-sm-3" href="#features">Get Started</a>
                            <a class="btn btn-outline-light btn-lg px-4" href="{{ url('about-us') }}">Learn More</a>
                        </div>
                    </div>
                </div>
            
                <div class="col-xl-5 col-xxl-6 d-none d-xl-block text-center">
                    @include('front.components.slider', ['sliders' => gallery('Home Sliders')])
                </div>
            </div>
        </div>
    </header>
  @endif