/** @type {import('tailwindcss').Config} */
export default {
  content: [
    "./resources/**/*.blade.php",
    "./resources/**/*.js",
    "./resources/**/*.vue",
    "./node_modules/flowbite/**/*.js",
  ],
  theme: {
    fontFamily: {
        'primary': ['Roboto', 'sans-serif'],
        'secondary': ['Georgia', 'sans-serif'],
    },
    colors: {
        'primary': '',
        'secondary': '',
        'background': '#F8F8F8',
        'button': '#000000'
    },
    extend: {},
  },
  plugins: [
    require('flowbite/plugin'),
  ],
}

