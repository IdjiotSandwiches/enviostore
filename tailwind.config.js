/** @type {import('tailwindcss').Config} */
export default {
  content: [
    "./resources/**/*.blade.php",
    "./resources/**/*.js",
    "./resources/**/*.vue",
    "./node_modules/flowbite/**/*.js",
    "./node_modules/tw-elements/js/**/*.js",
  ],
  theme: {
    fontFamily: {
        'primary': ['Roboto', 'sans-serif'],
        'secondary': ['Georgia', 'sans-serif'],
    },
    colors: {
        'primary': '#ffffff',
        'accent': '#6f6f6f',
        'background': '#F8F8F8',
        'button': '#000000',
        'font_primary': '#2c2c2c',
        'font_secondary': '#6f6f6f',
    },
    extend: {},
  },
  plugins: [
    require('flowbite/plugin'),
  ],
}

