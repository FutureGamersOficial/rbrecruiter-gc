<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Title
    |--------------------------------------------------------------------------
    |
    | Here you can change the default title of your admin panel.
    |
    | For more detailed instructions you can look here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/#61-title
    |
    */

    'title' => env('APP_NAME'),
    'title_prefix' => '',
    'title_postfix' => '',

    /*
    |--------------------------------------------------------------------------
    | Favicon
    |--------------------------------------------------------------------------
    |
    | Here you can activate the favicon.
    |
    | For more detailed instructions you can look here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/#62-favicon
    |
    */

    'use_ico_only' => false,
    'use_full_favicon' => false,

    /*
    |--------------------------------------------------------------------------
    | Logo
    |--------------------------------------------------------------------------
    |
    | Here you can change the logo of your admin panel.
    |
    | For more detailed instructions you can look here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/#63-logo
    |
    */

    'logo' => env('APP_NAME'),
    'logo_img' => env('APP_LOGO'),
    'logo_img_class' => 'brand-image img-circle elevation-3',
    'logo_img_xl' => null,
    'logo_img_xl_class' => 'brand-image-xs',
    'logo_img_alt' => env('APP_NAME') . '\'s Temporary Logo',

    /*
    |--------------------------------------------------------------------------
    | User Menu
    |--------------------------------------------------------------------------
    |
    | Here you can activate and change the user menu.
    |
    | For more detailed instructions you can look here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/#64-user-menu
    |
    */

    'usermenu_enabled' => true,
    'usermenu_header' => false,
    'usermenu_header_class' => 'bg-primary',
    'usermenu_image' => false,
    'usermenu_desc' => false,

    /*
    |--------------------------------------------------------------------------
    | Layout
    |--------------------------------------------------------------------------
    |
    | Here we change the layout of your admin panel.
    |
    | For more detailed instructions you can look here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/#65-layout
    |
    */

    'layout_topnav' => null,
    'layout_boxed' => null,
    'layout_fixed_sidebar' => null,
    'layout_fixed_navbar' => null,
    'layout_fixed_footer' => null,

    /*
    |--------------------------------------------------------------------------
    | Extra Classes
    |--------------------------------------------------------------------------
    |
    | Here you can change the look and behavior of the admin panel.
    |
    | For more detailed instructions you can look here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/#66-classes
    |
    */

    'classes_body' => '',
    'classes_brand' => '',
    'classes_brand_text' => '',
    'classes_content_header' => '',
    'classes_content' => '',
    'classes_sidebar' => 'sidebar-dark-primary elevation-4',
    'classes_sidebar_nav' => '',
    'classes_topnav' => 'navbar-white navbar-light',
    'classes_topnav_nav' => 'navbar-expand-md',
    'classes_topnav_container' => 'container',

    /*
    |--------------------------------------------------------------------------
    | Sidebar
    |--------------------------------------------------------------------------
    |
    | Here we can modify the sidebar of the admin panel.
    |
    | For more detailed instructions you can look here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/#67-sidebar
    |
    */

    'sidebar_mini' => true,
    'sidebar_collapse' => false,
    'sidebar_collapse_auto_size' => false,
    'sidebar_collapse_remember' => false,
    'sidebar_collapse_remember_no_transition' => true,
    'sidebar_scrollbar_theme' => 'os-theme-light',
    'sidebar_scrollbar_auto_hide' => 'l',
    'sidebar_nav_accordion' => true,
    'sidebar_nav_animation_speed' => 300,

    /*
    |--------------------------------------------------------------------------
    | Control Sidebar (Right Sidebar)
    |--------------------------------------------------------------------------
    |
    | Here we can modify the right sidebar aka control sidebar of the admin panel.
    |
    | For more detailed instructions you can look here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/#68-control-sidebar-right-sidebar
    |
    */

    'right_sidebar' => false,
    'right_sidebar_icon' => 'fas fa-cogs',
    'right_sidebar_theme' => 'dark',
    'right_sidebar_slide' => true,
    'right_sidebar_push' => true,
    'right_sidebar_scrollbar_theme' => 'os-theme-light',
    'right_sidebar_scrollbar_auto_hide' => 'l',

    /*
    |--------------------------------------------------------------------------
    | URLs
    |--------------------------------------------------------------------------
    |
    | Here we can modify the url settings of the admin panel.
    |
    | For more detailed instructions you can look here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/#69-urls
    |
    */

    'use_route_url' => false,

    'dashboard_url' => '/dashboard',

    'logout_url' => '/auth/logout',

    'login_url' => '/auth/login',

    'register_url' => '/auth/register',

    'password_reset_url' => '/auth/password/reset',

    'password_email_url' => '/auth/password/email',

    'profile_url' => false,

    /*
    |--------------------------------------------------------------------------
    | Laravel Mix
    |--------------------------------------------------------------------------
    |
    | Here we can enable the Laravel Mix option for the admin panel.
    |
    | For more detailed instructions you can look here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/#610-laravel-mix
    |
    */

    'enabled_laravel_mix' => false,

    /*
    |--------------------------------------------------------------------------
    | Menu Items
    |--------------------------------------------------------------------------
    |
    | Here we can modify the sidebar/top navigation of the admin panel.
    |
    | For more detailed instructions you can look here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/#611-menu
    |
    */

    'menu' => [
        [
            'text' => 'm_home',
            'icon' => 'fas fa-home',
            'url' => 'dashboard'
        ],
        [
            'text' => 'm_directory',
            'icon' => 'fas fa-users',
            'url' => 'users/directory',
            'can' => 'profiles.view.others'
        ],
        [
            'header' => 'h_applications',
            'can' => 'applications.view.own'
        ],
        [
            'text' => 'm_my_applications',
            'icon'  => 'fas fa-fw fa-list-ul',
            'can' => 'applications.view.own',
            'submenu' => [
                [
                    'text' => 'm_curr_applications',
                    'icon' => 'fas fa-fw fa-check-double',
                    'url' => '/applications/my-applications'
                ]
            ],

        ],
        'h_my_profile',
        [
            'text' => 'm_profile_settings',
            'url' => '/profile/settings',
            'icon' => 'fas fa-fw fa-cog'
        ],
        [
            'text' => 'm_account_settings',
            'icon' => 'fas fa-user-circle',
            'url' => '/profile/settings/account'
        ],
        [
            'header' => 'h_app_management',
            'can' => ['applications.view.all', 'applications.vote']
        ],
        [
            'text' => 'm_all_apps',
            'url' => 'applications/staff/all',
            'icon' => 'fas fa-list-ol',
            'can' => 'applications.view.all'
        ],
        [
            'text' => 'm_outstanding_apps',
            'url' => '/applications/staff/outstanding',
            'icon' => 'far fa-folder-open',
            'can' => 'applications.view.all'
        ],
        [
            'text' => 'm_interview_queue',
            'url' => '/applications/staff/pending-interview',
            'icon' => 'fas fa-fw fa-microphone-alt',
            'can' => 'applications.view.all'
        ],
        [
            'text' => 'm_peer_approval',
            'url' => '/applications/staff/peer-review',
            'icon' => 'fas fa-fw fa-search',
            'can' => 'applications.view.all'
        ],
        [
            'header' => 'h_administration',
            'can' => [ // may need to be modified
                'admin.hiring.*',
                'admin.userlist',
                'admin.stafflist',
                'admin.hiring.*',
                'admin.notificationsettings.*'
            ]
        ],
        [
            'text' => 'm_staff_members',
            'icon' => 'fas fa-fw fa-users',
            'url' => '/hr/staff-members',
            'can' => 'admin.stafflist'
        ],
        [    // players who haven't been promoted yet
            'text' => 'm_reg_players',
            'icon' => 'fas fa-fw fa-user-friends',
            'url' => '/hr/players',
            'can' => 'admin.userlist'
        ],
        [
            'text' => 'sm_hiring_man',
            'icon' => 'far fa-calendar-plus',
            'can' => 'admin.hiring.*',
            'submenu' => [
                [
                    'text' => 'm_open_pos',
                    'icon' => 'fas fa-box-open',
                    'url' => '/admin/positions'
                ],
                [
                    'text' => 'sm_forms',
                    'icon' => 'fab fa-wpforms',
                    'submenu' => [
                        [
                            'text' => 'sm_all_forms',
                            'icon' => 'far fa-list-alt',
                            'url' => '/admin/forms'
                        ],
                        [
                            'text' => 'm_form_builder',
                            'icon' => 'fas fa-fw fa-hammer',
                            'url' => '/admin/forms/builder'
                        ]
                    ]
                ]
            ]
        ],
        [
            'text' => 'sm_app_settings',
            'icon' => 'fas fa-fw fa-cog',
            'can' => 'admin.notificationsettings',
            'submenu' => [
                [
                    'text' => 'm_global_app_s',
                    'icon' => 'fas fa-cogs',
                    'url' => '/admin/settings',
                    'can' => 'admin.settings.view'
                ],
                [
                    'text' => 'm_devtools',
                    'icon' => 'fas fa-code',
                    'url' => '/admin/devtools',
                    'can' => 'admin.developertools.use'
                ]
            ]
        ],
        [
            'text' => 'm_s_logs',
            'url' => '/admin/maintenance/system-logs',
            'icon' => 'fas fa-clipboard-list',
            'can' => 'admin.maintenance.logs.view'
        ]
    ],

    /*
    |--------------------------------------------------------------------------
    | Menu Filters
    |--------------------------------------------------------------------------
    |
    | Here we can modify the menu filters of the admin panel.
    |
    | For more detailed instructions you can look here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/#612-menu-filters
    |
    */

    'filters' => [
        JeroenNoten\LaravelAdminLte\Menu\Filters\HrefFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\SearchFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\ActiveFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\ClassesFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\GateFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\LangFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\DataFilter::class,
    ],

    /*
    |--------------------------------------------------------------------------
    | Plugins Initialization
    |--------------------------------------------------------------------------
    |
    | Here we can modify the plugins used inside the admin panel.
    |
    | For more detailed instructions you can look here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/#613-plugins
    |
    */

    'plugins' => [
        [
            'name' => 'Datatables',
            'active' => false,
            'files' => [
                [
                    'type' => 'js',
                    'asset' => false,
                    'location' => '//cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js',
                ],
                [
                    'type' => 'js',
                    'asset' => false,
                    'location' => '//cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js',
                ],
                [
                    'type' => 'css',
                    'asset' => false,
                    'location' => '//cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css',
                ],
            ],
        ],
        [
            'name' => 'FormBuilder',
            'active' => true,
            'files' => [
                [
                    'type' => 'js',
                    'asset' => false,
                    'location' => '/js/formbuilder.js'
                ]
            ]
        ],
        [
            'name' => 'Select2',
            'active' => false,
            'files' => [
                [
                    'type' => 'js',
                    'asset' => false,
                    'location' => '//cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js',
                ],
                [
                    'type' => 'css',
                    'asset' => false,
                    'location' => '//cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.css',
                ],
            ],
        ],
        [
            'name' => 'Chartjs',
            'active' => false,
            'files' => [
                [
                    'type' => 'js',
                    'asset' => false,
                    'location' => '//cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.0/Chart.bundle.min.js',
                ],
            ],
        ],
        [
            'name' => 'Sweetalert2',
            'active' => false,
            'files' => [
                [
                    'type' => 'js',
                    'asset' => false,
                    'location' => '//cdn.jsdelivr.net/npm/sweetalert2@8',
                ],
            ],
        ],
        [
            'name' => 'Pace',
            'active' => false,
            'files' => [
                [
                    'type' => 'css',
                    'asset' => false,
                    'location' => '//cdnjs.cloudflare.com/ajax/libs/pace/1.0.2/themes/blue/pace-theme-center-radar.min.css',
                ],
                [
                    'type' => 'js',
                    'asset' => false,
                    'location' => '//cdnjs.cloudflare.com/ajax/libs/pace/1.0.2/pace.min.js',
                ],
            ],
        ],
        [
            'name' => 'Toastr',
            'active' => true,
            'files' => [
                [
                    'type' => 'js',
                    'asset' => false,
                    'location' => 'https://cdn.jsdelivr.net/npm/toastr@2.1.4/toastr.min.js'
                ],
                [
                    'type' => 'css',
                    'asset' => false,
                    'location' => 'https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css'
                ]
            ]
        ],
        [
            'name' => 'GlobalTooltip',
            'active' => true,
            'files' => [
                [
                    'type' => 'js',
                    'asset' => false,
                    'location' => '/js/globaltooltip.js'
                ]
            ]
        ],
        [
            'name' => 'DatePickApp',
            'active' => true,
            'files' => [
                [
                    'type' => 'js',
                    'asset' => false,
                    'location' => '/js/datepick.js'
                ]
            ]
        ],
        [
          'name' => 'Fullcalendar',
          'active' => true,
          'files' => [
            [
              'type' => 'js',
              'asset' => false,
              'location' => 'https://cdn.jsdelivr.net/npm/fullcalendar@5.0.1/main.min.js',
            ],
            [
              'type' => 'css',
              'asset' => false,
              'location' => 'https://cdn.jsdelivr.net/npm/fullcalendar@5.0.1/main.min.css'
            ]
          ]
        ],
        [
          'name' => 'AuthCustomisations',
          'active' => true,
          'files' => [
            [
              'type' => 'css',
              'asset' => false,
              'location' => '/css/authpages.css'
            ]
          ]
        ]
    ],
];
