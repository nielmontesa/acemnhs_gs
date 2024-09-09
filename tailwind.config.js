/** @type {import('tailwindcss').Config} */
module.exports = {
  content: ["./src/**/*.{html,js,php}"],
  theme: {
    extend: {},
  },
  plugins: [require('rippleui')],
  rippleui: {
    defaultTheme: 'light',
		themes: [
			{
				themeName: "light",
				colorScheme: "light",
				colors: {
					primary: "#04B2A8",
				},
			},
			
		],
	},
}
