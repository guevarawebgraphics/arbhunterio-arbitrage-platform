<section>
        <!-- Left Sidebar -->
        <aside id="leftsidebar" class="sidebar">
            <!-- User Info -->
            <div class="user-info">
                <div class="image">
                    <img src="{{ asset('public/bsbmd/images/user.png') }}" width="48" height="48" alt="User" />
                </div>
                <div class="info-container">
                    <div class="name" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">{{ auth()->user()->name }}</div>
                    <div class="email">{{ auth()->user()->email }}</div>
                    <div class="btn-group user-helper-dropdown">
                        <i class="material-icons" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">keyboard_arrow_down</i>
                        <ul class="dropdown-menu pull-right">
                            <li><a href="{{ route('admin.profile') }}"><i class="material-icons">person</i>Profile</a></li>
                            {{-- <li role="seperator" class="divider"></li>
                            <li><a href="javascript:void(0);"><i class="material-icons">group</i>Followers</a></li>
                            <li><a href="javascript:void(0);"><i class="material-icons">shopping_cart</i>Sales</a></li>
                            <li><a href="javascript:void(0);"><i class="material-icons">favorite</i>Likes</a></li> --}}
                            <li role="seperator" class="divider"></li>
                            <li><a href="{{ url('/admin/logout') }}"><i class="material-icons">input</i>Sign Out</a></li>
                        </ul>
                    </div>
                </div>
            </div>
            <!-- #User Info -->
            <!-- Menu -->
            <div class="menu">
                @if ($admin_primary_nav)
                    <!-- Sidebar Navigation -->
                        <ul class="list">
                            <li class="header">MAIN NAVIGATION</li>

                            @foreach( $admin_primary_nav as $key => $link )
                                <?php
                                $link_class = '';
                                $li_active = '';
                                $menu_link = '';
                                $toggled_menu = '';

                                // Get 1st level link's vital info
                                $url = (isset($link['url']) && $link['url']) ? $link['url'] : '#';
                                $active = (isset($link['url']) && (strpos($admin_template['active_page'], $link['url']) !== FALSE) && (!isset($link['never_active']))) ? ' active' : '';
                                $never_active = isset($link['never_active']) ? ' target="_blank"' : '';
                                $icon = (isset($link['icon']) && $link['icon']) ? '<i class="material-icons">' . $link['icon'] . '</i>' : '';

                                // Check if the link has a submenu
                                if (isset($link['sub']) && $link['sub']) :
                                    // Since it has a submenu, we need to check if we have to add the class active
                                    // to its parent li element (only if a 2nd or 3rd level link is active)
                                    foreach ($link['sub'] as $sub_link) :
                                        if (isset($sub_link['url'])) :
                                            if (strpos($admin_template['active_page'], $sub_link['url']) !== FALSE) :
                                                $li_active = ' class="active"';
                                                $toggled_menu = ' toggled';
                                                break;
                                            endif;
                                            if ((strpos($admin_template['active_page'], 'options') !== FALSE) && ($sub_link['name'] == 'Product Options Entries')
                                                || (strpos($admin_template['active_page'], 'quote_options') !== FALSE) && ($sub_link['name'] == 'Quote Options Entries'))
                                                :
                                                $li_active = ' class="active"';
                                                break;
                                            endif;
                                        endif;

                                        // 3rd level links
                                        if (isset($sub_link['sub']) && $sub_link['sub']) :
                                            foreach ($sub_link['sub'] as $sub2_link) :
                                                if (strpos($admin_template['active_page'], $sub2_link['url']) !== FALSE) :
                                                    $li_active = ' class="active"';
                                                    break;
                                                endif;
                                            endforeach;
                                        endif;
                                    endforeach;

                                    $menu_link = '';
                                endif;

                                // Create the class attribute for our link
                                if ($menu_link || $active) :
                                    $link_class = ' class="' . $menu_link . $active . ' active"';
                                    $li_active = ' class="active"';
                                endif;
                                ?>
                                @if ($url == 'header')
                                    <li class="sidebar-header">
                                        @if (isset($link['opt']) && $link['opt'])
                                            <span class="sidebar-header-options clearfix">{!! $link['opt'] !!}</span>
                                        @endif
                                        <span class="sidebar-header-title">{!! $link['name'] !!}</span>
                                    </li>
                                @else
                                    <li{!! $li_active !!}>
                                            @if (isset($link['sub']) && $link['sub'])
                                                <a href="{!! $url !!}" class="menu-toggle {!! $toggled_menu !!}" {!! $link_class !!}>
                                            @else 
                                                <a href="{!! $url !!}" {!! $link_class !!} {!! $never_active !!}>
                                            @endif
                                            {!! $icon !!}
                                            <span class="sidebar-nav-mini-hide">{!! $link['name'] !!}</span>
                                        </a>
                                        @if (isset($link['sub']) && $link['sub'])
                                            <ul class="ml-menu">
                                                @foreach ($link['sub'] as $sub_link)
                                                    <?php
                                                    $link_class = '';
                                                    $li_active = '';
                                                    $submenu_link = '';

                                                    // Get 2nd level link's vital info
                                                    $url = (isset($sub_link['url']) && $sub_link['url']) ? $sub_link['url'] : '#';
                                                    $active = (isset($sub_link['url']) && (strpos($admin_template['active_page'], $sub_link['url']) !== FALSE) && (!isset($sub_link['never_active'])))
                                                    || (strpos($admin_template['active_page'], 'options') !== FALSE && $sub_link['name'] == 'Product Options Entries' && $sub_link['name'] != 'Quote Options Entries' && strpos($admin_template['active_page'], 'quote_options') == FALSE)
                                                    || (strpos($admin_template['active_page'], 'quote_options') !== FALSE && $sub_link['name'] == 'Quote Options Entries')
                                                        ? ' active' : '';

                                                    // Check if the link has a submenu
                                                    if (isset($sub_link['sub']) && $sub_link['sub']) :
                                                        // Since it has a submenu, we need to check if we have to add the class active
                                                        // to its parent li element (only if a 3rd level link is active)
                                                        foreach ($sub_link['sub'] as $sub2_link) :
                                                            if (isset($sub2_link['url'])) :
                                                                if (strpos($admin_template['active_page'], $sub2_link['url']) !== FALSE) :
                                                                    $li_active = ' class="active"';
                                                                    break;
                                                                endif;
                                                            endif;
                                                        endforeach;

                                                        $submenu_link = 'sidebar-nav-submenu';
                                                    endif;

                                                    if ($submenu_link || $active) :
                                                        $link_class = ' class="' . $submenu_link . $active . '"';
                                                    endif;
                                                    ?>
                                                    <li class="{!! $active !!}">
                                                        <a href="{!! $url !!}" {!! $link_class !!}>
                                                            @if (isset($sub_link['sub']) && $sub_link['sub'])
                                                                <i class="fa fa-angle-left sidebar-nav-indicator"></i>
                                                            @endif
                                                            {!! $sub_link['name'] !!}
                                                        </a>
                                                        @if (isset($sub_link['sub']) && $sub_link['sub'])
                                                            <ul>
                                                                <?php
                                                                foreach ($sub_link['sub'] as $sub2_link) :
                                                                // Get 3rd level link's vital info
                                                                $url = (isset($sub2_link['url']) && $sub2_link['url']) ? $sub2_link['url'] : '#';
                                                                $active = (isset($sub2_link['url']) && (strpos($admin_template['active_page'], $sub2_link['url']) !== FALSE) && (!isset($sub2_link['never_active']))) ? ' class="active"' : '';
                                                                ?>
                                                                <li>
                                                                    <a href="{!! $url !!}"{!! $active !!}>{!! $sub2_link['name'] !!}</a>
                                                                </li>
                                                                <?php endforeach; ?>
                                                            </ul>
                                                        @endif
                                                    </li>
                                                @endforeach
                                            </ul>
                                        @endif
                                    </li>
                                @endif
                            @endforeach
                        </ul>
                        <!-- END Sidebar Navigation -->
                @endif
            </div>
            <!-- #Menu -->
            <!-- Footer -->
            <div class="legal">
                <div class="copyright">
                    &copy; {{ date('Y') }} <a href="javascript:void(0);">{{ getSystemSetting('BJCDL_001')->value }}</a>.
                </div>
                <div class="version">
                    {{ getSystemSetting('BJCDL_002')->value }}
                </div>
            </div>
            <!-- #Footer -->
        </aside>
        <!-- #END# Left Sidebar -->
    </section>