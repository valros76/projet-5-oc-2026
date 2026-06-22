<script setup lang="ts">
import MainHead from '../MainHead/MainHead.vue'
import MainFoot from '../MainFoot/MainFoot.vue'
import CapchaDialog from '../CapchaDialog/CapchaDialog.vue'
import Cookies from '../Cookies/Cookies.vue'
</script>

<template>
  <MainHead />
  <CapchaDialog />

  <!-- <Cookies/> -->
  <main class="main-content">
    <video class="video-background" autoplay loop muted playsinline>
      <!-- Source de la vidéo WebM -->
      <source
        :src="'/assets/videos/backgrounds/background-webdevoo-light.webm'"
        type="video/webm"
      />
      <!-- Source de fallback si WebM n'est pas supporté (recommandé) -->
      <source :src="'/assets/videos/backgrounds/background-webdevoo-light.mp4'" type="video/mp4" />
      <!-- Message de fallback si aucune vidéo ne peut être lue -->
      Votre navigateur ne supporte pas la balise vidéo.
    </video>
    <slot></slot>
  </main>
  <MainFoot />
</template>
