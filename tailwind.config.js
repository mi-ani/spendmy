const defaultTheme = require('tailwindcss/defaultTheme');
const colors = require('tailwindcss/colors');

module.exports = {
    purge: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Nunito', ...defaultTheme.fontFamily.sans],
            },
            colors: {
                main: '#fffffe',
                secondary: '#f2eef5',
                stoke: '#f0e2e1',
                headline: '#181818',
                paragraph: '#2e2e2e',
                contrast: '#994ff3',
                button: '#fbdd74',
                expanse: {
                    red: '#ff5470',
                    green: '#2cb67d',
                }
            },
        },
    },

    variants: {
        extend: {
            opacity: ['disabled'],
        },
    },

    plugins: [require('@tailwindcss/forms')],
};
