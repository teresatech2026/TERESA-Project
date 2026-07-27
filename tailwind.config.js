import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
            },
            colors: {
                primary: {
                    50: '#e8f0e9',
                    100: '#c5dbc7',
                    200: '#9fc4a3',
                    300: '#78ad7d',
                    400: '#5c9c63',
                    500: '#408a49',
                    600: '#1B5E20', // Dark Emerald (main brand color)
                    700: '#164e1a',
                    800: '#123f15',
                    900: '#0c2c0e',
                },
                accent: {
                    50: '#fff8e1',
                    100: '#ffecb3',
                    200: '#ffe082',
                    300: '#ffd54f',
                    400: '#ffca28',
                    500: '#FFC107', // Harvest Gold (accent color)
                    600: '#e6ac00',
                    700: '#b38600',
                    800: '#806000',
                    900: '#4d3a00',
                },
            },
        },
    },

    plugins: [forms],
};