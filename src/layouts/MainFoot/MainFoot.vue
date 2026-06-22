<script setup lang="ts">
const actualDate = new Date()
</script>

<template>
  <footer class="main-foot">
    <p class="copyright">
      <RouterLink to="/admin/register" class="hidden-links">
        © Webdevoo - 2019 à {{ actualDate.getFullYear() }}
      </RouterLink>
    </p>
    <a href="#" class="external-nav" id="open_preferences_center"
      >Mettre à jour les paramètres de cookies</a
    >
  </footer>
</template>

<style scoped>
.hidden-links {
  color: inherit;
  cursor: auto;

  &:hover {
    color: inherit;
  }
}
</style>
