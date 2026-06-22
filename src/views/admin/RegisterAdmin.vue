<script lang="ts" setup>
import LoginAdmin from '@/components/admin/LoginAdmin.vue'
import RegisterAdmin from '@/components/admin/RegisterAdmin.vue'
import { authStore } from '@/stores/authStore'
import { storeToRefs } from 'pinia'

const store = authStore()
const { user } = storeToRefs(store)
</script>

<template>
  <section class="main-sections">
    <h1 class="main-sections-title">Création d'un compte administrateur</h1>
    <RegisterAdmin v-if="!user" />
    <LoginAdmin v-if="user" />
  </section>
</template>

<style scoped></style>
