<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Http\Traits\SystemSettingTrait;

class AdminTemplateProvider extends ServiceProvider
{
    use SystemSettingTrait;

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        view()->composer(['auth.app', 'index'], function ($view) {
            /*global variables*/
            $seo_meta = $this->getSeoMeta();
            $system_settings = $this->getSystemSettings();
            $logged_user = auth()->user();
            $logged_in = auth()->check();
            /*global variables*/

            $admin_primary_nav = $this->getAdminNav();
            $admin_template = $this->getAdminConfig($seo_meta);

            $view->with(compact(
                'admin_template',
                'system_settings',
                'logged_user',
                'logged_in',
                'admin_primary_nav'
            ));
        });
    }

    private function getAdminNav()
    {
        $navigation = [
            [
                'name' => 'Dashboard',
                'url' => url('admin/dashboard'),
                'icon' => 'home'
            ],
            [
                'name' => 'View Front-end',
                'url' => url('/'),
                'never_active' => true,
                'icon' => 'pageview'
            ],
        ];

        if (auth()->check()) {

            if ($this->hasCrudAccessFor('Page')) {
                array_push($navigation, [
                    'name' => 'Page Management',
                    'url' => url('admin/pages'),
                    'icon' => 'subtitles'
                ]);
            }

            if ($this->hasCrudAccessFor('Menu') || $this->hasCrudAccessFor('Menu Dropdown')) {
                $menu_management = [];

                if ($this->hasCrudAccessFor('Menu')) {
                    array_push($menu_management, [
                        'name' => 'Menu',
                        'url' => url('admin/menu'),
                    ]);
                }

                if ($this->hasCrudAccessFor('Menu Dropdown')) {
                    array_push($menu_management, [
                        'name' => 'Menu Dropdown',
                        'url' => url('admin/dropdown_menu'),
                    ]);
                }

                array_push($navigation, [
                    'name' => 'Menu Management',
                    'icon' => 'menu',
                    'sub' => $menu_management
                ]);
            }

            if ($this->hasCrudAccessFor('Gallery Group') || $this->hasCrudAccessFor('Gallery Image')) {
                $gallery_tab = [];

                if ($this->hasCrudAccessFor('Gallery Group')) {
                    array_push($gallery_tab, [
                        'name' => 'Gallery Groups',
                        'url' => url('admin/gallery_groups'),
                    ]);
                }

                if ($this->hasCrudAccessFor('Gallery Image')) {
                    array_push($gallery_tab, [
                        'name' => 'Gallery Images',
                        'url' => url('admin/gallery_images'),
                    ]);
                }

                array_push($navigation, [
                    'name' => 'Gallery Management',
                    'icon' => 'collections',
                    'sub' => $gallery_tab
                ]);
            }

            if ($this->hasCrudAccessFor('Blog Category') || $this->hasCrudAccessFor('Blog')) {
                $gallery_tab = [];

                if ($this->hasCrudAccessFor('Blog Category')) {
                    array_push($gallery_tab, [
                        'name' => 'Blog Categories',
                        'url' => url('admin/blog_categories'),
                    ]);
                }

                if ($this->hasCrudAccessFor('Blog')) {
                    array_push($gallery_tab, [
                        'name' => 'Blogs',
                        'url' => url('admin/blogs'),
                    ]);
                }

                array_push($navigation, [
                    'name' => 'Blog Posting',
                    'icon' => 'comment',
                    'sub' => $gallery_tab
                ]);
            }

            if ($this->hasCrudAccessFor('Product Category') || $this->hasCrudAccessFor('Product')) {
                $products_tab = [];

                if ($this->hasCrudAccessFor('Product Category')) {
                    array_push($products_tab, [
                        'name' => 'Product Categories',
                        'url' => url('admin/product_categories'),
                    ]);
                }

                if ($this->hasCrudAccessFor('Product')) {
                    array_push($products_tab, [
                        'name' => 'Products',
                        'url' => url('admin/products'),
                    ]);
                }

                array_push($navigation, [
                    'name' => 'Products',
                    'icon' => 'shopping_basket',
                    'sub' => $products_tab
                ]);
            }

            if ($this->hasCrudAccessFor('Coupon Code')) {
                array_push($navigation, [
                    'name' => 'Coupon Codes',
                    'url' => url('admin/coupon_codes'),
                    'icon' => 'loyalty'
                ]);
            }

            if ($this->hasCrudAccessFor('Tax')) {
                array_push($navigation, [
                    'name' => 'Taxes & Shipping',
                    'url' => url('admin/taxes'),
                    'icon' => 'attach_money'
                ]);
            }

            if ($this->hasCrudAccessFor('Contact')) {
                array_push($navigation, [
                    'name' => 'Contacts',
                    'url' => url('admin/contacts'),
                    'icon' => 'phone'
                ]);
            }

            if ($this->hasCrudAccessFor('Newsletter')) {
                array_push($navigation, [
                    'name' => 'Newsletter Subscribers',
                    'url' => url('admin/newsletters'),
                    'icon' => 'email'
                ]);
            }
            
            if ($this->hasCrudAccessFor('User') || $this->hasCrudAccessFor('Permission') || $this->hasCrudAccessFor('Permission Group') || $this->hasCrudAccessFor('Role')) {
                $user_management_tab = [];

                if ($this->hasCrudAccessFor('User')) {
                    array_push($user_management_tab, [
                        'name' => 'Users',
                        'url' => url('admin/users'),
                    ]);
                }

                if ($this->hasCrudAccessFor('Permission Group')) {
                    array_push($user_management_tab, [
                        'name' => 'Permission Groups',
                        'url' => url('admin/permission_groups'),
                    ]);
                }

                if ($this->hasCrudAccessFor('Permission')) {
                    array_push($user_management_tab, [
                        'name' => 'Permissions',
                        'url' => url('admin/permissions'),
                    ]);
                }


                if ($this->hasCrudAccessFor('Role')) {
                    array_push($user_management_tab, [
                        'name' => 'Roles',
                        'url' => url('admin/roles'),
                    ]);
                }

                array_push($navigation, [
                    'name' => 'Access Management',
                    'icon' => 'perm_contact_calendar',
                    'sub' => $user_management_tab
                ]);
            }

            if ($this->hasCrudAccessFor('System Setting')) {
                array_push($navigation, [
                    'name' => 'System Management',
                    'url' => url('admin/system_settings'),
                    'icon' => 'settings'
                ]);
            }

            if ($this->hasCrudAccessFor('Activity Log')) {
                array_push($navigation, [
                    'name' => 'Activity Logs',
                    'url' => url('admin/activity_logs'),
                    'icon' => 'compare_arrows'
                ]);
            }
        }

        return $navigation;
    }

    private function hasCrudAccessFor($module)
    {
        return auth()->user()->hasAnyPermission([
            "Create {$module}",
            "Read {$module}",
            "Update {$module}",
            "Delete {$module}",
        ]);
    }

    private function getAdminConfig($seo_meta)
    {
        return [
            'name' => $seo_meta['name'],
            'version' => '2.0',
            'author' => $seo_meta['author'],
            'robots' => $seo_meta['robots'],
            'title' => $seo_meta['title'],
            'description' => $seo_meta['description'],
            // true                     enable page preloader
            // false                    disable page preloader
            'page_preloader' => true,
            // true                     enable main menu auto scrolling when opening a submenu
            // false                    disable main menu auto scrolling when opening a submenu
            'menu_scroll' => true,
            // 'navbar-default'         for a light header
            // 'navbar-inverse'         for a dark header
            'header_navbar' => 'navbar-inverse',
            // ''                       empty for a static layout
            // 'navbar-fixed-top'       for a top fixed header / fixed sidebars
            // 'navbar-fixed-bottom'    for a bottom fixed header / fixed sidebars
            'header' => 'navbar-fixed-top',
            // ''                                               for a full main and alternative sidebar hidden by default (> 991px)
            // 'sidebar-visible-lg'                             for a full main sidebar visible by default (> 991px)
            // 'sidebar-partial'                                for a partial main sidebar which opens on mouse hover, hidden by default (> 991px)
            // 'sidebar-partial sidebar-visible-lg'             for a partial main sidebar which opens on mouse hover, visible by default (> 991px)
            // 'sidebar-mini sidebar-visible-lg-mini'           for a mini main sidebar with a flyout menu, enabled by default (> 991px + Best with static layout)
            // 'sidebar-mini sidebar-visible-lg'                for a mini main sidebar with a flyout menu, disabled by default (> 991px + Best with static layout)
            // 'sidebar-alt-visible-lg'                         for a full alternative sidebar visible by default (> 991px)
            // 'sidebar-alt-partial'                            for a partial alternative sidebar which opens on mouse hover, hidden by default (> 991px)
            // 'sidebar-alt-partial sidebar-alt-visible-lg'     for a partial alternative sidebar which opens on mouse hover, visible by default (> 991px)
            // 'sidebar-partial sidebar-alt-partial'            for both sidebars partial which open on mouse hover, hidden by default (> 991px)
            // 'sidebar-no-animations'                          add this as extra for disabling sidebar animations on large screens (> 991px) - Better performance with heavy pages!
            'sidebar' => 'sidebar-visible-lg sidebar-mini sidebar-no-animations',
            // ''                       empty for a static footer
            // 'footer-fixed'           for a fixed footer
            'footer' => '',
            // ''                       empty for default style
            // 'style-alt'              for an alternative main style (affects main page background as well as blocks style)
            'main_style' => '',
            // ''                           Disable cookies (best for setting an active color theme from the next variable)
            // 'enable-cookies'             Enables cookies for remembering active color theme when changed from the sidebar links (the next color theme variable will be ignored)
            'cookies' => '',
            // 'night', 'amethyst', 'modern', 'autumn', 'flatie', 'spring', 'fancy', 'fire', 'coral', 'lake',
            // 'forest', 'waterlily', 'emerald', 'blackberry' or '' leave empty for the Default Blue theme
            'theme' => 'flatie',
            // ''                       for default content in header
            // 'horizontal-menu'        for a horizontal menu in header
            // This option is just used for feature demostration and you can remove it if you like. You can keep or alter header's content in page_head.blade.php
            'header_content' => '',
            'active_page' => url()->current() /*basename($_SERVER['PHP_SELF'])*/
        ];
    }

}
