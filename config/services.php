<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file stores credentials for third-party services like Mailgun,
    | Postmark, AWS, and others. It’s the conventional location for these
    | credentials, making them easily accessible throughout the app.
    |
    */

    'postmark' => [
        'key' => env('POSTMARK_API_KEY'),
    ],

    'resend' => [
        'key' => env('RESEND_API_KEY'),
    ],

    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],

    'slack' => [
        'notifications' => [
            'bot_user_oauth_token' => env('SLACK_BOT_USER_OAUTH_TOKEN'),
            'channel' => env('SLACK_BOT_USER_DEFAULT_CHANNEL'),
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | News Fetcher APIs
    |--------------------------------------------------------------------------
    |
    | Credentials for our news aggregator integrations.
    |
    */

    'newsapi' => [
        'key' => env('NEWSAPI_KEY'),
    ],

    'guardian' => [
        'key' => env('GUARDIAN_API_KEY'),
    ],

    'nyt' => [
        'key' => env('NYT_KEY'),
    ],

];
