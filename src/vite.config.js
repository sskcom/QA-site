import { defineConfig } from "vite";
import laravel from "laravel-vite-plugin";
import vue from "@vitejs/plugin-vue";
import vuetify from "vite-plugin-vuetify"
import tailwindcss from 'tailwindcss'

export default defineConfig({
    plugins: [
        vue(),
        vuetify(),	
        laravel({
            input: ["resources/js/app.js","resources/css/app.css"
        ],
            refresh: true,
        }),
    ],
    css: {
        preprocessors: {
          '**/*.css': [tailwindcss]
        }
    }
});
