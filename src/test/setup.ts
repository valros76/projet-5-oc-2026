import { afterEach, beforeEach, vi } from 'vitest'

// Réinitialise tous les mocks entre chaque test pour éviter les fuites d'état.
afterEach(() => {
  vi.restoreAllMocks()
  vi.clearAllMocks()
})

// Nettoie le stockage du navigateur simulé avant chaque test.
beforeEach(() => {
  localStorage.clear()
  sessionStorage.clear()
  // Réinitialise les cookies du document.
  document.cookie.split(';').forEach((c) => {
    const name = c.split('=')[0]?.trim()
    if (name) {
      document.cookie = `${name}=;expires=Thu, 01 Jan 1970 00:00:00 GMT;path=/`
    }
  })
})
