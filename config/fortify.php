<?php

use Laravel\Fortify\Features;

return [

    'guard' => '',

    'middleware' => ['api'],

    'auth_middleware' => 'auth:sanctum',

    'passwords' => 'users',

    'username' => 'email',

    'email' => 'email',

    'views' => false,

    'home' => '/api/me',

    'prefix' => 'api',

    'domain' => null,

    'lowercase_usernames' => false,

    'limiters' => [
        'login' => 'login',
        'two-factor' => 'two-factor',
    ],

    'paths' => [
        'login' => 'login',
        'logout' => 'logout',
        'register' => 'register',
        'password' => [
            'request' => 'forgot-password',
            'reset' => 'reset-password',
            'email' => 'forgot-password',
            'update' => 'user/password',
            'confirm' => 'user/confirm-password',
            'confirmation' => 'user/confirmed-password-status',
        ],
        'verification' => [
            'notice' => 'email/verify',
            'verify' => 'email/verify/{id}/{hash}',
            'send' => 'email/verification-notification',
        ],
        'user-profile-information' => [
            'update' => 'user/profile-information',
        ],
        'user-password' => [
            'update' => 'user/password',
        ],
        'two-factor' => [
            'login' => 'two-factor-challenge',
            'enable' => 'user/two-factor-authentication',
            'confirm' => 'user/confirmed-two-factor-authentication',
            'disable' => 'user/two-factor-authentication',
            'qr-code' => 'user/two-factor-qr-code',
            'secret-key' => 'user/two-factor-secret-key',
            'recovery-codes' => 'user/two-factor-recovery-codes',
        ],
    ],

    'redirects' => [
        'login' => null,
        'logout' => null,
        'password-confirmation' => null,
        'register' => null,
        'email-verification' => null,
        'password-reset' => null,
    ],

    'features' => [
        Features::registration(),
        Features::resetPasswords(),
        Features::emailVerification(),
        Features::updateProfileInformation(),
        Features::updatePasswords(),
        // Features::twoFactorAuthentication([
        //     'confirm' => true,
        //     'confirmPassword' => true,
        // ]),
    ],

];
