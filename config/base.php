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
            'page.*',
            'page.view',
            'page.create',
            'page.update',
            'page.delete',
            'admin.*',
            'admin.view',
            'admin.create',
            'admin.update',
            'admin.delete',
            'role.*',
            'role.view',
            'role.create',
            'role.update',
            'role.delete',
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
        \App\Models\Base\ActivityLog::class => 'Activity Log',
        \App\Models\Base\LanguageLine::class => 'Language',
        \App\Models\Base\Permission::class => 'Permission',
        \App\Models\Base\Role::class => 'Role',
        \App\Models\Base\Setting::class => 'Setting',
        \App\Models\Main\User::class => 'User',
        \App\Models\Main\Admin::class => 'Admin',
        \Spatie\TranslationLoader\LanguageLine::class => 'Language',
    ],

    'model_policies' => [
        \App\Models\Base\ActivityLog::class => \App\Policies\Base\ActivityLogPolicy::class,
        \App\Models\Base\LanguageLine::class => \App\Policies\Base\LanguageLinePolicy::class,
        \App\Models\Base\Role::class => \App\Policies\Base\RolePolicy::class,
        \App\Models\Base\Setting::class => \App\Policies\Base\SettingPolicy::class,
        \App\Models\Main\Admin::class => \App\Policies\Main\AdminPolicy::class,
        \App\Models\Main\User::class => \App\Policies\Main\UserPolicy::class,
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
