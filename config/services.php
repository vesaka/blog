<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Stripe, Mailgun, SparkPost and others. This file provides a sane
    | default location for this type of information, allowing packages
    | to have a conventional place to find your various credentials.
    |
    */

    'mailgun' => [
        'domain' => env('MAILGUN_DOMAIN'),
        'secret' => env('MAILGUN_SECRET'),
    ],

    'ses' => [
        'key' => env('SES_KEY'),
        'secret' => env('SES_SECRET'),
        'region' => 'us-east-1',
    ],

    'sparkpost' => [
        'secret' => env('SPARKPOST_SECRET'),
    ],

    'stripe' => [
        'model' => App\User::class,
        'key' => env('STRIPE_KEY'),
        'secret' => env('STRIPE_SECRET'),
    ],
    
    'github' => [
        'client_id' => env('GITHUB_APP_ID'),
        'client_secret' => env('GITHUB_APP_SECRET'),
        'redirect' => env('GITHUB_CALLBACK_URL'),
    ],
    
    'facebook' => [
        'client_id' => env('FACEBOOK_APP_ID'),
        'client_secret' => env('FACEBOOK_APP_SECRET'),
        'redirect' => env('CALLBACK_URL'),
    ],
    
    'twitter' => [
        'client_id' => env('TWITTER_APP_ID'),
        'client_secret' => env('TWITTER_APP_SECRET'),
        'redirect' => env('TWITTER_CALLBACK_URL'),
    ],
    
    'twitch' => [
        'client_id' => env('TWITCH_APP_ID'),
        'client_secret' => env('TWITCH_APP_SECRET'),
        'redirect' => env('TWITCH_CALLBACK_URL'),
    ],
    
    'deviantart' => [
        'client_id' => env('DEVIANTART_APP_ID'),
        'client_secret' => env('DEVIANTART_APP_SECRET'),
        'redirect' => env('DEVIANTART_CALLBACK_URL'),
    ],
    
    'google' => [
        'client_id' => env('GOOGLE_APP_ID'),
        'client_secret' => env('GOOGLE_APP_SECRET'),
        'redirect' => env('GOOGLE_CALLBACK_URL'),
    ],
    
    'youtube' => [
        'client_id' => env('YOUTUBE_APP_ID'),
        'client_secret' => env('YOUTUBE_APP_SECRET'),
        'redirect' => env('YOUTUBE_CALLBACK_URL'),
    ],
    
    'steam' => [
        'client_id' => env('STEAM_APP_ID'),
        'client_secret' => env('STEAM_APP_SECRET'),
        'redirect' => env('STEAM_CALLBACK_URL'),
    ],
    
    'linkedin' => [
        'client_id' => env('LINKEDIN_APP_ID'),
        'client_secret' => env('LINKEDIN_APP_SECRET'),
        'redirect' => env('LINKEDIN_CALLBACK_URL'),
    ],
    
    'instagram' => [
        'client_id' => env('INSTAGRAM_APP_ID'),
        'client_secret' => env('INSTAGRAM_APP_SECRET'),
        'redirect' => env('INSTAGRAM_CALLBACK_URL'),
    ],
];
