<script setup lang="ts">
const {
  src,
  alt,
  lazy = true,
  className = 'illustration-img',
} = defineProps({
  src: String,
  alt: String,
  lazy: Boolean,
  width: Number,
  height: Number,
  className: String,
})
</script>

<template>
  <img :src="src" :alt="alt" :loading="lazy ? 'lazy' : 'eager'" :class="className" />
</template>

<style scoped>
img {
  width: 480px;
  max-width: 100%;
  height: 480px;
  max-height: 100%;
  aspect-ratio: 1/1;
  object-fit: cover;
  margin-inline: auto;
}
</style>
