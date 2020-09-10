<?php

declare(strict_types=1);

return [
    /*
    |--------------------------------------------------------------------------
    | Clio separates EU data using an URL prefix
    |--------------------------------------------------------------------------
    */
    'eu_client' => env('CLIO_EU_CLIENT', true),

    /*
    |--------------------------------------------------------------------------
    | Developer app credentials
    |--------------------------------------------------------------------------
    */
    'client_id' => env('CLIO_CLIENT_ID'),
    'client_secret' => env('CLIO_CLIENT_SECRET'),
    'callback_url' => env('CLIO_CALLBACK_URL'),

    /*
    |--------------------------------------------------------------------------
    | Endpoints
    |--------------------------------------------------------------------------
    */
    'authorize_url' => 'https://app.clio.com/oauth/authorize',
    'token_url' => 'https://app.clio.com/oauth/token',
    'api_url' => 'https://app.clio.com/api/v4',

    'eu_authorize_url' => 'https://eu.app.clio.com/oauth/authorize',
    'eu_token_url' => 'https://eu.app.clio.com/oauth/token',
    'eu_api_url' => 'https://eu.app.clio.com/api/v4',
];
