import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    darkMode: 'class',
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
    ],
    theme: {
        extend: {
            fontFamily: {
                sans: ['Outfit', ...defaultTheme.fontFamily.sans],
                pixel: ['"Press Start 2P"', 'cursive', ...defaultTheme.fontFamily.sans],
            },
            colors: {
                poke: {
                    red: '#EE1515',
                    darkred: '#CC0000',
                    blue: '#3B4CCA',
                    yellow: '#FFDE00',
                    gold: '#B3A125',
                }
            }
        },
    },
    plugins: [forms],
};