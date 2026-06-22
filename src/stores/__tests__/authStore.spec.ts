import { describe, it, expect, beforeEach, vi } from 'vitest'
import { setActivePinia, createPinia } from 'pinia'
import { authStore } from '@/stores/authStore'
import type { UserI } from '@/interfaces/userI'

const fakeUser: UserI = {
  id: 1,
  email: 'admin@webdevoo.com',
  is_admin: true,
  inscriptionDate: '2024-01-01',
}

describe('authStore', () => {
  beforeEach(() => {
    setActivePinia(createPinia())
    localStorage.clear()
    sessionStorage.clear()
  })

  it("démarre sans utilisateur quand aucun stockage n'est présent", () => {
    const store = authStore()
    expect(store.user).toBeUndefined()
  })

  describe('saveSessionUser / getSessionUser', () => {
    it("enregistre l'utilisateur en session et le restitue", () => {
      const store = authStore()
      store.saveSessionUser(fakeUser)

      expect(store.user).toEqual(fakeUser)
      expect(store.getSessionUser()).toEqual(fakeUser)
      expect(JSON.parse(sessionStorage.getItem('webdevoo_user')!)).toEqual(fakeUser)
    })
  })

  describe('saveLocalUser / getLocalUser', () => {
    it("enregistre l'utilisateur en local et le restitue", () => {
      const store = authStore()
      store.saveLocalUser(fakeUser)

      expect(store.user).toEqual(fakeUser)
      expect(store.getLocalUser()).toEqual(fakeUser)
      expect(JSON.parse(localStorage.getItem('webdevoo_user')!)).toEqual(fakeUser)
    })
  })

  describe('clearUserStored', () => {
    it('vide la session, le local et le state', () => {
      const store = authStore()
      store.saveSessionUser(fakeUser)
      store.saveLocalUser(fakeUser)

      store.clearUserStored()

      expect(store.user).toBeUndefined()
      expect(sessionStorage.getItem('webdevoo_user')).toBeNull()
      expect(localStorage.getItem('webdevoo_user')).toBeNull()
    })
  })

  describe('initialisation', () => {
    it('hydrate le state depuis la sessionStorage au démarrage', () => {
      sessionStorage.setItem('webdevoo_user', JSON.stringify(fakeUser))
      const store = authStore()
      expect(store.user).toEqual(fakeUser)
    })

    it('hydrate le state depuis le localStorage si la session est vide', () => {
      localStorage.setItem('webdevoo_user', JSON.stringify(fakeUser))
      const store = authStore()
      expect(store.user).toEqual(fakeUser)
    })

    it('gère un JSON corrompu sans planter et nettoie la session', () => {
      const errorSpy = vi.spyOn(console, 'error').mockImplementation(() => { })
      sessionStorage.setItem('webdevoo_user', '{ json invalide')

      const store = authStore()

      expect(store.user).toBeUndefined()
      expect(sessionStorage.getItem('webdevoo_user')).toBeNull()
      expect(errorSpy).toHaveBeenCalled()
    })
  })

  describe('getSessionUser sans donnée', () => {
    it('retourne undefined', () => {
      const store = authStore()
      expect(store.getSessionUser()).toBeUndefined()
    })
  })
})
