<script setup lang="ts">
import { authStore } from '@/stores/authStore';
import { onMounted } from 'vue';
import { useRouter } from 'vue-router';

const router = useRouter();
const {clearUserStored} = authStore();

onMounted(() => {
  clearUserStored();
  router.replace("/admin/register");
});
</script>

<template>
  <section class="main-sections">
    <h1 class="main-sections-title">Déconnexion</h1>
    <p>Votre compte a été déconnecté. Vous allez être redirigé automatiquement.</p>
  </section>
</template>
