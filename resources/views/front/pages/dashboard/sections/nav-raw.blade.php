<div class="dashboard__tab-menu">
    <ul class="nav flex-colum nav-pills">
        <li class="nav-item">
            <a class="nav-link {{ request()->is('dashboard') ? 'active' : '' }}" href="{{url('dashboard')}}">
                <div class="row align-items-center">
                    <div class="col-md-3">
                        <div class="icon">
                            <i class="fas fa-tachometer-alt"></i>
                        </div>
                    </div>
                    <div class="col-md-9">
                        <h3>Dashboard</h3>
                    </div>
                </div>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ request()->is('orders') ? 'active' : '' }}" href="{{url('orders')}}">
                <div class="row">
                    <div class="col-md-3">
                        <div class="icon">
                            <i class="fas fa-shopping-cart"></i>
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
                            <i class="fas fa-map-marker-alt"></i>
                        </div>
                    </div>
                    <div class="col-md-9">
                        <h3>Addresses</h3>
                    </div>
                </div>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ request()->is('account-details') ? 'active' : '' }}" href="{{url('account-details')}}">
                <div class="row">
                    <div class="col-md-3">
                        <div class="icon">
                            <i class="fas fa-user-cog"></i>
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
                            <i class="fas fa-sign-out-alt"></i>
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