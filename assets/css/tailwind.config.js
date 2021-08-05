const defaultTheme = require('tailwindcss/defaultTheme');

module.exports = {
    purge: ['./**/*.php'],
    darkMode: false, // or 'media' or 'class'
    theme: {
        // fontFamily: {
        //     'sans': ['Montserrat', 'Sarabun', ...defaultTheme.fontFamily.sans],
        // },
        extend: {
            typography: {
                DEFAULT: {
                    css: {
                        color: '',
                    }
                }
            }
        },
    },
    variants: {
        extend: {},
    },
    plugins: [
        require('@tailwindcss/typography'),
        require('@tailwindcss/aspect-ratio'),
    ],
}
