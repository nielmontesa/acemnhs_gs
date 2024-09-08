/** @type {import('tailwindcss').Config} */
module.exports = {
  content: ["./src/**/*.{html,js,php}"],
  theme: {
    extend: {
      colors: {
        "primary": "#04B2A8",
      }
    },
  },
  plugins: [require('daisyui')],
  daisyui: {
    themes: ["emerald"],
  }
}

