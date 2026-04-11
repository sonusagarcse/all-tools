/**
 * BULKTOOLS PWA - Production Service Worker
 * Version: 1.1.2
 * Strategy: Hybrid (Network-First for HTML, Cache-First for Assets)
 */

const CACHE_VERSION = 'v1.1.2';
const CACHE_NAME = `bulktools-cache-${CACHE_VERSION}`;

// Assets that must be available offline
const PRE_CACHE_RESOURCES = [
  '/pwa-app/',
  '/pwa-app/index.html',
  '/pwa-app/offline.html',
  '/pwa-app/manifest.json',
  '/pwa-app/app/assets/css/style.css',
  '/pwa-app/app/app.js',
  '/pwa-app/app/assets/icon-192.png',
  '/pwa-app/app/assets/icon-512.png',
  // Core Components (Network-First will try to update these, but we keep cached for offline)
  '/pwa-app/app/components/home.html',
  '/pwa-app/app/components/all-tools.html',
  '/pwa-app/app/components/dashboard.html',
  '/pwa-app/app/components/settings.html',
  '/pwa-app/app/components/compressor.html'
];

// 1. Install Event - Cold Cache Storage
self.addEventListener('install', (event) => {
  console.log('[SW] Installing version:', CACHE_VERSION);
  event.waitUntil(
    caches.open(CACHE_NAME).then((cache) => {
      return cache.addAll(PRE_CACHE_RESOURCES);
    }).then(() => {
      // Manual update flow is handled by messages from index.html
      // We don't call skipWaiting() here automatically in production
    })
  );
});

// 2. Activate Event - Cache Migration & Cleanup
self.addEventListener('activate', (event) => {
  console.log('[SW] Activating version:', CACHE_VERSION);
  event.waitUntil(
    caches.keys().then((cacheNames) => {
      return Promise.all(
        cacheNames.map((name) => {
          if (name !== CACHE_NAME && name.startsWith('bulktools-cache-')) {
            console.log('[SW] Deleting old cache:', name);
            return caches.delete(name);
          }
        })
      );
    }).then(() => {
      // Tell the browser to allow the SW to take control of currently open tabs immediately
      return self.clients.claim();
    })
  );
});

// 3. Messages - Update Handshake
self.addEventListener('message', (event) => {
  if (event.data && event.data.type === 'SKIP_WAITING') {
    self.skipWaiting();
  }
});

// 4. Fetch Strategy - The "Hard Refresh" Engine
self.addEventListener('fetch', (event) => {
  const url = new URL(event.request.url);

  // Bypass 1: Always use network for APIs and Processing
  if (url.pathname.includes('/api/') || url.pathname.includes('process.php')) {
    event.respondWith(fetch(event.request));
    return;
  }

  // Strategy A: Network-First for HTML and Root
  // This prevents the "Old UI" and "Old Logo" issues by ensuring the shell is always fresh
  if (event.request.mode === 'navigate' || 
      (event.request.method === 'GET' && event.request.headers.get('accept').includes('text/html'))) {
    event.respondWith(
      fetch(event.request).then((networkResponse) => {
        // Update the cache with the newest version of the HTML
        const responseClone = networkResponse.clone();
        caches.open(CACHE_NAME).then((cache) => {
          cache.put(event.request, responseClone);
        });
        return networkResponse;
      }).catch(() => {
        // Network failed (we are offline) - serve from cache
        return caches.match(event.request).then((cachedResponse) => {
          return cachedResponse || caches.match('/pwa-app/offline.html');
        });
      })
    );
    return;
  }

  // Strategy B: Cache-First for Versioned Assets
  // If the request has a ?v= parameter, we trust it and serve from cache if available
  if (url.searchParams.has('v')) {
    event.respondWith(
      caches.match(event.request).then((cachedResponse) => {
        if (cachedResponse) return cachedResponse;
        
        // Fetch and Cache for future use
        return fetch(event.request).then((networkResponse) => {
          const responseClone = networkResponse.clone();
          caches.open(CACHE_NAME).then((cache) => {
            cache.put(event.request, responseClone);
          });
          return networkResponse;
        });
      })
    );
    return;
  }

  // Strategy C: Stale-While-Revalidate for everything else
  event.respondWith(
    caches.match(event.request).then((cachedResponse) => {
      const fetchPromise = fetch(event.request).then((networkResponse) => {
        const responseClone = networkResponse.clone();
        caches.open(CACHE_NAME).then((cache) => {
          cache.put(event.request, responseClone);
        });
        return networkResponse;
      }).catch(() => {
        // Quietly fail network if offline
      });
      return cachedResponse || fetchPromise;
    })
  );
});
