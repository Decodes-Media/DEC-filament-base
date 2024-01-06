/** @type {import('tailwindcss').Config} */
export default {
  prefix: 'tw-',
  corePlugins: {
    preflight: false,
  },
  plugins: [
    require('@tailwindcss/typography'),
    require('@tailwindcss/forms'),
  ],
  content: [
    './resources/views/client/**/*.blade.php',
    './resources/views/components/**/*.blade.php',
    // './resources/views/emails/**/*.blade.php',
    // './resources/views/vendor/**/*.blade.php',
  ],
}
