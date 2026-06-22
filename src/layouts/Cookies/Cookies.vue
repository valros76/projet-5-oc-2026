<script setup lang="ts">
import {
  globalCookieState,
  onClickCookieConsent,
  checkCookie,
  getCookie,
  setCookie,
} from '@/stores/CookieState'

const cookieState = globalCookieState
</script>

<template>
  <!-- Template de la bannière cookies. À intégrer dans une div via js. -->
  <div id="cookiesBanner" class="cookies-banner" v-show="!cookieState">
    <div class="cookies-banner-content">
      <h2 class="cookies-banner-title">Cookies et données personnelles</h2>
      <p>
        Webdevoo peut être amené à utiliser des outils tiers, déposant des cookies sur votre
        ordinateur, dans le cadre du suivi des statistiques de fréquentation du site.
      </p>
      <p>
        Pour toute question sur l'utilisation de vos données, veuillez consulter la page
        <RouterLink to="/mentions-legales" class="inline-links">mentions légales</RouterLink>
        de notre site, catégorie "Données personnelles".
      </p>
      <button
        class="cookies-btn cookies-btn-accept"
        id="cookiesConsentBtn"
        @click="(e) => onClickCookieConsent(e)"
      >
        J'accepte les conditions
      </button>
    </div>
  </div>
</template>
