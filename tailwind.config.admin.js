const defaultTheme = require('tailwindcss/defaultTheme');

module.exports = {
    purge: [
      './resources/views/dashboard/**/*.blade.php',
      './resources/views/components/**/*.blade.php',
      './resources/js/dashboard/components/*.vue',
      // './resources/js/components/**/*.vue',
      // './resources/js/dashboard/**/*.vue'
    ],

    theme: {
        extend: {
            colors: {
                'accent-green': '#68BE58',
                'accent-red': '#FF5252',
                highlight: '#6868CF',
                midnight: {
                    default: '#1B1B38',
                    'border': '#313159',
                    'light': '#717193',
                    'dark': '#343465',
                    'darker': '#252548',
                    'darkest': '#1B1B38',
                },
                kimberly: {
                    default: '#E1E1EF',
                    'primary': '#E1E1EF',
                    'secondary': '#656692',
                    'link': '#8E8ECC',
                    'inactive': '#A9A8D2',
                }
            },
            fontSize: {
                'xxs': '.625rem',
            },
            fontFamily: {
                sans: ['Lato', 'Prompt', ...defaultTheme.fontFamily.sans],
            },
        },
    },

    variants: {
        opacity: ['responsive', 'hover', 'focus', 'disabled'],
        cursor: ['responsive', 'disabled'],
    },

    plugins: [require('@tailwindcss/ui')],
};
