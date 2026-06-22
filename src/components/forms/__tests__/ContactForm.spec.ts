import { describe, it, expect, vi, beforeEach, afterEach } from 'vitest'
import { mount } from '@vue/test-utils'
import ContactForm from '../ContactForm.vue'

// On mocke le router importé par le composant pour intercepter les redirections
const pushMock = vi.fn()
vi.mock('@/router', () => ({
  default: {
    push: (...args: unknown[]) => pushMock(...args),
  },
}))

/**
 * Remplit tous les champs requis du formulaire pour le rendre valide.
 * Chaque champ passe son `state` à true via l'évènement `change`.
 */
async function fillValidForm(wrapper: ReturnType<typeof mount>) {
  const reason = wrapper.find('#reason')
  await reason.setValue('website')
  await reason.trigger('change')

  const email = wrapper.find('#email')
  await email.setValue('jean@exemple.fr')
  await email.trigger('change')

  const message = wrapper.find('#message')
  await message.setValue('Bonjour, je souhaite un site vitrine.')
  await message.trigger('change')

  const returnDate = wrapper.find('#return_date')
  await returnDate.setValue('monday')
  await returnDate.trigger('change')

  const rgpd = wrapper.find('#rgpd')
  await rgpd.setValue(true)
  await rgpd.trigger('change')
}

describe('ContactForm.vue (intégration)', () => {
  beforeEach(() => {
    pushMock.mockClear()
  })

  afterEach(() => {
    vi.restoreAllMocks()
  })

  it('désactive le bouton de soumission tant que le formulaire est incomplet', () => {
    const wrapper = mount(ContactForm)
    const button = wrapper.find('button[type="submit"]')
    expect(button.attributes('disabled')).toBeDefined()
  })

  it('active le bouton une fois tous les champs requis renseignés', async () => {
    const wrapper = mount(ContactForm)
    await fillValidForm(wrapper)

    const button = wrapper.find('button[type="submit"]')
    expect(button.attributes('disabled')).toBeUndefined()
  })

  it('envoie les données et redirige vers /message-envoye en cas de succès', async () => {
    // On simule une réponse réseau réussie
    const fetchMock = vi.fn().mockResolvedValue({
      ok: true,
      json: () => Promise.resolve({ success: true }),
    })
    vi.stubGlobal('fetch', fetchMock)

    const wrapper = mount(ContactForm)
    await fillValidForm(wrapper)
    await wrapper.find('#contactForm').trigger('submit')
    // On laisse les promesses internes se résoudre
    await flushPromises()

    expect(fetchMock).toHaveBeenCalledTimes(1)
    const [url, options] = fetchMock.mock.calls[0]!
    expect(url).toBe('https://webdevoo.com/api/contact')
    expect(options.method).toBe('POST')

    const body = JSON.parse(options.body)
    expect(body).toMatchObject({
      reason: 'website',
      email: 'jean@exemple.fr',
      message: 'Bonjour, je souhaite un site vitrine.',
      returnDate: 'monday',
      rgpd: true,
    })

    expect(pushMock).toHaveBeenCalledWith('/message-envoye')
  })

  it('redirige vers /nous-recontacter en cas d échec réseau', async () => {
    const fetchMock = vi.fn().mockRejectedValue(new Error('network down'))
    vi.stubGlobal('fetch', fetchMock)
    // On masque l'erreur attendue dans la console
    vi.spyOn(console, 'error').mockImplementation(() => { })

    const wrapper = mount(ContactForm)
    await fillValidForm(wrapper)
    await wrapper.find('#contactForm').trigger('submit')
    await flushPromises()

    expect(pushMock).toHaveBeenCalledWith('/nous-recontacter')
  })
})

// Petit utilitaire local pour vider la file des microtâches
async function flushPromises() {
  await new Promise((resolve) => setTimeout(resolve, 0))
}
