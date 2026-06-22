const CACHE_VERSION = 'v3';
const CACHE_NAME = `cache-${CACHE_VERSION}`;
const assets = [
  '/',
  '/offline.html',
  '/sources/css/init.css',
];

// Installation : mise en cache initiale
self.addEventListener('install', (event) => {
  event.waitUntil(
    caches.open(CACHE_NAME).then((cache) => cache.addAll(assets))
  );
  self.skipWaiting(); // Active immédiatement le nouveau SW
});

// Activation : nettoyage des anciens caches
self.addEventListener('activate', (event) => {
  event.waitUntil(
    caches.keys().then((cacheNames) =>
      Promise.all(
        cacheNames.map((cache) => {
          if (cache !== CACHE_NAME) {
            return caches.delete(cache);
          }
        })
      )
    )
  );
  clients.claim();
});

// Fetch : cache dynamique + fallback
self.addEventListener('fetch', (event) => {
  event.respondWith(
    caches.match(event.request).then((cachedResponse) => {
      if (cachedResponse) return cachedResponse;

      return fetch(event.request).then((response) => {
        if (event.request.url.startsWith('http')) {
          caches.open(CACHE_NAME).then((cache) => cache.put(event.request, response.clone()));
        }
        return response;
      });
    }).catch(() => caches.match('/offline.html'))
  );
});
