
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
                primary: '#0F172A',  // Midnight Navy
                accent: '#2563EB',   // Electric Blue
                surface: '#F1F5F9',  // Cool Slate
                white: '#FFFFFF',
            },
        },
    },

    plugins: [forms],
};
