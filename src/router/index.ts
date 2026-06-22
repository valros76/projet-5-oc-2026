import { createRouter, createWebHistory } from 'vue-router'

const router = createRouter({
  scrollBehavior(to, from, savedPosition) {
    // always scroll to top
    return { top: 0 }
  },
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
    {
      path: "/",
      name: "Webdevoo, créateur de sites internet et organisme de formation depuis 2019",
      meta: { 
        title: "Webdevoo, créateur de sites internet et organisme de formation depuis 2019"
       },
      component: () => import('../views/global/HomeView.vue'),
    },
    {
      path:"/gites/site-pour-gite-en-baie-de-somme",
      name: "Site internet pour un gîte en Baie de Somme : boostez vos réservations directes sans commission",
      meta: {
        title: "Site internet pour un gîte en Baie de Somme : boostez vos réservations directes sans commission",
        description: "Gérants de gîtes en Baie de Somme, stop aux commissions Airbnb ! Webdevoo crée votre site de réservation directe. Calculez vos économies de commissions en 3 clics.",
        image: "/assets/images/business/gite-baie-de-somme.png"
      },
      component: () => import("../views/landing/CottageLanding.vue")
    },
    {
      path:"/artisans/site-pour-artisan-en-baie-de-somme",
      name: "Création site internet artisan somme : gagnez vos premiers devis locaux sans prospecter",
      meta: {
        title: "Création site internet artisan somme : gagnez vos premiers devis locaux sans prospecter",
        description: "Ne perdez plus vos soirées à prospecter après vos journées de travail, laissez les clients vous découvrir.",
        image: "/assets/images/business/artisan-baie-de-somme.png"
      },
      component: () => import("../views/landing/ArtisanLanding.vue")
    },
    {
      path:"/commercants/site-pour-boutique-commercant-local-en-baie-de-somme",
      name: "Boutique en ligne produits locaux dans la Somme : vendez vos produits dans toute la france",
      meta: {
        title: "Boutique en ligne produits locaux dans la Somme : vendez vos produits dans toute la france",
        description: "Vous tenez une boutique dans la Somme ? Vendez vos produits locaux dans toute la France avec Webdevoo. Découvrez notre solution simple pour expédier vos produits",
        image: "/assets/images/business/boutique-locale-baie-de-somme.png"
      },
      component: () => import("../views/landing/MerchantLanding.vue")
    },
    {
      path: "/nous-contacter",
      name: "Contacter Webdevoo, concepteur de sites web et boutiques en ligne depuis 2019",
      meta: { 
        title: "Contacter Webdevoo, concepteur de sites web et boutiques en ligne depuis 2019"
       },
      component: () => import("../views/global/ContactView.vue"),
    },
    {
      path: "/message-envoye",
      name: "Message envoyé - Webdevoo",
      meta: { 
        title: "Message envoyé - Webdevoo"
       },
      component: () => import("../views/global/MessageSend.vue"),
    },
    {
      path: "/nous-recontacter",
      name: "Essayer de recontacter Webdevoo, concepteur de sites web et boutiques en ligne depuis 2019",
      meta: { 
        title: "Essayer de recontacter Webdevoo, concepteur de sites web et boutiques en ligne depuis 2019"
       },
      component: () => import("../views/error/ContactError.vue"),
    },
    {
      path: "/rgpd",
      name: "RGPD & Politique de cookies - Webdevoo",
      meta: { 
        title: "RGPD & Politique de cookies - Webdevoo"
       },
      component: () => import("../views/global/RGPDView.vue"),
    },
    {
      path: "/cgu-cgv",
      name: "CGU & CGV - Webdevoo",
      meta: { 
        title: "CGU & CGV - Webdevoo" 
      },
      component: () => import("../views/global/CGUAndCGVView.vue"),
    },
    {
      path: "/mentions-legales",
      name: "Mentions légales - Webdevoo",
      meta: { 
        title: "Mentions légales - Webdevoo" 
      },
      component: () => import("../views/global/LegalMentionsView.vue"),
    },
    {
      path: "/admin/register",
      name: "Création d'un compte administrateur - Webdevoo",
      meta: { 
        title: "Création d'un compte administrateur - Webdevoo" 
      },
      component: () => import("../views/admin/RegisterAdmin.vue"),
    },
    {
      path: "/admin/statistiques",
      name: "Statistiques de tracking - Webdevoo",
      meta: { 
        title: "Statistiques de tracking - Webdevoo" 
      },
      component: () => import("../views/admin/TrackingStats.vue"),
    },
    {
      path: '/:pathMatch(.*)*',
      name: "Erreur 404 - Webdevoo",
      meta: { 
        title: "Erreur 404 - Webdevoo" 
      },
      component: () => import("../views/error/404.vue"),
    }
  ],
})

export default router
