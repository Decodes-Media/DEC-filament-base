import preset from './../../vendor/filament/filament/tailwind.config.preset';

/** @type {import('tailwindcss').Config} */
export default {
    presets: [preset],
    content: [
      './app/Filament/**/*.php',
      './app/FilamentAdmin/**/*.php',
      './resources/views/components/**/*.blade.php',
      './resources/views/filament/**/*.blade.php',
      './resources/views/vendor/filament**/**/*.blade.php',
      './vendor/filament/**/*.blade.php',
    ],
}
