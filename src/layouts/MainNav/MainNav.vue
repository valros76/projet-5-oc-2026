<script setup lang="ts">
import { ref, type Ref } from 'vue'
const menuState: Ref<boolean, boolean> = ref(false)
const toggleMenu = (e: any) => {
  e.preventDefault()
  menuState.value = !menuState.value
  e.stopPropagation()
}

const closeMenu = (e: any) => {
  e.preventDefault()
  menuState.value = false
  e.stopPropagation()
}
</script>

<template>
  <button class="nav-btn" :data-state="menuState ? 'open' : 'close'" @click="toggleMenu">
    <span class="nav-btn-icon-open" v-if="!menuState">
      <i class="material-symbols-rounded"> menu </i>
    </span>
    <span class="nav-btn-icon-close" v-if="menuState">❌</span>
  </button>
  <nav class="main-nav" :class="menuState ? 'open' : 'close'">
    <RouterLink to="/" class="main-menu-links cta-links-secondary" @click="closeMenu">
      Page d'accueil
    </RouterLink>
    <RouterLink
      to="/gites/site-pour-gite-en-baie-de-somme"
      class="main-menu-links"
      @click="closeMenu"
    >
      Pour les gérants de gîte
    </RouterLink>

    <RouterLink
      to="/artisans/site-pour-artisan-en-baie-de-somme"
      class="main-menu-links"
      @click="closeMenu"
    >
      Pour les artisans
    </RouterLink>

    <RouterLink
      to="/commercants/site-pour-boutique-commercant-local-en-baie-de-somme"
      class="main-menu-links"
      @click="closeMenu"
    >
      Pour les commerçants
    </RouterLink>
    <RouterLink to="/nous-contacter" class="main-menu-links" @click="closeMenu">
      Nous contacter
    </RouterLink>

    <RouterLink to="/rgpd" class="main-menu-links cta-links-secondary" @click="closeMenu">
      RGPD
    </RouterLink>
    <RouterLink to="/cgu-cgv" class="main-menu-links cta-links-secondary" @click="closeMenu">
      CGU & CGV
    </RouterLink>
    <RouterLink
      to="/mentions-legales"
      class="main-menu-links cta-links-secondary"
      @click="closeMenu"
    >
      Mentions légales
    </RouterLink>
  </nav>
</template>

<style scoped>
.main-nav {
  overflow-y: auto;
}
.close {
  opacity: 0;
  pointer-events: none;

  &.nav-btn-icon-close {
    opacity: 0;
  }

  &.nav-btn-icon-open {
    opacity: 1;
  }
}

.open {
  opacity: 1;
  pointer-events: all;

  &.nav-btn-icon-close {
    opacity: 1;
  }

  &.nav-btn-icon-open {
    opacity: 0;
  }
}
</style>
