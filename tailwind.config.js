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
      colors: {
        ferresys: {
          primary: '#D72638',     // Rojo Fierro
          dark: '#2E2E2E',        // Gris Acero
          light: '#E0E0E0',       // Gris Cemento
          yellow: '#FFC107',      // Amarillo Herramienta
          blue: '#007BFF',        // Azul Técnico
        },
        ferre: '#D72638',
        acero: '#2E2E2E',
        cemento: '#E0E0E0',
        herramienta: '#FFC107',
        tecnico: '#007BFF',
      },
      fontFamily: {
        sans: ['Inter', 'Roboto', 'sans-serif'],
        heading: ['Montserrat', 'sans-serif'],
            },
        },
    },

    plugins: [forms],
};
