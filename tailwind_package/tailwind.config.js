/** @type {import('tailwindcss').Config} */
module.exports = {
  content: ["./*.{html,js,php}"],
  theme: {
    extend: {
      spacing: {
      },
    },
    borderRadius: {
      'xl': '1.5rem',
    },
  },
  plugins: [
  ],
  darkMode: 'selector',
  fontFamily: {
    sans: ['Graphik', 'sans-serif'],
  },
}