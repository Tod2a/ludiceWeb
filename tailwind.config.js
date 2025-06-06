import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';
import flowbitePlugin from "flowbite/plugin";

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
        './resources/js/**/*.vue',
    ],

    theme: {
        extend: {
            scale: {
                '25': "0.25",
            },
            colors: {
                offwhite: '#fdf6ee',
                primary: "#161622",
                secondary: "#ffeec6",
                green: {
                    DEFAULT: "#caf8c5",
                    100: "#4dca5e",
                    200: "#0d6938",
                },
                gray: {
                    100: "#CDCDE0",
                },
                white: {
                    DEFAULT: "#FFFFFF",
                    100: "#fafaf0",
                }
            },
            fontFamily: {
                pthin: ["Poppins-Thin", "sans-serif"],
                pextralight: ["Poppins-ExtraLight", "sans-serif"],
                plight: ["Poppins-Light", "sans-serif"],
                pregular: ["Poppins-Regular", "sans-serif"],
                pmedium: ["Poppins-Medium", "sans-serif"],
                psemibold: ["Poppins-SemiBold", "sans-serif"],
                pbold: ["Poppins-Bold", "sans-serif"],
                pextrabold: ["Poppins-ExtraBold", "sans-serif"],
                pblack: ["Poppins-Black", "sans-serif"],
            },
        },
    },

    plugins: [
        forms,
        flowbitePlugin(),
    ],
};
