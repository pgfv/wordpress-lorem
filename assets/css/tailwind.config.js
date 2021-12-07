const defaultTheme = require( 'tailwindcss/defaultTheme' );

module.exports = {
    purge: [
        './**/*.php',
        './plugins/lorem-image/src/*.js',
    ],
    darkMode: false, // or 'media' or 'class'
    theme: {
        fontFamily: {
            'sans': ['Montserrat', 'Sarabun', ...defaultTheme.fontFamily.sans],
        },
        extend: {
            typography: {
                DEFAULT: {
                    css: {
                        color: null,
                        strong: {
                            color: null,
                        },
                        a: {
                            color: null,
                        },
                        'ol > li::before': {
                            color: null,
                        },
                        figure: {
                            marginTop: null,
                            marginBottom: null,
                        },
                        img: {
                            marginTop: null,
                            marginBottom: null,
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
