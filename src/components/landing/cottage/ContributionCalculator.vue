<script lang="ts" setup>
import { computed, onUnmounted, ref, watch } from 'vue'
import { useTracker } from '@/composables/useTracker'
import { debounce } from '@/utils/debounce'

const contribution = ref(0)
const nightPrice = ref(0)
const nbChambers = ref(0)
const { trackEvent } = useTracker()

const contributionErrorMessage = computed(() => {
  if (contribution.value <= 0) return 'La cotisation doit être supérieure à 0%.'
  if (contribution.value > 100) return 'La cotisation doit être inférieure ou égale à 100%.'
  return null
})
const nightPriceErrorMessage = computed(() => {
  if (contribution.value <= 0) return 'Le prix de la nuit doit être supérieur à 0€.'
  return null
})
const nbChambersErrorMessage = computed(() => {
  if (nbChambers.value <= 0) return 'Vous devez avoir au moins une chambre à louer.'
  return null
})

const totalContributions = computed(() => {
  const result = nightPrice.value * (contribution.value / 100) * 365 * nbChambers.value

  return new Intl.NumberFormat('fr-FR', {
    style: 'currency',
    currency: 'EUR',
    minimumFractionDigits: 2,
  }).format(result)
})

const handleBlur = debounce((fieldName: string, value: number) => {
  if (value <= 0) return
  trackEvent('form_input_filled', {
    field: fieldName,
    value: value,
    page: 'contribution_calculator',
  })
}, 500)

// On stocke le type de setTimeout, qui diffère en fonction du navigateur ou de NodeJS
let trackingTimeout: ReturnType<typeof setTimeout>

onUnmounted(() => {
  clearTimeout(trackingTimeout)
})

const isInputsValid = computed(() => {
  return nightPrice.value > 0 && contribution.value > 0 && nbChambers.value > 0
})

watch(isInputsValid, (isValid) => {
  if (isValid) {
    clearTimeout(trackingTimeout)
    trackingTimeout = setTimeout(async () => {
      try {
        const datas = {
          nightPrice: nightPrice.value,
          contribution: contribution.value,
          nbChambers: nbChambers.value,
          totalContributions: totalContributions.value,
        }
        await trackEvent('contribution_calculator_calculated', datas)
      } catch (e) {
        console.warn('Tracking silencieux : échec envoi')
      }
    }, 2000)
  }
})
</script>

<template>
  <article class="main-articles">
    <h2 class="main-articles-title">Calculez le coût annuel de vos cotisations</h2>
    <label for="percent">
      Quel est le pourcentage (%) de cotisation que vous payez actuellement ?
    </label>
    <input
      type="number"
      v-model.number="contribution"
      name="percent"
      id="percent"
      min="1"
      max="100"
      @blur="handleBlur('contribution', contribution)"
    />
    <p v-if="contributionErrorMessage" style="color: var(--color-error)">
      {{ contributionErrorMessage }}
    </p>
    <label for="nightPrice"> Quel est le prix d'une nuit dans votre établissement ? </label>
    <input
      type="number"
      v-model.number="nightPrice"
      name="nightPrice"
      id="nightPrice"
      min="1"
      @blur="handleBlur('nightPrice', nightPrice)"
    />
    <p v-if="nightPriceErrorMessage" style="color: var(--color-error)">
      {{ nightPriceErrorMessage }}
    </p>
    <label for="nbChambers"> Combien de chambre avez-vous de disponible à la location ? </label>
    <input
      type="number"
      v-model.number="nbChambers"
      name="nbChambers"
      id="nbChambers"
      min="1"
      @blur="handleBlur('nbChambers', nbChambers)"
    />
    <p v-if="nbChambersErrorMessage" style="color: var(--color-error)">
      {{ nbChambersErrorMessage }}
    </p>

    <p>
      En louant {{ nbChambers }} chambres pendant 365 jours, vous pouvez donc économiser
      <strong>{{ totalContributions }}</strong> en investissant dans votre propre outil de
      réservation en ligne.
    </p>
  </article>
</template>

<style scoped></style>
