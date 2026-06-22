<script lang="ts" setup>
import { artisanJobs } from '@/stores/jobs'
import { onUnmounted, ref, watch } from 'vue'
import { useTracker } from '@/composables/useTracker'
import { debounce } from '@/utils/debounce'

const baseSearchUrl = 'https://www.google.com/search?q='
const searchUrl = ref(baseSearchUrl)

const jobInput = ref(false)
const job = ref('')
const city = ref('')
const artisanJobsList = ref(artisanJobs)
const { trackEvent } = useTracker()

const toggleJobInput = () => (jobInput.value = !jobInput.value)

const cleanGoogleQuery = (target?: string): string => {
  if (!target) return ''
  target = target.toLowerCase()
  target = encodeURIComponent(target)
  return target
}

watch([job, city], () => {
  searchUrl.value = baseSearchUrl
  if (city.value)
    searchUrl.value += `${cleanGoogleQuery(job.value)}+${cleanGoogleQuery(city.value)}`
})

const handleBlur = debounce((fieldName: string, value?: string) => {
  if (!value || value === '') return
  trackEvent('form_input_filled', {
    field: fieldName,
    value: value,
    page: 'local_visibility',
  })
}, 500)

const handleClick = debounce((cta_name: string) => {
  trackEvent('form_input_filled', {
    cta_name: cta_name,
    page: 'local_visibility',
  })
}, 500)

// On stocke le type de setTimeout, qui diffère en fonction du navigateur ou de NodeJS
let trackingTimeout: ReturnType<typeof setTimeout>

onUnmounted(() => {
  clearTimeout(trackingTimeout)
})

watch([job, city], () => {
  clearTimeout(trackingTimeout)
  trackingTimeout = setTimeout(async () => {
    try {
      const datas = {
        job: job.value,
        city: city.value,
        searchUrl: searchUrl.value,
      }
      await trackEvent('local_visibility_calculated', datas)
    } catch (e) {
      console.warn('Tracking silencieux : échec envoi')
    }
  }, 2000)
})
</script>

<template>
  <article class="main-articles">
    <h2 class="main-articles-title">Testez votre référencement sur votre ville</h2>
    <p v-if="job && city">Vous avez indiqué être {{ job }}, à {{ city }}.</p>
    <label v-if="!jobInput" for="jobSelect"> Votre métier : </label>
    <select
      v-if="!jobInput"
      v-model="job"
      name="jobSelect"
      id="jobSelect"
      @blur="handleBlur('job', job)"
    >
      <option value="" disabled>Sélectionnez votre métier</option>
      <option v-for="(value, index) in artisanJobsList" :key="index" :value="value">
        {{ value }}
      </option>
    </select>
    <label v-if="jobInput" for="job"> Renseignez votre métier : </label>
    <input
      v-if="jobInput"
      type="text"
      placeholder="ébéniste"
      v-model="job"
      @blur="handleBlur('job', job)"
      name="job"
      id="job"
    />
    <button @click="toggleJobInput" class="cta-links small">
      Votre métier n'est pas dans la liste ?
    </button>
    <label for="city"> Votre ville : </label>
    <input
      type="text"
      placeholder="Saint-Valery-sur-Somme"
      v-model="city"
      name="city"
      id="city"
      @blur="handleBlur('city', city)"
    />
    <a
      v-if="job && city"
      :href="searchUrl"
      target="_blank"
      rel="noopener noreferrer"
      class="cta-links"
      @click="handleClick('Lancer la recherche locale')"
      >Lancer la recherche locale</a
    >
  </article>
</template>

<style scoped></style>
