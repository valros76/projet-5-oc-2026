import { describe, it, expect, vi, beforeEach } from 'vitest'
import {
  setCookie,
  getCookie,
  checkCookie,
  globalCookieState,
  onClickCookieConsent,
} from '@/stores/CookieState'

describe('CookieState', () => {
  beforeEach(() => {
    globalCookieState.value = false
  })

  describe('setCookie / getCookie', () => {
    it("écrit puis relit la valeur d'un cookie", () => {
      setCookie('maClef', 'maValeur', 1)
      expect(getCookie('maClef')).toBe('maValeur')
    })

    it('retourne une chaîne vide si le cookie est introuvable', () => {
      expect(getCookie('cookieInexistant')).toBe('')
    })
  })

  describe('checkCookie', () => {
    it('passe globalCookieState à true quand le consentement existe', () => {
      setCookie('webdevooCookieConsent', 'Allow', 365)
      checkCookie()
      expect(globalCookieState.value).toBe(true)
    })

    it('laisse globalCookieState à false sans consentement', () => {
      checkCookie()
      expect(globalCookieState.value).toBe(false)
    })
  })

  describe('onClickCookieConsent', () => {
    it('enregistre le consentement et empêche le comportement par défaut', () => {
      const event = {
        preventDefault: vi.fn(),
        stopPropagation: vi.fn(),
      } as unknown as Event

      onClickCookieConsent(event)

      expect(event.preventDefault).toHaveBeenCalledOnce()
      expect(event.stopPropagation).toHaveBeenCalledOnce()
      expect(globalCookieState.value).toBe(true)
      expect(getCookie('webdevooCookieConsent')).toBe('Allow')
    })
  })
})
