<script setup lang="ts">
import { useRouter } from 'vue-router'
import MainNav from '../MainNav/MainNav.vue'

const router = useRouter()

const goToHome = () => {
  router.replace('/')
}
</script>

<template>
  <header class="main-head">
    <figure class="logo-header" @click="goToHome">
      <img
        alt="Vue logo"
        class="logo"
        src="/assets/logo/logo-comete-webdevoo-green-2023-256x256.svg"
        width="125"
        height="125"
      />
      <figcaption class="logo-title">
        <h1 class="main-head-title">Webdevoo</h1>
      </figcaption>
    </figure>
    <a class="cta-links phone-link-head" href="tel:+33750474757"> Passer un appel </a>
    <MainNav />
  </header>
</template>
