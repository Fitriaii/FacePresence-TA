import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';
import daisyui from 'daisyui';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php', // Semua view Blade Laravel
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Inter', 'Arial', 'sans-serif', ...defaultTheme.fontFamily.sans], //font default
                heading: ['Poppins', 'sans-serif'], //font judul
            },
            backgroundImage: {
                'grad-orange': 'linear-gradient(135deg, #FF9F43, #FFC58B)',
                'grad-purple': 'linear-gradient(135deg, #7367F0, #B89CFF)',
                'grad-blue': 'linear-gradient(135deg, #00CFE8, #7DEEFF)',
            },
            colors:{'grad-blue-overlay': 'rgb(0 207 232 / 0.3)'},
        },
    },

    plugins: [forms, daisyui],
};
