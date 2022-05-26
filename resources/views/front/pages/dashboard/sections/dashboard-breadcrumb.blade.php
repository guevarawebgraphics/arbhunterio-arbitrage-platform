<section class="breadcrumb-nav">
    <div class="breadcrumb-nav__wrapper wrapper">
        <div class="breadcrumb-nav__content">
            <div class="row">
                <div class="col-md-12 breadcrumb-nav__content__steps">
                    <ul>
                        <li>
                            <a href="{{ url('/') }}">
                                <small>Home</small>
                            </a>
                        </li>

                        <li>
                            @if(request()->is('dashboard'))
                                    <a href="{{ url('dashboard') }}">  
                                        <small><strong>Dashboard</strong></small>
                                    </a>
                            @elseif(request()->is('orders'))
                                <a href="{{ url('orders') }}">  
                                    <small><strong>Orders</strong></small>
                                </a>
                            @elseif(request()->is('address'))
                                <a href="{{ url('address') }}">  
                                    <small><strong>Addresses</strong></small>
                                </a>
                            @elseif(request()->is('account-details'))
                                <a href="{{ url('account-details') }}">  
                                    <small><strong>Account Details</strong></small>
                                </a>
                            @endif
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>