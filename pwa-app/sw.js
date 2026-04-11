/**
 * BULKTOOLS PWA - Production Service Worker
 * Version: 1.2.0
 * Fix: Auto-update, force fresh icons, aggressive cache invalidation
 */

const CACHE_VERSION = 'v1.3.1';
const CACHE_NAME = `bulktools-${CACHE_VERSION}`;

// Assets to pre-cache on install
const PRE_CACHE_RESOURCES = [
  '/pwa-app/',
  '/pwa-app/index.html',
  '/pwa-app/offline.html',
  '/pwa-app/404.html',
  '/pwa-app/manifest.json',
  '/pwa-app/version.json',
  '/pwa-app/app/assets/css/style.css',
  '/pwa-app/app/app.js',
  '/pwa-app/app/assets/icon-192.png',
  '/pwa-app/app/assets/icon-512.png',
  '/pwa-app/app/components/home.html',
  '/pwa-app/app/components/all-tools.html',
  '/pwa-app/app/components/dashboard.html',
  '/pwa-app/app/components/settings.html',
  '/pwa-app/app/components/compressor.html'
];

// ─── 1. INSTALL ────────────────────────────────────────────────────────────────
// Always call skipWaiting() immediately so the new SW takes over instantly.
self.addEventListener('install', (event) => {
  console.log('[SW] Installing:', CACHE_VERSION);
  event.waitUntil(
    caches.open(CACHE_NAME).then((cache) => {
      // Cache-bust every resource during install so icons/assets are always fresh
      const fetches = PRE_CACHE_RESOURCES.map((url) => {
        const bustUrl = url + '?sw=' + CACHE_VERSION;
        return fetch(bustUrl, { cache: 'no-store' })
          .then((res) => {
            if (res.ok) cache.put(url, res);
          })
          .catch(() => { /* Ignore individual failures */ });
      });
      return Promise.all(fetches);
    }).then(() => {
      // CRITICAL: Skip waiting so the new SW activates immediately
      // This is what makes "install = fresh app" work correctly
      return self.skipWaiting();
    })
  );
});

// ─── 2. ACTIVATE ───────────────────────────────────────────────────────────────
self.addEventListener('activate', (event) => {
  console.log('[SW] Activating:', CACHE_VERSION);
  event.waitUntil(
    caches.keys().then((cacheNames) => {
      return Promise.all(
        cacheNames.map((name) => {
          // Delete ALL old bulktools caches (including legacy prefixes)
          if ((name.startsWith('bulktools-') || name.startsWith('bulktools-cache-')) && name !== CACHE_NAME) {
            console.log('[SW] Purging old cache:', name);
            return caches.delete(name);
          }
        })
      );
    }).then(() => {
      // Take control of all open tabs immediately
      return self.clients.claim();
    }).then(() => {
      // Notify all clients that a new version is active
      return self.clients.matchAll({ type: 'window' }).then((clients) => {
        clients.forEach((client) => {
          client.postMessage({ type: 'SW_ACTIVATED', version: CACHE_VERSION });
        });
      });
    })
  );
});

// ─── 3. MESSAGES ───────────────────────────────────────────────────────────────
self.addEventListener('message', (event) => {
  if (event.data && event.data.type === 'SKIP_WAITING') {
    self.skipWaiting();
  }
  if (event.data && event.data.type === 'GET_VERSION') {
    event.ports[0].postMessage({ version: CACHE_VERSION });
  }
});

// ─── 4. FETCH STRATEGY ─────────────────────────────────────────────────────────
self.addEventListener('fetch', (event) => {
  const url = new URL(event.request.url);

  // BYPASS: External resources (fonts, CDN scripts, APIs)
  if (url.origin !== self.location.origin) {
    event.respondWith(fetch(event.request).catch(() => new Response('', { status: 503 })));
    return;
  }

  // BYPASS: API calls and PHP processing
  if (url.pathname.includes('/api/') || url.pathname.includes('.php')) {
    event.respondWith(fetch(event.request));
    return;
  }

  // BYPASS: version.json is always fetched fresh (never cached)
  if (url.pathname.includes('version.json')) {
    event.respondWith(
      fetch(event.request, { cache: 'no-store' }).catch(() =>
        caches.match(event.request)
      )
    );
    return;
  }

  // BYPASS: manifest.json always fetched fresh so icons update
  if (url.pathname.includes('manifest.json')) {
    event.respondWith(
      fetch(event.request, { cache: 'no-store' }).then((res) => {
        // Update in cache too
        const clone = res.clone();
        caches.open(CACHE_NAME).then((c) => c.put(event.request, clone));
        return res;
      }).catch(() => caches.match(event.request))
    );
    return;
  }

  // STRATEGY A: Network-First for HTML navigation
  // Ensures users always get the newest shell on navigate
  if (
    event.request.mode === 'navigate' ||
    (event.request.method === 'GET' && event.request.headers.get('accept')?.includes('text/html'))
  ) {
    event.respondWith(
      fetch(event.request, { cache: 'no-store' }).then((networkRes) => {
        const clone = networkRes.clone();
        caches.open(CACHE_NAME).then((c) => c.put(event.request, clone));
        return networkRes;
      }).catch(() =>
        caches.match(event.request).then((r) => r || caches.match('/pwa-app/offline.html'))
      )
    );
    return;
  }

  // STRATEGY B: Cache-First for icons (with version-based invalidation)
  if (url.pathname.includes('/assets/icon-')) {
    event.respondWith(
      caches.match(event.request).then((cached) => {
        // Always revalidate icons in the background
        const networkFetch = fetch(event.request, { cache: 'no-store' }).then((res) => {
          caches.open(CACHE_NAME).then((c) => c.put(event.request, res.clone()));
          return res;
        });
        // Return cached immediately, update in background
        return cached || networkFetch;
      })
    );
    return;
  }

  // STRATEGY C: Stale-While-Revalidate for all other assets
  event.respondWith(
    caches.match(event.request).then((cached) => {
      const networkFetch = fetch(event.request).then((networkRes) => {
        const clone = networkRes.clone();
        caches.open(CACHE_NAME).then((c) => c.put(event.request, clone));
        return networkRes;
      }).catch(() => {});
      return cached || networkFetch;
    })
  );
});
