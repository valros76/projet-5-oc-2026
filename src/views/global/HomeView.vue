<script setup lang="ts">
import ArticlesFragments from '@/components/views/fragments/home/ArticlesFragments.vue'
import SocialsFragments from '@/components/views/fragments/home/SocialsFragments.vue'
import ContactCtaCard from '@/components/views/fragments/home/ContactCtaCard.vue'
</script>

<template>
  <section class="main-sections">
    <!--Articles-->
    <ArticlesFragments />
  </section>

  <section class="main-sections">
    <h1 class="main-sections-title">Nos réseaux sociaux</h1>
    <!--Socials-->
    <SocialsFragments />
  </section>

  <section class="main-sections">
    <h1 class="main-sections-title">Nous contacter</h1>
    <!--Contact cta card-->
    <ContactCtaCard />
  </section>
</template>
