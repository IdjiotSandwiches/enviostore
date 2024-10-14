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
        'primary': '#ffffff',
        'secondary': '#2c2c2c',
        'accent': '#6f6f6f',
        'background': '#F8F8F8',
        'button': '#000000'
    },
    extend: {},
  },
  plugins: [
    require('flowbite/plugin'),
  ],
}

