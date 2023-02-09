<?php

use App\Http\Middleware\SetUserTimezone;
use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Http\Middleware\MirrorConfigToSubpackages;
use Filament\Pages;
use Filament\Widgets;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\AuthenticateSession;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;
use App\Filament\Auth\Login;
use App\Filament\Widgets\AttendanceCalendar;
use App\Filament\Widgets\CustomLatestUser;
use App\Filament\Widgets\EmployeeAttendance;
use Phpsa\FilamentAuthentication\Widgets\LatestUsersWidget;

return [

    /*
    |--------------------------------------------------------------------------
    | Filament Path
    |--------------------------------------------------------------------------
    |
    | The default is `admin` but you can change it to whatever works best and
    | doesn't conflict with the routing in your application.
    |
    */

    'path' => env('FILAMENT_PATH', 'cp-dashboard'),


    /*
    |--------------------------------------------------------------------------
    | Filament Core Path
    |--------------------------------------------------------------------------
    |
    | This is the path which Filament will use to load its core routes and assets.
    | You may change it if it conflicts with your other routes.
    |
    */

    'core_path' => env('FILAMENT_CORE_PATH', 'filament'),


    /*
    |--------------------------------------------------------------------------
    | Filament Domain
    |--------------------------------------------------------------------------
    |
    | You may change the domain where Filament should be active. If the domain
    | is empty, all domains will be valid.
    |
    */

    'domain' => env('FILAMENT_DOMAIN'),

    /*
    |--------------------------------------------------------------------------
    | Homepage URL
    |--------------------------------------------------------------------------
    |
    | This is the URL that Filament will redirect the user to when they click
    | on the sidebar's header.
    |
    */

    'home_url' => '/',

    /*
    |--------------------------------------------------------------------------
    | Brand Name
    |--------------------------------------------------------------------------
    |
    | This will be displayed on the login page and in the sidebar's header.
    |
    */

    'brand' => env('APP_NAME'),

    /*
    |--------------------------------------------------------------------------
    | Auth
    |--------------------------------------------------------------------------
    |
    | This is the configuration that Filament will use to handle authentication
    | into the admin panel.
    |
    */

    'auth' => [
        'guard' => env('FILAMENT_AUTH_GUARD', 'web'),
        'pages' => [
            // 'login' => \Filament\Http\Livewire\Auth\Login::class,
            'login' => Login::class
        ],
        'login' => 'filament.auth.login'
    ],

    /*
    |--------------------------------------------------------------------------
    | Pages
    |--------------------------------------------------------------------------
    |
    | This is the namespace and directory that Filament will automatically
    | register pages from. You may also register pages here.
    |
    */

    'pages' => [
        'namespace' => 'App\\Filament\\Pages',
        'path' => app_path('Filament/Pages'),
        'register' => [
            App\Filament\Pages\Dashboard::class,
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Resources
    |--------------------------------------------------------------------------
    |
    | This is the namespace and directory that Filament will automatically
    | register resources from. You may also register resources here.
    |
    */

    'resources' => [
        'namespace' => 'App\\Filament\\Resources',
        'path' => app_path('Filament/Resources'),
        'register' => [],
    ],

    /*
    |--------------------------------------------------------------------------
    | Widgets
    |--------------------------------------------------------------------------
    |
    | This is the namespace and directory that Filament will automatically
    | register dashboard widgets from. You may also register widgets here.
    |
    */

    'widgets' => [
        'namespace' => 'App\\Filament\\Widgets',
        'path' => app_path('Filament/Widgets'),
        'register' => [
            AttendanceCalendar::class,
            LatestUsersWidget::class,
            EmployeeAttendance::class,
            // Widgets\AccountWidget::class,
            // Widgets\FilamentInfoWidget::class,
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Livewire
    |--------------------------------------------------------------------------
    |
    | This is the namespace and directory that Filament will automatically
    | register Livewire components inside.
    |
    */

    'livewire' => [
        'namespace' => 'App\\Filament',
        'path' => app_path('Filament'),
    ],

    /*
    |--------------------------------------------------------------------------
    | Dark mode
    |--------------------------------------------------------------------------
    |
    | By enabling this feature, your users are able to select between a light
    | and dark appearance for the admin panel, or let their system decide.
    |
    */

    'dark_mode' => false,

    /*
    |--------------------------------------------------------------------------
    | Layout
    |--------------------------------------------------------------------------
    |
    | This is the configuration for the general layout of the admin panel.
    |
    | You may configure the max content width from `xl` to `7xl`, or `full`
    | for no max width.
    |
    */

    'layout' => [
        'forms' => [
            'actions' => [
                'alignment' => 'left',
            ],
            'have_inline_labels' => false,
        ],
        'footer' => [
            'should_show_logo' => false,
        ],
        'max_content_width' => null,
        'notifications' => [
            'vertical_alignment' => 'top',
            'alignment' => 'center',
        ],
        'sidebar' => [
            'is_collapsible_on_desktop' => true,
            'groups' => [
                'are_collapsible' => true,
            ],
            'width' => null,
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Favicon
    |--------------------------------------------------------------------------
    |
    | This is the path to the favicon used for pages in the admin panel.
    |
    */

    'favicon' => null,

    /*
    |--------------------------------------------------------------------------
    | Default Avatar Provider
    |--------------------------------------------------------------------------
    |
    | This is the service that will be used to retrieve default avatars if one
    | has not been uploaded.
    |
    */

    'default_avatar_provider' => \Filament\AvatarProviders\UiAvatarsProvider::class,

    /*
    |--------------------------------------------------------------------------
    | Default Filesystem Disk
    |--------------------------------------------------------------------------
    |
    | This is the storage disk Filament will use to put media. You may use any
    | of the disks defined in the `config/filesystems.php`.
    |
    */

    'default_filesystem_disk' => env('FILAMENT_FILESYSTEM_DRIVER', 'public'),

    /*
    |--------------------------------------------------------------------------
    | Google Fonts
    |--------------------------------------------------------------------------
    |
    | This is the URL for Google Fonts that should be loaded. You may use any
    | font, or set to `null` to prevent any Google Fonts from loading.
    |
    | When using a custom font, you should also set the font family in your
    | custom theme's `tailwind.config.js` file.
    |
    */

    // 'google_fonts' => 'https://fonts.googleapis.com/css2?family=DM+Sans:ital,wght@0,400;0,500;0,700;1,400;1,500;1,700&display=swap',
    'google_fonts' => 'https://fonts.googleapis.com/css2?family=Nunito:ital,wght@0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;0,1000;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900;1,1000&display=swap',

    /*
    |--------------------------------------------------------------------------
    | Middleware
    |--------------------------------------------------------------------------
    |
    | You may customise the middleware stack that Filament uses to handle
    | requests.
    |
    */

    'middleware' => [
        'auth' => [
            Authenticate::class,
            SetUserTimezone::class,
        ],
        'base' => [
            EncryptCookies::class,
            AddQueuedCookiesToResponse::class,
            StartSession::class,
            AuthenticateSession::class,
            ShareErrorsFromSession::class,
            VerifyCsrfToken::class,
            SubstituteBindings::class,
            DispatchServingFilamentEvent::class,
            MirrorConfigToSubpackages::class,
        ],
    ],

];
