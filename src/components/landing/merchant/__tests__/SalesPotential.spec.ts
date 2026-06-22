import { describe, it, expect, vi } from 'vitest'
import { mount } from '@vue/test-utils'
import SalesPotential from '@/components/landing/merchant/SalesPotential.vue'

vi.mock('@/composables/useTracker', () => ({
  useTracker: () => ({ trackEvent: vi.fn() }),
}))

const formatEUR = (value: number) =>
  new Intl.NumberFormat('fr-FR', {
    style: 'currency',
    currency: 'EUR',
    minimumFractionDigits: 0,
    maximumFractionDigits: 0,
  }).format(value)

describe('SalesPotential.vue', () => {
  it('affiche le titre et un taux de conversion par défaut de 25%', () => {
    const wrapper = mount(SalesPotential)
    expect(wrapper.text()).toContain('Découvrez votre potentiel de vente en ligne')
    expect((wrapper.find('#manualConversionRate').element as HTMLInputElement).value).toBe('25')
  })

  it('invite à renseigner les champs tant que la saisie est incomplète', () => {
    const wrapper = mount(SalesPotential)
    expect(wrapper.text()).toContain('Entrez vos informations dans les champs ci-dessus')
  })

  it("estime le chiffre d'affaires global avec une saisie valide", async () => {
    const wrapper = mount(SalesPotential)

    await wrapper.find('#nbCustomers').setValue(10)
    await wrapper.find('#averageCart').setValue(50)
    await wrapper.find('#nbFollowers').setValue(1000)
    await wrapper.find('#manualConversionRate').setValue(10)

    // CA boutique = 10 * 50 = 500 ; CA conversion = 1000 * 10% * 50 = 5000 ; total = 5500
    const text = wrapper.text()
    expect(text).toContain(formatEUR(5000)) // CA supplémentaire
    expect(text).toContain(formatEUR(500)) // CA boutique physique
    expect(text).toContain(formatEUR(5500)) // CA global
  })

  it("affiche un message d'erreur pour un nombre de clients invalide", async () => {
    const wrapper = mount(SalesPotential)
    await wrapper.find('#nbCustomers').setValue(0)
    expect(wrapper.text()).toContain('Vous devez entrer au moins 1 client.')
  })
})
