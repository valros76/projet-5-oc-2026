import { describe, it, expect, vi, beforeEach, afterEach } from 'vitest'
import { useAuth } from '@/composables/useAuth'
import type { UserAuthI } from '@/interfaces/userI'

const credentials: UserAuthI = {
  email: 'admin@webdevoo.com',
  password: 'Sup3rSecret!',
}

describe('useAuth', () => {
  let fetchMock: ReturnType<typeof vi.fn>

  beforeEach(() => {
    fetchMock = vi.fn().mockResolvedValue(
      new Response(JSON.stringify({ ok: true }), { status: 200 }),
    )
    vi.stubGlobal('fetch', fetchMock)
  })

  afterEach(() => {
    vi.unstubAllGlobals()
  })

  it("appelle l'endpoint d'inscription en POST avec le corps JSON attendu", async () => {
    const { registerAdmin } = useAuth()
    await registerAdmin(credentials)

    expect(fetchMock).toHaveBeenCalledTimes(1)
    const [url, options] = fetchMock.mock.calls[0]!
    expect(url).toContain('/v1/auth/register')
    expect(options.method).toBe('POST')
    expect(options.headers['Content-Type']).toBe('application/json')
    expect(JSON.parse(options.body)).toEqual(credentials)
  })

  it("appelle l'endpoint de connexion en POST", async () => {
    const { connexionAdmin } = useAuth()
    await connexionAdmin(credentials)

    const [url, options] = fetchMock.mock.calls[0]!
    expect(url).toContain('/v1/auth/connexion')
    expect(options.method).toBe('POST')
  })

  it('transmet un signal AbortController pour gérer le timeout', async () => {
    const { connexionAdmin } = useAuth()
    await connexionAdmin(credentials)

    const [, options] = fetchMock.mock.calls[0]!
    expect(options.signal).toBeInstanceOf(AbortSignal)
  })

  it('retourne la réponse fetch', async () => {
    const { registerAdmin } = useAuth()
    const response = await registerAdmin(credentials)
    expect(response).toBeInstanceOf(Response)
    expect(response.status).toBe(200)
  })
})
