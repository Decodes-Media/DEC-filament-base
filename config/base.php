<?php

return [

    'superadmin_email' => 'super@decodes.com',

    'route' => [
        'web_domain' => env('ROUTE_WEB_DOMAIN'),
        'web_path' => env('ROUTE_WEB_PATH'),
        'api_domain' => env('ROUTE_API_DOMAIN'),
        'api_path' => env('ROUTE_API_PATH'),
        'admin_domain' => env('ROUTE_ADMIN_DOMAIN'),
        'admin_path' => env('ROUTE_ADMIN_PATH'),
    ],

    'api_key' => env('API_KEY', 'd3c4p1k3yhehehe'),

    'api_signature_enabled' => env('API_SIGNATURE_ENABLED', true),

    'records_limit' => [
        'admins' => 256,
        'roles' => 12,
    ],

    'model_names' => [
        \App\Models\User::class => 'User',
        \App\Models\Admin::class => 'Admin',
    ],

];
