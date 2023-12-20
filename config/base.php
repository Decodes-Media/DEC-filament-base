<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Routing
    |--------------------------------------------------------------------------
    */

    'route' => [
        'web_domain' => env('ROUTE_WEB_DOMAIN'),
        'web_path' => env('ROUTE_WEB_PATH'),
        'api_domain' => env('ROUTE_API_DOMAIN'),
        'api_path' => env('ROUTE_API_PATH'),
        'admin_domain' => env('ROUTE_ADMIN_DOMAIN'),
        'admin_path' => env('ROUTE_ADMIN_PATH'),
    ],

    /*
    |--------------------------------------------------------------------------
    | API
    |--------------------------------------------------------------------------
    */

    'api_key' => env('API_KEY', 'hehehed3c4p1k3yhehehe'),

    'api_signature_enabled' => env('API_SIGNATURE_ENABLED', false),

    /*
    |--------------------------------------------------------------------------
    | Access
    |--------------------------------------------------------------------------
    */

    'superadmin_email' => 'super@decodes.com',

    'permissions' => [
        'guard:admin' => [
            '*',
            'user.*',
            'user.view',
            'user.create',
            'user.update',
            'user.delete',
            'user.export',
            'page.*',
            'page.view',
            'page.create',
            'page.update',
            'page.delete',
            'page.export',
            'admin.*',
            'admin.view',
            'admin.create',
            'admin.update',
            'admin.delete',
            'admin.export',
            'role.*',
            'role.view',
            'role.create',
            'role.update',
            'role.delete',
            'role.export',
            'system.*',
            'system.log_activity',
            'system.log_application',
            'system.setting',
            'system.translation',
            'system.health',
            'system.backup',
        ],
    ],

    'roles' => [
        'guard:admin' => [ // guard
            'Superadmin',
            'Admin',
        ],
    ],

    'role_permissions' => [
        'guard:admin' => [ // guard
            'Superadmin' => [
                '*',
            ],
            'Admin' => [
                'user.*',
                'page.*',
            ],
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Lookup
    |--------------------------------------------------------------------------
    */

    'model_morphs' => [
        \App\Models\ActivityLog::class => 'Activity Log',
        \App\Models\Admin::class => 'Admin',
        \App\Models\LanguageLine::class => 'Language',
        \App\Models\Permission::class => 'Permission',
        \App\Models\Role::class => 'Role',
        \App\Models\Setting::class => 'Setting',
        \App\Models\User::class => 'User',
        \Spatie\TranslationLoader\LanguageLine::class => 'Language',
    ],

    'model_policies' => [
        // \App\Models\User::class => \App\Policies\UserPolicy::class,
    ],

    /*
    |--------------------------------------------------------------------------
    | Miscelanious
    |--------------------------------------------------------------------------
    */

    'records_limit' => [
        'admins' => 256,
        'roles' => 12,
    ],

];
