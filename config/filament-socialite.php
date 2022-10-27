<?php

// config for DutchCodingCompany/FilamentSocialite
return [
    // Allow login, and registration if enabled, for users with an email for one of the following domains.
    // All domains allowed by default
    // Only use lower case
    'domain_allowlist' => ['nettantra.com', 'nettantra.net'],

    // Allow registration through socials
    'registration' => true,

    // Specify the providers that should be visible on the login.
    // These should match the socialite providers you have setup in your services.php config.
    // Uses blade UI icons, for example: https://github.com/owenvoke/blade-fontawesome
    'providers' => [
        'google' => [
            'label' => 'Login using NetTantra Account',
            'icon' => 'fab-google',
            'color' => 'danger'
        ],
    ],

    'user_model' => \App\Models\User::class,

    // Specify the default redirect route for successful logins
    'login_redirect_route' => 'filament.pages.dashboard',
];
