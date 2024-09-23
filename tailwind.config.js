const typographyStyles = require('./typography');

/** @type {import('tailwindcss').Config} */
module.exports = {
    content: [
        './layouts/**/*.{html,html.twig,js,twig}'
    ],
    theme: {
        typography: typographyStyles,
        container: {
            screens: {
                sm: '100%',
                md: '100%',
                lg: '1024px',
                xl: '1024px',
            }
        },
        extend: {
            colors: {
                yellow: {
                    d: '#ffff00',
                },
                code: {
                    pre: {
                        bg: '#2b2b2b'
                    }
                }
            },
        },
    },
    plugins: [
        require('@tailwindcss/typography'),
    ]
}
