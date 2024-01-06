<?php

return [

    'contact_email' => 'webmaster@decodesmedia.com',

    'logo_light_path' => 'static/logo-white.png',

    'logo_dark_path' => 'static/logo-white.png',

    'seo_default' => json_encode([
        'cover_path' => 'static/seo-cover.png',
        'author' => config('app.name'),
        'keywords' => implode(', ', [
            config('app.short_name'),
            config('app.name'),
        ]),
        'description' => 'Lorem ipsum dolor sit amet.',
    ]),

];
