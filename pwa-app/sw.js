const CACHE_NAME = 'bulktools-cache-v7'; // Hybrid Processing Update
const ASSETS_TO_CACHE = [
  '/pwa-app/',
  '/pwa-app/index.html',
  '/pwa-app/offline.html',
  '/pwa-app/app/app.js',
  '/pwa-app/app/assets/css/style.css',
  '/pwa-app/app/assets/icon-192.png',
  '/pwa-app/app/assets/icon-512.png',
  '/pwa-app/app/components/home.html',
  '/pwa-app/app/components/dashboard.html',
  '/pwa-app/app/components/profile.html',
  '/pwa-app/app/components/settings.html',
  '/pwa-app/app/components/all-tools.html',
  '/pwa-app/app/components/compressor.html',
  '/pwa-app/app/components/timer.html',
  '/pwa-app/app/components/text-editor.html',
  '/pwa-app/app/components/drawing-board.html',
  '/pwa-app/app/components/qr-generator.html',
  '/pwa-app/app/components/hindi-typing.html',
  '/pwa-app/manifest.json',
  '/pwa-app/version.json'
];

// Install Event - Cache Core Assets
self.addEventListener('install', (event) => {
  // We NO LONGER call self.skipWaiting() here.
  // This allows the new SW to stay in 'waiting' state until user confirms via the UI.
  
  event.waitUntil(
    caches.open(CACHE_NAME).then((cache) => {
      console.log('[SW] Pre-caching assets');
      return cache.addAll(ASSETS_TO_CACHE);
    })
  );
});

// Activate Event - Clean up old caches
self.addEventListener('activate', (event) => {
  event.waitUntil(
    caches.keys().then((cacheNames) => {
      return Promise.all(
        cacheNames.map((cacheName) => {
          if (cacheName !== CACHE_NAME) {
            console.log('[SW] Deleting old cache:', cacheName);
            return caches.delete(cacheName);
          }
        })
      );
    }).then(() => {
        // Take control of all open clients immediately after activation
        return self.clients.claim();
    })
  );
});

// Message Event - Handle SKIP_WAITING from frontend
self.addEventListener('message', (event) => {
  if (event.data && event.data.type === 'SKIP_WAITING') {
    console.log('[SW] Skipping waiting state as requested by user');
    self.skipWaiting();
  }
});

// Fetch Event - Stale-While-Revalidate Strategy
self.addEventListener('fetch', (event) => {
  // Pass API requests directly to the network
  if (event.request.url.includes('/api/')) return;

  event.respondWith(
    caches.match(event.request).then((cachedResponse) => {
      const fetchPromise = fetch(event.request).then((networkResponse) => {
        // Cache the fresh response dynamically
        const isThirdPartyCDN = event.request.url.includes('unpkg.com') || 
                               event.request.url.includes('cdn.quilljs.com') || 
                               event.request.url.includes('cdn.jsdelivr.net') || 
                               event.request.url.includes('fonts.googleapis.com') || 
                               event.request.url.includes('fonts.gstatic.com');
        
        if(networkResponse && (networkResponse.status === 200 || networkResponse.status === 0) && (networkResponse.type === 'basic' || networkResponse.type === 'cors' || isThirdPartyCDN)) {
          const responseToCache = networkResponse.clone();
          caches.open(CACHE_NAME).then((cache) => {
            cache.put(event.request, responseToCache);
          });
        }
        return networkResponse;
      }).catch(() => {
         // Network failed, if nothing in cache and it's navigation, return offline page
         if (!cachedResponse && event.request.mode === 'navigate') {
             return caches.match('/pwa-app/offline.html');
         }
      });
      // Return cached immediately, otherwise wait for network
      return cachedResponse || fetchPromise;
    })
  );
});
