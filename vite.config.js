import { defineConfig } from 'vite';
import laravel, { refreshPaths } from 'laravel-vite-plugin';

export default defineConfig({
  plugins: [
    laravel({
      input: [
        'resources/sass/app.scss',
        'resources/js/app.js',
        'resources/css/app-tailwind.css',
        'resources/css/filament-base-theme.css',
        'resources/js/filament-base-theme.js',
      ],
      refresh: [
        ...refreshPaths,
        'app/Livewire/**',
      ],
    }),
  ],
});
