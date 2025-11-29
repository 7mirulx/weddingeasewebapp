/** @type {import('tailwindcss').Config} */
module.exports = {
  content: [
      "./resources/**/*.blade.php",
      "./resources/**/*.js",
      "./resources/**/*.vue",
      "./resources/**/*.jsx",
      "./resources/**/*.ts",
      "./resources/**/*.tsx",
  ],

  theme: {
    extend: {
      colors: {
        brand: '#FEE7F5',
        brand2: '#FCBBE3',
        primary: '#700547',
        alt: '#BA0BF4',
      },
      fontFamily: {
        sans: ['Instrument Sans', 'ui-sans-serif', 'system-ui'],
      },
    },
  },

  plugins: [],
};
