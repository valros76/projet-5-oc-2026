import '/public/sources/css/init.css'

import { createApp } from 'vue'
import { createPinia, storeToRefs } from 'pinia'
import { createHead, useHead } from '@unhead/vue'

import App from './App.vue'
import router from './router'
import { createGtm } from '@gtm-support/vue-gtm'
import { authStore } from './stores/authStore.ts'

const app = createApp(App)

const head = createHead();

useHead({
  title: "Webdevoo, créateur de sites internet et organisme de formation depuis 2019",
  meta: [
    { name: 'description', content: "Webdevoo : création de sites internet et organisme de formation (80132 - Somme)." },
  ]
});

router.beforeEach(async (to, from) => {
  const store = authStore();
  const { user } = storeToRefs(store);
  const path = to.path;
  switch (path) {
    case "/admin/statistiques":
      const canAccess = !user.value ? false : true;
      if (!canAccess) return "/admin/register";
      break;
    default:
      return true;
  }
});

router.afterEach((to) => {
  useHead({
    title:
      to.meta.title ??
      "Webdevoo, créateur de sites internet et organisme de formation depuis 2019",
    meta: [
      {
        name: "description",
        content: String(
          to.meta.description ||
          "Webdevoo : création de sites internet et organisme de formation (80132 - Somme)."
        ),
      },
      {
        property: "og:title",
        content: typeof to.meta.title === "string" ? to.meta.title : "Webdevoo, créateur de sites internet et organisme de formation depuis 2019",
      },
      {
        property: "og:description",
        content: typeof to.meta.description === "string" ? to.meta.description : "Création de Site Internet & E-commerce | Forfaits dès 1000€ | Webdevoo"
      },
      {
        property: "og:image",
        content: (window.location.origin + to.meta.image) || "https://webdevoo.com/assets/logo/logo-comete-webdevoo-green-2023-rounded-256x256.svg?v=0.0.3"
      },
      {
        property: "og:type",
        content: "website"
      }
    ],
  });
});

app.use(createPinia())
app.use(router)
app.use(head)

app.use(
  createGtm({
    id: "G-78J1QMWPR4",
    vueRouter: router
  })
)

if ("serviceWorker" in navigator) {
  navigator.serviceWorker.addEventListener('message', (event) => {
    if (event.data?.type === 'NEW_VERSION_AVAILABLE') {
      if (confirm('🔄 Une nouvelle version est disponible. Recharger la page ?')) {
        window.location.reload();
      }
    }
  });
}
/**
 * Notification d'une nouvelle version différente du cache serviceWorker
 */


app.mount('#app')
