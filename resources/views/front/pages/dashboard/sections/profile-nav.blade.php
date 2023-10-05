<div class="dashboard__tab-menu">
    <ul class="nav flex-colum nav-pills">
        <li class="nav-item">
            <a class="nav-link {{ request()->is('account-details/overview') ? 'active' : '' }}" href="{{ url('account-details/overview') }}">
                <div class="row align-items-center">
                    <div class="col-md-3">
                        <div class="icon">
                            <i class="bi bi-person-circle"></i>
                        </div>
                    </div>
                    <div class="col-md-9">
                        <h3>Overview</h3>
                    </div>
                </div>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ request()->is('account-details/general-settings') ? 'active' : '' }}" href="{{ url('account-details/general-settings') }}">
                <div class="row">
                    <div class="col-md-3">
                        <div class="icon">
                            <i class="bi bi-gear"></i>
                        </div>
                    </div>
                    <div class="col-md-9">
                        <h3>General Settings</h3>
                    </div>
                </div>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ request()->is('account-details/manage-subscription') ? 'active' : '' }}" href="{{ url('account-details/manage-subscription') }}">
                <div class="row">
                    <div class="col-md-3">
                        <div class="icon">
                            <i class="bi bi-credit-card"></i>
                        </div>
                    </div>
                    <div class="col-md-9">
                        <h3>Manage Subscription</h3>
                    </div>
                </div>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ request()->is('account-details/manage-filters') ? 'active' : '' }}" href="{{ url('account-details/manage-filters') }}">
                <div class="row">
                    <div class="col-md-3">
                        <div class="icon">
                            <i class="bi bi-book"></i>
                        </div>
                    </div>
                    <div class="col-md-9">
                        <h3>Manage Filters</h3>
                    </div>
                </div>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ request()->is('account-details/bet-tracker-notifications') ? 'active' : '' }}" href="{{ url('account-details/bet-tracker-notifications') }}">
                <div class="row">
                    <div class="col-md-3">
                        <div class="icon">
                            <i class="bi bi-bell"></i>
                        </div>
                    </div>
                    <div class="col-md-9">
                        <h3>Bet Tracker Notifications</h3>
                    </div>
                </div>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ request()->is('account-details/bankroll-settings') ? 'active' : '' }}" href="{{ url('account-details/bankroll-settings') }}">
                <div class="row">
                    <div class="col-md-3">
                        <div class="icon">
                            <i class="bi bi-cash-coin"></i>
                        </div>
                    </div>
                    <div class="col-md-9">
                        <h3>Bankroll Settings</h3>
                    </div>
                </div>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ request()->is('account-details/manage-injury-notifications') ? 'active' : '' }}" href="{{ url('account-details/manage-injury-notifications') }}">
                <div class="row">
                    <div class="col-md-3">
                        <div class="icon">
                            <i class="bi bi-clipboard-plus"></i>
                        </div>
                    </div>
                    <div class="col-md-9">
                        <h3>Manage Injury Notifications</h3>
                    </div>
                </div>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ request()->is('account-details/betting-tool-notifications') ? 'active' : '' }}" href="{{ url('account-details/betting-tool-notifications') }}">
                <div class="row">
                    <div class="col-md-3">
                        <div class="icon">
                            <i class="bi bi-bell"></i>
                        </div>
                    </div>
                    <div class="col-md-9">
                        <h3>Betting Tool Notifications</h3>
                    </div>
                </div>
            </a>
        </li>
    </ul>
</div>