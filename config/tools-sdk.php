<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Token
    |--------------------------------------------------------------------------
    |
    | Here you can set the token for the Tools SDK.
    | This token is used to authenticate requests to the Tools SDK API.
    | To generate a token, visit https://tools.vhosting-it.com/token
    |
    */

    'token' => env('TOOLS_TOKEN', ''),

    /*
    |--------------------------------------------------------------------------
    | Url
    |--------------------------------------------------------------------------
    |
    | This is the base URL for the Tools SDK API.
    | Useful for testing or if you need to point to a different environment.
    |
    */

    'url' => env('TOOLS_URL', 'https://tools.vhosting-it.com'),

    /*
    |--------------------------------------------------------------------------
    | Mock
    |--------------------------------------------------------------------------
    |
    | This setting enables or disables mocking of API responses.
    | When enabled, the SDK will return mock data instead of making actual API calls.
    | Useful for local development.
    |
    */

    'mock' => env('TOOLS_MOCK', false),

];
