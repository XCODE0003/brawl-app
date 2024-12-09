/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
        './resources/js/**/*.vue',
    ],

    theme: {
        screens: {
            'sm': '390px',
            'md': '390px',
            'lg': '390px',
            'xl': '390px',
        },
        extend: {
            colors: {
                'main-gradient': 'linear-gradient(180.00deg, rgb(0, 0, 0) 10.345%,rgb(255, 189, 32) 100%)',
                'gray': {
                    DEFAULT: 'rgb(17, 17, 17)',
                    400: 'rgb(156, 163, 175)',
                },
                'gray2': 'rgba(35, 35, 35, 1)',
                'dark': '#111111',
                'gold': '#FFD100',
                'yellow': 'rgb(255, 189, 32)',
            },

        },
    },

};
