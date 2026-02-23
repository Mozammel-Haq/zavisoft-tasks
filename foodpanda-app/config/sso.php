<?php

// SSO Server Configuration

return[
    'server_url'    => env('SSO_SERVER_URL', 'http://127.0.0.1:8000'),
    'client_id'     => env('SSO_CLIENT_ID'),
    'client_secret' => env('SSO_CLIENT_SECRET'),
    'redirect_uri'  => env('SSO_REDIRECT_URI', 'http://127.0.0.1:8001/auth/callback'),
];
