const CACHE_NAME = `cache-v${Date.now()}`;
const assets = [
    "/",
    "/assets/offline.html",
    "/sources/css/init.css"
];

if ("serviceWorker" in navigator) {
    navigator.serviceWorker.register('/serviceWorker.js', {
        scope: '/' // Force le SW à gérer tout le domaine, y compris /artisans/
    });
}

self.addEventListener("install", (e) => {
    e.waitUntil(
        caches.open(CACHE_NAME).then((cache) => {
            return cache.addAll(assets);
        })
    );
});

self.addEventListener("fetch", (event) => {
    const url = new URL(event.request.url);

    // 1. Uniquement les requêtes GET (on ne touche pas aux POST de GTM/Stripe)
    if (event.request.method !== 'GET') return;

    // 2. Uniquement les ressources locales (votre site)
    if (url.origin !== location.origin) return;

    // 3. Cache-first uniquement pour les assets locaux
    event.respondWith(
        caches.match(event.request).then((response) => {
            return response || fetch(event.request);
        })
    );
});