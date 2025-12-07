/** @type {import('tailwindcss').Config} */
export default {
    content: [
      "./resources/**/*.blade.php",
      "./resources/**/*.js",
      "./resources/**/*.vue",
    ],
    darkMode: 'class', // TAMBAHKAN BARIS INI
    theme: {
      extend: {},
    },
    plugins: [],
  }