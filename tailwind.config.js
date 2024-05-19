/** @type {import('tailwindcss').Config} */
export default {
  content: [
    "./resources/**/*.blade.php",
    "./resources/**/*.js",
    "./resources/**/*.vue",
    "./vendor/filament/**/*.blade.php",
  ],
  theme: {
    extend: {
      fontFamily: {
        'postserif' : ['"Poetsen One"', 'sans-serif'],
        'fira' : ['"Fira Code"', 'monospace'],
      },
    },
    
  },
  plugins: [],
}
// Poetsen One "Fira Code", monospace