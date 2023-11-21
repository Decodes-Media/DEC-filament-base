# Decodes Filament Base

Decodes web/system/cms base template built wit filamentphp.

## Getting Started

1. Clone this repository
1. Install php dependencies with `composer install`
1. Install javascript depedencies with `npm install`
1. Copy `.env.example` file to `.env` and configure your environment
1. Generate application key with `php artisan key:generate`
1. Migrate and seed the database with `php artisan migrate:fresh --seed`
1. Build the javascript bundle with `npm run build`
1. Run the application with `php artisan serve`
1. Open browser and visit `http://localhost:8000`

## Notes

* Default admin path: /admin
* Default admin user: super@decodes.com pass: password
