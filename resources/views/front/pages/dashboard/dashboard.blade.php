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
                                    <h2>Arbitrage Bets</h2>
                                    <p>Lorem ipsum dolor sit, amet consectetur adipisicing elit.</p>
                                    <table class="table">
                                        <thead class="thead-dark">
                                            <tr>
                                                <th scope="col">

                                                </th>
                                                <th scope="col">
                                                    
                                                </th>
                                                <th scope="col">Percent</th>
                                                <th scope="col">Event Date</th>
                                                <th scope="col">Event</th>
                                                <th scope="col">Market</th>
                                                <th scope="col">Bet</th>
                                                <th scope="col">Books</th>
                                                <th scope="col">Pinny</th>
                                                <th scope="col">Updated</th>
                                                <th scope="col">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody id="arbitrage_body">

                                        
                                        </tbody>
                                    </table>
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


@section('extra-script')

    <script>
        var sBaseURI = '{{ url('/') }}';
    </script>
    
    {{Html::script('public/js/bjcdl/libraries/dashboard.js')}}

@endsection