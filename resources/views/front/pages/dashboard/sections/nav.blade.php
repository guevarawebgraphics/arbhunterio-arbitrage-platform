<div class="dashboard__tab-menu">
    <ul class="nav flex-colum nav-pills">
        <li class="nav-item">
            <a class="nav-link {{ request()->is('dashboard') ? 'active' : '' }}" href="{{url('dashboard')}}">
                <div class="row align-items-center">
                    <div class="col-md-3">
                        <div class="icon">
                            <i class="bi bi-card-list"></i>
                        </div>
                    </div>
                    <div class="col-md-9">
                        <h3>Dashboard</h3>
                    </div>
                </div>
            </a>
        </li>
        {{-- <li class="nav-item">
            <a class="nav-link {{ request()->is('orders') ? 'active' : '' }}" href="{{url('orders')}}">
                <div class="row">
                    <div class="col-md-3">
                        <div class="icon">
                            <i class="bi bi-cart-check"></i>
                        </div>
                    </div>
                    <div class="col-md-9">
                        <h3>Orders</h3>
                    </div>
                </div>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ request()->is('address') ? 'active' : '' }}" href="{{url('address')}}">
                <div class="row">
                    <div class="col-md-3">
                        <div class="icon">
                            <i class="bi bi-card-heading"></i>
                        </div>
                    </div>
                    <div class="col-md-9">
                        <h3>Addresses</h3>
                    </div>
                </div>
            </a>
        </li> --}}
        <li class="nav-item">
            <a class="nav-link {{ request()->is('account-details/overview') ? 'active' : '' }}" href="{{ url('account-details/overview') }}">
                <div class="row">
                    <div class="col-md-3">
                        <div class="icon">
                            <i class="bi bi-gear"></i>
                        </div>
                    </div>
                    <div class="col-md-9">
                        <h3>Account Details</h3>
                    </div>
                </div>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{ route('user.logout') }}">
                <div class="row">
                    <div class="col-md-3">
                        <div class="icon">
                            <i class="bi bi-arrow-left-circle"></i>
                        </div>
                    </div>
                    <div class="col-md-9">
                        <h3>Logout</h3>
                    </div>
                </div>
            </a>
        </li>
    </ul>
</div>