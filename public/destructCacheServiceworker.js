// remove old cache if any
self.addEventListener('activate', (event) => {
  event.waitUntil((async () => {
    const cacheNames = await caches.keys();

    await Promise.all(cacheNames.map(async (cacheName) => {
      if (self.cacheName !== cacheName) {
        await caches.delete(cacheName);
      }
    }));
  })());
});