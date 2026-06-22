<script lang="ts" setup>
import { onUnmounted, ref, watch } from 'vue'
import { frenchZones } from '@/stores/geoZones'
import { useTracker } from '@/composables/useTracker'
import { debounce } from '@/utils/debounce'

const baseSearchUrl = 'https://www.google.com/search?q=artisan'
const searchUrl = ref(baseSearchUrl)

const userZones = ref(frenchZones)
const selectedRegion = ref<string | undefined>('')
const selectedDepartment = ref<string | undefined>('')
const { trackEvent } = useTracker()

watch(selectedRegion, () => {
  selectedDepartment.value = undefined
})

const cleanGoogleQuery = (target?: string): string => {
  if (!target) return ''
  target = target.toLowerCase()
  target = encodeURIComponent(target)
  return target
}

watch(selectedRegion, () => {
  selectedDepartment.value = ''
})

watch([selectedRegion, selectedDepartment], () => {
  searchUrl.value = baseSearchUrl
  if (selectedDepartment.value) searchUrl.value += `+${cleanGoogleQuery(selectedDepartment.value)}`
})

const handleBlur = debounce((fieldName: string, value?: string) => {
  if (!value || value === '') return
  trackEvent('form_input_filled', {
    field: fieldName,
    value: value,
    page: 'department_visibility',
  })
}, 500)

const handleClick = debounce((cta_name: string) => {
  trackEvent('form_input_filled', {
    cta_name: cta_name,
    page: 'department_visibility',
  })
}, 500)

// On stocke le type de setTimeout, qui diffère en fonction du navigateur ou de NodeJS
let trackingTimeout: ReturnType<typeof setTimeout>

onUnmounted(() => {
  clearTimeout(trackingTimeout)
})

watch([selectedRegion, selectedDepartment], () => {
  clearTimeout(trackingTimeout)
  trackingTimeout = setTimeout(async () => {
    try {
      const datas = {
        selectedRegion: selectedRegion.value,
        selectedDepartment: selectedDepartment.value,
        searchUrl: searchUrl.value,
      }
      await trackEvent('department_visibility_calculated', datas)
    } catch (e) {
      console.warn('Tracking silencieux : échec envoi')
    }
  }, 2000)
})
</script>

<template>
  <article class="main-articles">
    <h2 class="main-articles-title">Testez votre référencement sur votre département</h2>
    <p v-if="selectedRegion && !selectedDepartment">Région : {{ selectedRegion }}</p>
    <p v-else-if="selectedRegion && selectedDepartment">
      Région : {{ selectedRegion }} | Département :
      {{ selectedDepartment }}
    </p>
    <p v-else>Sélectionnez votre région</p>
    <select
      name="userRegion"
      id="userRegion"
      v-model="selectedRegion"
      @blur="handleBlur('selectedRegion', selectedRegion)"
    >
      <option value="" disabled>Sélectionnez votre région</option>
      <option v-for="(label, value) in userZones.regions" :key="value" :value="value">
        {{ value }}
      </option>
    </select>
    <select
      name="userDepartment"
      id="userDepartment"
      v-model="selectedDepartment"
      v-if="selectedRegion"
      @blur="handleBlur('selectedDepartment', selectedDepartment)"
    >
      <option value="" disabled>Sélectionnez votre département</option>
      <option
        v-for="(dept, index) in userZones?.regions[selectedRegion]?.regionsDepartments"
        :key="index"
        :value="dept"
      >
        {{ dept }}
      </option>
    </select>
    <a
      v-if="selectedDepartment"
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
