import { describe, it, expect, vi, beforeEach, afterEach } from 'vitest'
import { useTracker } from '@/composables/useTracker'

describe('useTracker', () => {
  let fetchMock: ReturnType<typeof vi.fn>

  beforeEach(() => {
    fetchMock = vi.fn()
    vi.stubGlobal('fetch', fetchMock)
  })

  afterEach(() => {
    vi.unstubAllGlobals()
  })

  describe('trackEvent', () => {
    it("envoie l'évènement avec son nom, l'URL et les métadonnées", async () => {
      fetchMock.mockResolvedValue(new Response(null, { status: 200 }))
      const { trackEvent } = useTracker()

      await trackEvent('form_input_filled', { field: 'email' })

      expect(fetchMock).toHaveBeenCalledTimes(1)
      const [url, options] = fetchMock.mock.calls[0]!
      expect(url).toContain('/v1/analytics')
      expect(options.method).toBe('POST')

      const body = JSON.parse(options.body)
      expect(body.event_name).toBe('form_input_filled')
      expect(body.metadata).toEqual({ field: 'email' })
      expect(body).toHaveProperty('page_url')
    })

    it('avale silencieusement une erreur réseau (try/catch)', async () => {
      const errorSpy = vi.spyOn(console, 'error').mockImplementation(() => { })
      fetchMock.mockRejectedValue(new Error('Network down'))
      const { trackEvent } = useTracker()

      // Ne doit pas rejeter : le tracking est non bloquant.
      await expect(trackEvent('ping')).resolves.toBeUndefined()
      expect(errorSpy).toHaveBeenCalled()
    })

    it('journalise un avertissement en cas de timeout (AbortError)', async () => {
      const warnSpy = vi.spyOn(console, 'warn').mockImplementation(() => { })
      const abortError = new Error('Aborted')
      abortError.name = 'AbortError'
      fetchMock.mockRejectedValue(abortError)
      const { trackEvent } = useTracker()

      await trackEvent('ping')
      expect(warnSpy).toHaveBeenCalledWith('Tracking annulé : timeout dépassé')
    })
  })

  describe('getTrackEvents', () => {
    it('récupère les évènements en GET avec offset et limit', async () => {
      const payload = [{ id: 1, event_name: 'visit' }]
      fetchMock.mockResolvedValue(
        new Response(JSON.stringify(payload), { status: 200 }),
      )
      const { getTrackEvents } = useTracker()

      const result = await getTrackEvents(10, 50)

      const [url, options] = fetchMock.mock.calls[0]!
      expect(url).toContain('/view-events?offset=10&limit=50')
      expect(options.method).toBe('GET')
      expect(result).toEqual(payload)
    })

    it('lève une erreur si la réponse réseau est en échec', async () => {
      fetchMock.mockResolvedValue(new Response(null, { status: 500 }))
      const { getTrackEvents } = useTracker()

      await expect(getTrackEvents()).rejects.toThrow('Erreur réseau')
    })
  })

  describe('countEvents', () => {
    it("extrait et convertit le nombre d'évènements", async () => {
      fetchMock.mockResolvedValue(
        new Response(JSON.stringify({ params: [{ events_count: '42' }] }), {
          status: 200,
        }),
      )
      const { countEvents } = useTracker()

      const count = await countEvents()
      expect(count).toBe(42)
      const [url] = fetchMock.mock.calls[0]!
      expect(url).toContain('/count-events')
    })

    it('lève une erreur si la réponse réseau est en échec', async () => {
      fetchMock.mockResolvedValue(new Response(null, { status: 500 }))
      const { countEvents } = useTracker()

      await expect(countEvents()).rejects.toThrow()
    })
  })
})
