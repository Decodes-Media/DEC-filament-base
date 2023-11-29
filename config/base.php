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
        'admin' => [ // guard
            'user.*' => 'User — All Access',
            'user.view' => 'User — View',
            'user.create' => 'User — Create',
            'user.update' => 'User — Update',
            'user.delete' => 'User — Delete',
            'user.export' => 'User — Export',
            'page.*' => 'Page — All Access',
            'page.view' => 'Page — View',
            'page.create' => 'Page — Create',
            'page.update' => 'Page — Update',
            'page.delete' => 'Page — Delete',
            'page.export' => 'Page — Export',
            'admin.*' => 'Admin — All Access',
            'admin.view' => 'Admin — View',
            'admin.create' => 'Admin — Create',
            'admin.update' => 'Admin — Update',
            'admin.delete' => 'Admin — Delete',
            'admin.export' => 'Admin — Export',
            'role.*' => 'Role — All Access',
            'role.view' => 'Role — View',
            'role.create' => 'Role — Create',
            'role.update' => 'Role — Update',
            'role.delete' => 'Role — Delete',
            'role.export' => 'Role — Export',
            'system.*' => 'System — All Access',
            'system.log_activity' => 'System — Log Activity',
            'system.log_application' => 'System — Log Application',
            'system.site_setting' => 'System — Site Setting',
            'system.site_health — Site Health' => 'System — Site Health',
            'system.site_backup' => 'System — Site Backup',
        ],
    ],

    'roles' => [
        'admin' => [ // guard
            'Superadmin' => 'Allow all access',
            'Admin' => 'Allow certain access',
        ],
    ],

    'role_permissions' => [
        'admin' => [ // guard
            'Superadmin' => [
                'admin.*',
                'role.*',
                'system.*',
            ],
            'Admin' => [
                'user.*',
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
        \App\Models\Base\Admin::class => 'Admin',
        \App\Models\Base\Permission::class => 'Permission',
        \App\Models\Base\Role::class => 'Role',
        \App\Models\Base\User::class => 'User',
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
