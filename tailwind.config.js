/** @type {import('tailwindcss').Config} */
export default {
  content: [
    "./resources/**/*.blade.php",
    "./resources/**/*.js",
    "./resources/**/*.vue",
    "./node_modules/flowbite/**/*.js",
  ],
  theme: {
    extend: {
        fontFamily: {
            primary: ['Roboto', 'sans-serif'],
            secondary: ['Georgia', 'sans-serif'],
        }
    },
  },
  plugins: [
    require('flowbite/plugin'),
  ],
}

