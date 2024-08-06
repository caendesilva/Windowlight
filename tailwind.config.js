import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';
import typography from '@tailwindcss/typography';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './vendor/hyde/framework/resources/views/components/post/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
            },
            typography: {
                DEFAULT: {
                    css: {
                        maxWidth: '80ch',
                    },
                },
            },
        },
    },

    safelist: [
        'w-8',
        'h-8',
        'rounded-full',
        'border',
        'border-gray-300',
        'dark:border-gray-600'
    ],

    plugins: [forms, typography],
};
