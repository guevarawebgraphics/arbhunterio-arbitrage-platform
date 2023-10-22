<div class="dashboard__tab-menu">
    <ul class="nav flex-colum nav-pills">
        <li class="nav-item">
            <a class="nav-link {{ request()->is('settings/overview') ? 'active' : '' }}" href="{{ url('settings/overview') }}">
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
            <a class="nav-link {{ request()->is('settings/general-settings') ? 'active' : '' }}" href="{{ url('settings/general-settings') }}">
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
            <a class="nav-link {{ request()->is('settings/manage-subscription') ? 'active' : '' }}" href="{{ url('settings/manage-subscription') }}">
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
            <a class="nav-link {{ request()->is('settings/manage-filters') ? 'active' : '' }}" href="{{ url('settings/manage-filters') }}">
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
            <a class="nav-link {{ request()->is('settings/bet-tracker-notifications') ? 'active' : '' }}" href="{{ url('settings/bet-tracker-notifications') }}">
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
            <a class="nav-link {{ request()->is('settings/bankroll-settings') ? 'active' : '' }}" href="{{ url('settings/bankroll-settings') }}">
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
            <a class="nav-link {{ request()->is('settings/manage-injury-notifications') ? 'active' : '' }}" href="{{ url('settings/manage-injury-notifications') }}">
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
            <a class="nav-link {{ request()->is('settings/betting-tool-notifications') ? 'active' : '' }}" href="{{ url('settings/betting-tool-notifications') }}">
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