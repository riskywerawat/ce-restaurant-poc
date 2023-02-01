const defaultTheme = require('tailwindcss/defaultTheme');

module.exports = {
    purge: [
        './vendor/laravel/jetstream/**/*.blade.php',
        './storage/framework/views/*.php',
        // './resources/views/**/*.blade.php',
        './resources/views/auth/*.blade.php',
        './resources/views/components/*.blade.php',
        './resources/views/layouts/*.blade.php',
        './resources/views/livewire/**/*.blade.php',
        './resources/views/profile/*.blade.php',
        './resources/views/public/**/*.blade.php',
        './resources/views/vendor/**/*.blade.php',
        './resources/js/components/*.vue',
    ],

    theme: {
        customForms: theme => ({
            default: {
                input: {
                    backgroundColor: theme('colors.kimberly.input'),
                    borderColor: theme('colors.midnight.border'),
                    '&:focus': {
                        backgroundColor: theme('colors.kimberly.input'),
                        borderColor: theme('colors.highlight'),
                        boxShadow: 'none'
                    },
                },
                select: {
                    backgroundColor: theme('colors.kimberly.input'),
                    borderColor: theme('colors.midnight.border'),
                    '&:focus': {
                        backgroundColor: theme('colors.kimberly.input'),
                    }
                },
                checkbox: {
                    backgroundColor: theme('colors.kimberly.input'),
                    borderColor: theme('colors.midnight.border'),
                    color: theme('colors.kimberly.input'),
                    '&:focus': {
                        backgroundColor: theme('colors.kimberly.input'),
                        borderColor: theme('colors.highlight'),
                        boxShadow: 'none'
                    },
                    '&:checked': {
                        borderColor: theme('colors.midnight.border'),
                    }
                }
            },
        }),
        extend: {
            colors: {
                'accent-green': '#68BE58',
                'accent-red': '#FF5252',
                highlight: '#6868CF',
                'highlight-hover': '#8484DB',
                'highlight-pressed': '#4E4EA0',
                midnight: {
                    default: '#1B1B38',
                    'border': '#313159',
                    'light': '#717193',
                    'dark': '#343465',
                    'dark2': '#45457f',
                    'darker': '#252548',
                    'darkest': '#1B1B38',
                },
                kimberly: {
                    default: '#E1E1EF',
                    'primary': '#E1E1EF',
                    'secondary': '#656692',
                    'link': '#8E8ECC',
                    'inactive': '#A9A8D2',
                    'input': '#1F1F3A',
                },
                'semi-75': 'rgba(0, 0, 0, 0.75)'
            },
            fontFamily: {
                sans: ['Lato', 'Prompt', ...defaultTheme.fontFamily.sans],
            },
            fontSize: {
              'xxs': '.625rem',
            },
            maxHeight: {
                'none': 'none',
                '0': '0',
                '80': '80%',
                '200': '200vh',
            },
            boxShadow: {
                top: '0px -10px 24px 0px rgba(0, 0, 0, 0.6)',
            }
        },
    },

    variants: {
        opacity: ['responsive', 'hover', 'focus', 'disabled'],
    },

    plugins: [require('@tailwindcss/ui')],
};
