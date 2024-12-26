import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
        './resources/js/**/*.vue'
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Poppins', 'sans-serif']
            },
            colors: {
                'custom-blue': '#4D73FF',
                'custom-black': '#1C2730',
                'custom-background': '#F9F2EF',
                'custom-red': '#FF334B',
                'custom-yellow': '#EED202',
                'custom-green': '#06C755',
                'custom-gray': {
                    100: '#F3F4F8', // Gray 1
                    200: '#BFBFBF', // Gray 2
                    dark: '#8D9397' // Dark Gray
                },
                'custom-badge': {
                    blue: {
                        background: '#EFF6FF',
                        border: '#60A5FA',
                        text: '#2563EB'
                    },
                    green: {
                        background: '#F0FDF4',
                        border: '#4ADE80',
                        text: '#16A34A'
                    },
                    gray: {
                        background: '#F9FAFB',
                        border: '#9CA3AF',
                        text: '#4B5563'
                    },
                    red: {
                        background: '#FEF2F2',
                        border: '#F06A6C',
                        text: '#DC2626'
                    },
                    yellow: {
                        background: '#FEFCE8',
                        border: '#FACC15',
                        text: '#CA8A04'
                    }
                }
            }
        }
    },

    plugins: [forms]
};
