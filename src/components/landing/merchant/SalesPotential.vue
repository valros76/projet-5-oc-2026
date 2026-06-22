<script lang="ts" setup>
import { useTracker } from '@/composables/useTracker'
import { debounce } from '@/utils/debounce'
import { computed, onUnmounted, ref, watch } from 'vue'
const nbCustomers = ref(0)
const averageCart = ref(0)
const nbFollowers = ref(0)
const manualConversionRate = ref(25)
const { trackEvent } = useTracker()

const nbCustomersErrorMessage = computed(() => {
  if (nbCustomers.value <= 0) return 'Vous devez entrer au moins 1 client.'
  return null
})

const averageCartErrorMessage = computed(() => {
  if (averageCart.value <= 0) return 'Vous devez entrer au moins 1€ de panier moyen.'
  return null
})

const nbFollowersErrorMessage = computed(() => {
  if (nbFollowers.value <= 0) return 'Vous devez entrer au moins 1 follower.'
  return null
})

const manualConversionRateErrorMessage = computed(() => {
  if (manualConversionRate.value <= 0) return 'Vous devez entrer au moins 1%.'
  return null
})

const potentialConversionRevenue = computed(() => {
  const conversionRate = manualConversionRate.value / 100 // 15% de conversion initialement
  return nbFollowers.value * conversionRate * averageCart.value
})

const formatPrice = (price: number) => {
  return new Intl.NumberFormat('fr-FR', {
    style: 'currency',
    currency: 'EUR',
    minimumFractionDigits: 0,
    maximumFractionDigits: 0,
  }).format(price)
}

const formattedPhysicalRevenue = computed(() => {
  return formatPrice(nbCustomers.value * averageCart.value)
})

const formattedConversionRevenue = computed(() => {
  return formatPrice(potentialConversionRevenue.value)
})

const formattedTotalPrice = computed(() =>
  formatPrice(nbCustomers.value * averageCart.value + potentialConversionRevenue.value),
)

const isInputsValid = computed(() => {
  return (
    nbCustomers.value > 0 &&
    averageCart.value > 0 &&
    nbFollowers.value > 0 &&
    manualConversionRate.value > 0
  )
})

const handleBlur = debounce((fieldName: string, value: number) => {
  if (value <= 0) return
  trackEvent('form_input_filled', {
    field: fieldName,
    value: value,
    page: 'sales_potential',
  })
}, 500)

// On stocke le type de setTimeout, qui diffère en fonction du navigateur ou de NodeJS
let trackingTimeout: ReturnType<typeof setTimeout>

onUnmounted(() => {
  clearTimeout(trackingTimeout)
})

watch(isInputsValid, (isValid) => {
  if (isValid) {
    clearTimeout(trackingTimeout)
    trackingTimeout = setTimeout(async () => {
      try {
        const datas = {
          nbCustomers: nbCustomers.value,
          averageCart: averageCart.value,
          nbFollowers: nbFollowers.value,
          conversionRate: manualConversionRate.value,
          totalEstimatedCA: formattedTotalPrice.value,
        }
        await trackEvent('sales_potential_calculated', datas)
      } catch (e) {
        console.warn('Tracking silencieux : échec envoi')
      }
    }, 2000)
  }
})
</script>

<template>
  <article class="main-articles">
    <h2 class="main-articles-title">Découvrez votre potentiel de vente en ligne</h2>

    <label for="nbCustomers">
      Combien de clients, en moyenne, sur un mois, réalisent un achat dans votre boutique ?
    </label>
    <input
      type="number"
      v-model.number="nbCustomers"
      name="nbCustomers"
      id="nbCustomers"
      min="1"
      @blur="handleBlur('nbCustomers', nbCustomers)"
    />
    <p v-if="nbCustomersErrorMessage" style="color: var(--color-error)">
      {{ nbCustomersErrorMessage }}
    </p>

    <label for="averageCart"> Quel est le montant du panier moyen, en euros, sur un mois ? </label>
    <input
      type="number"
      v-model.number="averageCart"
      name="averageCart"
      id="averageCart"
      min="1"
      @blur="handleBlur('averageCart', averageCart)"
    />
    <p v-if="averageCartErrorMessage" style="color: var(--color-error)">
      {{ averageCartErrorMessage }}
    </p>

    <label for="nbFollowers"> Combien de personnes vous suivent sur les réseaux sociaux ? </label>
    <input
      type="number"
      v-model.number="nbFollowers"
      name="nbFollowers"
      id="nbFollowers"
      min="1"
      @blur="handleBlur('nbFollowers', nbFollowers)"
    />
    <p v-if="nbFollowersErrorMessage" style="color: var(--color-error)">
      {{ nbFollowersErrorMessage }}
    </p>

    <label for="manualConversionRate">
      Sur les réseaux, combien de personnes pensez-vous pouvoir convaincre de passer à l'achat sur
      votre boutique en ligne ? (en pourcents | base initiale de
      {{ manualConversionRate }}%)
    </label>
    <input
      type="number"
      v-model.number="manualConversionRate"
      name="manualConversionRate"
      id="manualConversionRate"
      min="1"
      @blur="handleBlur('manualConversionRate', manualConversionRate)"
    />
    <p v-if="manualConversionRateErrorMessage" style="color: var(--color-error)">
      {{ manualConversionRateErrorMessage }}
    </p>

    <p v-if="isInputsValid">
      Si seulement
      <strong>{{ manualConversionRate }}% de vos abonnés</strong>
      passaient commande, vous pourriez générer
      <strong>{{ formattedConversionRevenue }} de CA supplémentaire</strong>
      sur votre boutique en ligne, en supplément des
      <strong v-if="nbFollowers && averageCart"
        >{{ formattedPhysicalRevenue }} de CA générés par la boutique</strong
      >, soit un total de <strong>{{ formattedTotalPrice }} de CA global</strong>.
      <small style="font-size: 0.8em; color: #666">
        *Estimation basée sur une opération de vente en ligne ponctuelle, communiquée via vos
        réseaux sociaux.
      </small>
    </p>
    <p v-else>
      <strong
        >Entrez vos informations dans les champs ci-dessus pour obtenir un bilan
        personnalisé.</strong
      >
    </p>
  </article>
</template>

<style scoped></style>
