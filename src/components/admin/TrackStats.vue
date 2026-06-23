<script setup lang="ts">
import { useTracker } from '@/composables/useTracker'
import type { TrackingEventI } from '@/interfaces/trackingI'
import { computed, nextTick, onMounted, onUnmounted, ref, watch } from 'vue'

const nbPages = ref(1)
const actualPage = ref(0)
const cursors = ref<number[]>([0])
const limit = ref(10)
const eventsCount = ref(0)
const maxId = ref(0)
const isLoading = ref(false)
const events = ref<TrackingEventI[]>([])
const { getTrackEvents, countEvents } = useTracker()
let intervalId: ReturnType<typeof setInterval> | null = null
let controller: AbortController | null = null

const determineNbPages = async () => {
  eventsCount.value = await countEvents()
  nextTick()
  nbPages.value = Number(Math.ceil(eventsCount.value / limit.value))
}

const loadEvents = async () => {
  if (controller) controller.abort()
  controller = new AbortController()
  isLoading.value = true

  try {
    await determineNbPages()
    nextTick()

    let lastId = actualPage.value

    if (limit.value > eventsCount.value) limit.value = eventsCount.value

    const data = await getTrackEvents(lastId, limit.value, controller.signal)

    maxId.value = data?.params?.[0].max_id || 0
    const newItems = data?.params?.[0]?.datas || []

    if (newItems.length > 0) {
      const lastItem = newItems[newItems.length - 1]
      cursors.value[actualPage.value + 1] = lastItem.id
    }

    let combined = [...newItems]

    const uniqueEvents = Array.from(new Map(combined.map((e) => [e.id, e])).values())

    events.value = uniqueEvents.sort((a, b) => b.id - a.id)
  } catch (e: any) {
    if (e.name !== 'AbortError') console.error('Erreur:', e)
  } finally {
    isLoading.value = false
  }
}

const parseMeta = (meta: string) => {
  try {
    return JSON.parse(meta)
  } catch {
    return { raw: meta }
  }
}

const handleChangePage = (newPage: number) => {
  if (newPage < 0) newPage = 0
  if (newPage > nbPages.value) newPage = nbPages.value
  if (actualPage.value === Number(newPage)) return
  actualPage.value = Number(newPage)
  nextTick()
  loadEvents()
}

const visibleNavigationPages = computed(() => {
  const currentPage = actualPage.value + 1
  const totalPages = nbPages.value
  let delta = 1 // Nombres de pages à afficher autour de la page active

  if (currentPage === 1 || currentPage === totalPages || currentPage === totalPages - 1) {
    delta = 3
  }

  if (currentPage === 2 || currentPage === totalPages - 1) delta = 2

  const range = []
  for (let i = 1; i <= nbPages.value; i++) {
    if (i === 1 || (i >= currentPage - delta && i <= currentPage + delta) || i === totalPages) {
      range.push(i)
    }
  }
  return range
})

const getLimitedDatas = (newLimit: number) => {
  limit.value = Number(newLimit);
}

watch(nbPages, () => {
  if (nbPages.value < 0) nbPages.value = 0
})

watch(limit, async () => {
  eventsCount.value = await countEvents()
  await determineNbPages()
  loadEvents()
});

onMounted(async () => {
  eventsCount.value = await countEvents()
  await determineNbPages()
  loadEvents()
})

onUnmounted(() => {
  if (controller) controller.abort() // Annule la requête en cours si l'utilisateur quitte la page
})
</script>

<template>
  <article class="main-articles toolbar">
    <h2 class="main-articles-title">Sélection du nombre de logs (MAX : {{ eventsCount }})</h2>
    <select v-model="limit">
      <option :value="eventsCount" selected>Nombre d'events : {{ eventsCount }}</option>
      <option value="5">5</option>
      <option value="10">10</option>
      <option value="25">25</option>
      <option value="50">50</option>
      <option value="100">100</option>
      <option value="250">250</option>
      <option value="500">500</option>
      <option value="1000">1000</option>
    </select>

    <button :disabled="isLoading" @click="loadEvents()">
      {{ isLoading ? 'Chargement...' : "Charger plus d'événements" }}
    </button>
  </article>

  <article class="table-container">
    <nav class="pagination-container">
      <button
        v-for="page in visibleNavigationPages"
        :key="page"
        type="button"
        class="pagination-btn"
        :class="{
          active: page === actualPage + 1,
          first: page === 1,
          last: page === nbPages,
          previous: page === actualPage,
          next: page === actualPage + 2,
        }"
        @click.prevent="handleChangePage(page - 1)"
      >
        {{ page }}
      </button>
    </nav>
    <table>
      <thead>
        <tr>
          <th>ID</th>
          <th>Date</th>
          <th>Événement</th>
          <th>Page</th>
          <th>Détails (Metadata)</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="(event, index) in events" :key="index">
          <td>{{ event.id }}</td>
          <td class="date-col">{{ event.created_at }}</td>
          <td class="event-name">
            <code>{{ event.event_name }}</code>
          </td>
          <td class="url-col">
            {{ event.page_url.split('/').pop() || 'home' }}
          </td>
          <td>
            <pre class="meta-box">{{ parseMeta(event.metadata) }}</pre>
          </td>
        </tr>
      </tbody>
    </table>
  </article>
</template>

<style scoped>
.table-container {
  overflow-x: auto;
  margin-top: 2rem;
}
table {
  width: 100%;
  border-collapse: collapse;
  font-size: 0.9rem;
}
th {
  text-align: left;
  background: #f4f4f9;
  padding: 12px;
  border-bottom: 2px solid #ddd;
}
td {
  padding: 12px;
  border-bottom: 1px solid #eee;
  vertical-align: top;
}

.date-col {
  white-space: nowrap;
  color: #666;
}
.event-name code {
  background: #eef;
  padding: 2px 6px;
  border-radius: 4px;
  color: #336;
}
.url-col {
  max-width: 200px;
  overflow: hidden;
  text-overflow: ellipsis;
  font-size: 0.8rem;
}
.meta-box {
  background: #fafafa;
  padding: 8px;
  font-size: 0.75rem;
  max-height: 100px;
  overflow-y: auto;
}

.pagination-container {
  max-width: 100%;
  display: flex;
  justify-content: center;
  align-items: center;
  flex-wrap: nowrap;
  gap: var(--padding-regular);
  overflow-x: auto;
  margin-inline: auto;
}

.pagination-btn {
  width: 36pt;
  height: 36pt;
  line-height: 1;
  display: inline-flex;
  justify-content: center;
  align-items: center;
  flex-shrink: 0;
  font-size: 12pt;
  margin: 0;
  padding: 2pt;
  border-radius: var(--padding-small);
  scale: 0.85;

  &:is(.previous, .next) {
    scale: 0.85;
  }

  &:is(.first, .last) {
    scale: 0.75;
  }

  &:is(.first) {
    margin-inline: 0 var(--padding-bigger);
  }

  &:is(.last) {
    margin-inline: var(--padding-bigger) 0;
  }

  &:is(.active) {
    scale: 1;
    border-style: double;
  }
}
</style>
