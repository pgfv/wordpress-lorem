const defaultTheme = require( 'tailwindcss/defaultTheme' );

module.exports = {
    purge: [
        './**/*.php',
        './plugins/lorem-image/src/*.js',
    ],
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
                        strong: {
                            color: '',
                        },
                        a: {
                            color: '',
                        },
                        'ol > li::before': {
                            color: '',
                        }
                    }
                }
            }
        },
    },
    variants: {
        extend: {},
    },
    plugins: [
        require( '@tailwindcss/typography' ),
        require( '@tailwindcss/aspect-ratio' ),
    ],
}
