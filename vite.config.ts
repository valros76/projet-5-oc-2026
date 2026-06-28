import { fileURLToPath, URL } from 'node:url'

import { defineConfig } from 'vite'
import vue from '@vitejs/plugin-vue'
import vueJsx from '@vitejs/plugin-vue-jsx'
import vueDevTools from 'vite-plugin-vue-devtools'

// https://vite.dev/config/
export default defineConfig({
  plugins: [
    vue(),
    vueJsx(),
    vueDevTools(),
  ],
  resolve: {
    alias: {
      '@': fileURLToPath(new URL('./src', import.meta.url)),
    },
  },
  test: {
    environment: 'jsdom', // requis pour simuler le DOM avec Vue Test Utils
    coverage: {
      provider: 'v8',
      reporter: ['text', 'html'], // affiche dans le terminal + génère du HTML
      thresholds: {
        lines: 60,
        functions: 60,
        branches: 60,
        statements: 60
      }
    }
  },
  server: {
    host: '127.0.0.1', // Force l'utilisation de 127.0.0.1
    port: 5173,        // Optionnel : vous pouvez spécifier le port ici
    proxy: {
      '/api': {
        target: 'http://127.0.0.1:5500',
        changeOrigin: true,
        cookieDomainRewrite: "127.0.0.1",
      }
    }
  }
})
