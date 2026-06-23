import { defineConfig } from 'cypress'
import { loadEnv } from 'vite'

// On charge les variables d'environnement manuellement pour le mode 'development'
const viteEnv = loadEnv('development', process.cwd(), 'VITE_')

export default defineConfig({
  // 'allowCypressEnv' n'existe pas dans la config officielle. 
  // Cypress gère les variables via l'objet 'env' ci-dessous.

  env: {
    // On s'assure de fournir une valeur par défaut cohérente
    VITE_SECURITY_KEY: viteEnv.VITE_SECURITY_KEY || '1000',
  },

  e2e: {
    specPattern: 'cypress/e2e/**/*.cy.{js,jsx,ts,tsx}',
    supportFile: false, // Attention : mettre à false désactive les commandes personnalisées si tu en as
    baseUrl: 'http://localhost:5173',
  },
})