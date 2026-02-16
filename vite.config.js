import { defineConfig } from "vite";
import symfonyPlugin from "vite-plugin-symfony";
import tailwindcss from "@tailwindcss/vite";

/* if you're using React */
// import react from '@vitejs/plugin-react';

export default defineConfig({
    root: '.',
    base: '/build/',
    publicDir: false,
    plugins: [
        /* react(), // if you're using React */
        symfonyPlugin(),
        tailwindcss(),
    ],
    build: {
        manifest: true,
        outDir: 'public/build',
        emptyOutDir: true,
        rollupOptions: {
            input: {
                app: './assets/app.js'
            }
        }
    },
    server: {
        strictPort: true,
        port: 5173
    }
});
