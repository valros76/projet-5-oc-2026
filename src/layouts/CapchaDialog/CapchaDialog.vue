<script setup lang="ts">
const MIN_VALUE = 1
const MAX_VALUE = 6
</script>

<template>
  <dialog class="captcha-dialog" id="captcha-dialog">
    <p class="captcha-dialog-legend">ANTI-BOT :</p>
    <p class="captcha-dialog-legend">Sélectionnez le chiffre affiché ci-dessous.</p>
    <p class="captcha-dialog-hint-line">
      <span class="captcha-dialog-hint">[hint]</span>
    </p>
    <div class="captcha-dialog-buttons-grid">
      <button data-validResponse="false" class="captcha-dialog-buttons">1</button>
      <button data-validResponse="false" class="captcha-dialog-buttons">2</button>
      <button data-validResponse="false" class="captcha-dialog-buttons">3</button>
      <button data-validResponse="false" class="captcha-dialog-buttons">4</button>
      <button data-validResponse="false" class="captcha-dialog-buttons">5</button>
      <button data-validResponse="false" class="captcha-dialog-buttons">6</button>
    </div>
    <button class="captcha-dialog-close-button">Annuler l'envoi du message</button>
  </dialog>
</template>
