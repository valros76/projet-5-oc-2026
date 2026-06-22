import { describe, it, expect, vi } from 'vitest'
import { mount } from '@vue/test-utils'
import ContributionCalculator from '@/components/landing/cottage/ContributionCalculator.vue'

// On isole le composant du réseau : le tracking est remplacé par une fonction muette.
vi.mock('@/composables/useTracker', () => ({
  useTracker: () => ({ trackEvent: vi.fn() }),
}))

const formatEUR = (value: number) =>
  new Intl.NumberFormat('fr-FR', {
    style: 'currency',
    currency: 'EUR',
    minimumFractionDigits: 2,
  }).format(value)

describe('ContributionCalculator.vue', () => {
  it('affiche le titre et les trois champs du formulaire', () => {
    const wrapper = mount(ContributionCalculator)
    expect(wrapper.text()).toContain('Calculez le coût annuel de vos cotisations')
    expect(wrapper.find('#percent').exists()).toBe(true)
    expect(wrapper.find('#nightPrice').exists()).toBe(true)
    expect(wrapper.find('#nbChambers').exists()).toBe(true)
  })

  it("affiche les messages d'erreur tant que les valeurs sont à zéro", () => {
    const wrapper = mount(ContributionCalculator)
    expect(wrapper.text()).toContain('La cotisation doit être supérieure à 0%.')
    expect(wrapper.text()).toContain('Vous devez avoir au moins une chambre à louer.')
  })

  it('calcule le total des cotisations annuelles avec des valeurs valides', async () => {
    const wrapper = mount(ContributionCalculator)

    await wrapper.find('#percent').setValue(20)
    await wrapper.find('#nightPrice').setValue(100)
    await wrapper.find('#nbChambers').setValue(2)

    // 100 € * 20% * 365 jours * 2 chambres = 14 600 €
    const expected = formatEUR(100 * (20 / 100) * 365 * 2)
    expect(wrapper.text()).toContain(expected)
  })

  it("fait disparaître les messages d'erreur une fois les champs renseignés", async () => {
    const wrapper = mount(ContributionCalculator)

    await wrapper.find('#percent').setValue(15)
    await wrapper.find('#nightPrice').setValue(80)
    await wrapper.find('#nbChambers').setValue(3)

    expect(wrapper.text()).not.toContain('La cotisation doit être supérieure à 0%.')
    expect(wrapper.text()).not.toContain('Vous devez avoir au moins une chambre à louer.')
  })

  it('signale une cotisation supérieure à 100%', async () => {
    const wrapper = mount(ContributionCalculator)
    await wrapper.find('#percent').setValue(150)
    expect(wrapper.text()).toContain('La cotisation doit être inférieure ou égale à 100%.')
  })
})
