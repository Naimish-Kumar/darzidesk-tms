const defaultTheme = require('tailwindcss/defaultTheme');

module.exports = {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Hanken Grotesk', 'Nunito', ...defaultTheme.fontFamily.sans],
            },
            colors: {
                appBg: '#03111F',
                primaryGold: '#D9A441',
                primaryLightGold: '#F4C861',
                cardBg: '#0B2239',
                inputBg: '#102B45',
                secondaryText: '#D8E0E8',
                mutedText: '#8FA1B5',
                borderNavy: '#29435D',
            },
        },
    },

    plugins: [require('@tailwindcss/forms')],
};

