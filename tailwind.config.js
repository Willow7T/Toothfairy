/** @type {import('tailwindcss').Config} */
export default {
  darkMode: 'selector',
  content: [
    // "./resources/views/livewire/welcome.blade.php",
    // "./resources/views/welcome.blade.php"
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
// Poetsen One "Fira Code", monospaceresources/views/livewire/welcome.blade.php