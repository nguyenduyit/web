<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Mailgun, Postmark, AWS and more. This file provides the de facto
    | location for this type of information, allowing packages to have
    | a conventional file to locate the various service credentials.
    |
    */

    'mailgun' => [
        'domain' => env('MAILGUN_DOMAIN'),
        'secret' => env('MAILGUN_SECRET'),
        'endpoint' => env('MAILGUN_ENDPOINT', 'api.mailgun.net'),
    ],

    'postmark' => [
        'token' => env('POSTMARK_TOKEN'),
    ],

    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],

    'facebook' => [
        'client_id' => '354808596594540',  
        'client_secret' => '47b51ddd97fb922a11f3381263bdc979',  
        'redirect' => 'http://localhost/shopbansach/admin/callback'
    ],

    'google' => [
        'client_id' => '600492243966-o05saf5phds2lr3mob3ah0aa2bsif9ug.apps.googleusercontent.com',
        'client_secret' => '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',
        'redirect' => 'http://localhost/shopbansach/google/callback' 
    ],



];
