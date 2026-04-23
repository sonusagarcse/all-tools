/**
 * BulkTools PWA — Core App Logic v1.2.0
 * Handles SPA routing, error states, connectivity, and install prompts.
 */

// ── Known valid routes ──────────────────────────────────────────────────────
const VALID_ROUTES = new Set([
    'home', 'all-tools', 'dashboard', 'settings', 'profile',
    'compressor', 'drawing-board', 'text-editor', 'qr-generator',
    'hindi-typing', 'timer', 'speed-test', 'image-share',
    'gst-calculator', 'sip-calculator', 'glassmorphism', 'privacy-policy'
]);

document.addEventListener('DOMContentLoaded', () => {
    // Global State
    window.appState = {
        isLoggedIn: localStorage.getItem('bt_logged_in') === 'true',
        user: JSON.parse(localStorage.getItem('bt_user') || '{}'),
        theme: localStorage.getItem('bt_theme') || 'light',
        isOnline: navigator.onLine,
        csrfToken: null,
        sessionHash: null,
        deferredPrompt: null
    };

    // Connectivity listeners
    window.addEventListener('online',  () => updateConnectivity(true));
    window.addEventListener('offline', () => updateConnectivity(false));

    function updateConnectivity(status) {
        window.appState.isOnline = status;
        document.body.classList.toggle('is-offline', !status);
        if (status) fetchSession();
    }

    // Initial session
    fetchSession();

    // ── PWA Install Prompt ────────────────────────────────────────────────────
    window.addEventListener('beforeinstallprompt', (e) => {
        e.preventDefault();
        window.appState.deferredPrompt = e;
        console.log('[PWA] Install prompt captured.');
        window.dispatchEvent(new CustomEvent('pwaInstallReady', { detail: e }));
    });

    window.addEventListener('appinstalled', () => {
        console.log('[PWA] App installed!');
        window.appState.deferredPrompt = null;
        const banner = document.getElementById('install-banner');
        if (banner) banner.classList.add('hidden');
    });

    // ── Splash Screen ─────────────────────────────────────────────────────────
    const forceHideSplash = setTimeout(() => hideSplash(), 3000);

    // ── Initial Route ─────────────────────────────────────────────────────────
    // Read hash from URL (e.g. #home, #settings) on first load
    const initialPage = (location.hash.replace('#', '') || 'home');
    const startPage = VALID_ROUTES.has(initialPage) ? initialPage : 'home';

    navigate(startPage, false).then(() => {
        clearTimeout(forceHideSplash);
        setTimeout(hideSplash, 400);
    });
});

function hideSplash() {
    const splash = document.getElementById('splash-screen');
    if (splash && !splash._hidden) {
        splash._hidden = true;
        splash.style.opacity = '0';
        setTimeout(() => splash.remove(), 500);
    }
}

// ── Theme Toggle ──────────────────────────────────────────────────────────────
window.toggleGlobalTheme = (theme) => {
    if (theme === 'dark') {
        document.documentElement.classList.add('dark');
    } else {
        document.documentElement.classList.remove('dark');
    }
    localStorage.setItem('bt_theme', theme);
    window.appState.theme = theme;
};

// ── CSRF & Session ────────────────────────────────────────────────────────────
async function fetchSession() {
    if (!navigator.onLine) return;
    try {
        const res = await fetch('/pwa-app/api/v1/session.php');
        const data = await res.json();
        if (data.success) {
            window.appState.csrfToken = data.csrf_token;
            window.appState.sessionHash = data.session_hash;
        }
    } catch (e) {
        // Session bridge optional — no alert
    }
}

// ── Back button ───────────────────────────────────────────────────────────────
window.addEventListener('popstate', (event) => {
    const page = event.state && event.state.page;
    loadComponent(VALID_ROUTES.has(page) ? page : 'home', false);
});

// ── Navigate ──────────────────────────────────────────────────────────────────
async function navigate(page, push = true) {
    // If route is completely unknown → show 404 inside app
    if (!VALID_ROUTES.has(page)) {
        show404(page);
        return;
    }

    // Update bottom nav active state
    document.querySelectorAll('.nav-btn').forEach(btn => {
        btn.classList.remove('text-indigo-600', 'dark:text-indigo-400');
        btn.classList.add('text-slate-400', 'dark:text-slate-500');
        const icon = btn.querySelector('i');
        if (icon) icon.style.transform = 'translateY(0)';
    });

    const activeNav = document.querySelector(`.nav-btn[data-target="${page}"]`);
    if (activeNav) {
        activeNav.classList.remove('text-slate-400', 'dark:text-slate-500');
        activeNav.classList.add('text-indigo-600', 'dark:text-indigo-400');
        const icon = activeNav.querySelector('i');
        if (icon) icon.style.transform = 'translateY(-4px)';
    }

    await loadComponent(page, push);
}

// ── Load Component ────────────────────────────────────────────────────────────
async function loadComponent(page, pushState = true) {
    const contentDiv = document.getElementById('app-content');

    // Show skeleton loader
    contentDiv.style.opacity = '0.5';
    contentDiv.innerHTML = `
        <div class="animate-pulse space-y-4 pt-4">
            <div class="h-10 bg-slate-200 dark:bg-slate-800 rounded-xl w-1/3 mb-6 relative overflow-hidden"><div class="absolute inset-0 bg-gradient-to-r from-transparent via-white/40 to-transparent w-full h-full skeleton-shimmer"></div></div>
            <div class="grid grid-cols-2 gap-4">
                <div class="h-24 bg-slate-200 dark:bg-slate-800 rounded-2xl relative overflow-hidden"><div class="absolute inset-0 bg-gradient-to-r from-transparent via-white/40 to-transparent w-full h-full skeleton-shimmer"></div></div>
                <div class="h-24 bg-slate-200 dark:bg-slate-800 rounded-2xl relative overflow-hidden"><div class="absolute inset-0 bg-gradient-to-r from-transparent via-white/40 to-transparent w-full h-full skeleton-shimmer"></div></div>
            </div>
            <div class="h-32 bg-slate-200 dark:bg-slate-800 rounded-2xl w-full mt-4 relative overflow-hidden"><div class="absolute inset-0 bg-gradient-to-r from-transparent via-white/40 to-transparent w-full h-full skeleton-shimmer"></div></div>
        </div>
    `;

    // Use BT_VERSION set by index.html bootApp(), fallback to timestamp bust
    const v = window.BT_VERSION || localStorage.getItem('bt_app_version') || Date.now();

    try {
        const res = await fetch(`app/components/${page}.html?v=${v}`, { cache: 'no-cache' });

        // Component file not found → show 404 inside app
        if (res.status === 404) {
            show404(page);
            return;
        }

        if (!res.ok) throw new Error(`HTTP ${res.status}`);

        const html = await res.text();

        setTimeout(() => {
            contentDiv.innerHTML = html;
            contentDiv.style.opacity = '1';
            if (typeof lucide !== 'undefined') lucide.createIcons();

            // Re-execute inline scripts inside the loaded component
            contentDiv.querySelectorAll('script').forEach(script => {
                const s = document.createElement('script');
                s.text = script.textContent;
                document.body.appendChild(s).remove();
            });

            if (pushState) {
                window.history.pushState({ page }, page, `#${page}`);
            }
        }, 150);

    } catch (e) {
        console.error('[Router]', e);
        contentDiv.style.opacity = '1';

        // Detect offline vs server error
        if (!navigator.onLine) {
            showOfflineError(contentDiv, page);
        } else {
            showServerError(contentDiv, page);
        }

        if (typeof lucide !== 'undefined') lucide.createIcons();
    }
}

// ── 404 Page (inside SPA) ─────────────────────────────────────────────────────
function show404(page) {
    const contentDiv = document.getElementById('app-content');
    contentDiv.style.opacity = '1';
    contentDiv.innerHTML = `
        <div class="flex flex-col items-center justify-center min-h-[70vh] text-center px-4">
            <!-- Animated 404 -->
            <div class="relative mb-8">
                <div class="text-[120px] font-black leading-none select-none" style="
                    background: linear-gradient(135deg, #6366f1 0%, #8b5cf6 50%, #06b6d4 100%);
                    -webkit-background-clip: text;
                    -webkit-text-fill-color: transparent;
                    background-clip: text;
                    filter: drop-shadow(0 8px 24px rgba(99,102,241,0.3));
                ">404</div>
                <!-- Floating icons -->
                <div class="absolute -top-4 -left-6 w-10 h-10 bg-indigo-100 dark:bg-indigo-900/40 rounded-2xl flex items-center justify-center animate-bounce" style="animation-delay:0s">
                    <i data-lucide="search-x" class="w-5 h-5 text-indigo-500"></i>
                </div>
                <div class="absolute -top-2 -right-4 w-8 h-8 bg-violet-100 dark:bg-violet-900/40 rounded-xl flex items-center justify-center animate-bounce" style="animation-delay:0.2s">
                    <i data-lucide="map-pin-off" class="w-4 h-4 text-violet-500"></i>
                </div>
                <div class="absolute -bottom-2 right-0 w-9 h-9 bg-cyan-100 dark:bg-cyan-900/40 rounded-xl flex items-center justify-center animate-bounce" style="animation-delay:0.4s">
                    <i data-lucide="compass" class="w-4 h-4 text-cyan-500"></i>
                </div>
            </div>

            <h2 class="text-2xl font-black text-slate-900 dark:text-white mb-2">Page Not Found</h2>
            <p class="text-slate-500 dark:text-slate-400 text-sm mb-1 max-w-xs">
                The page <code class="bg-slate-100 dark:bg-slate-800 text-indigo-600 dark:text-indigo-400 px-2 py-0.5 rounded-lg font-mono text-xs">${page}</code> doesn't exist.
            </p>
            <p class="text-slate-400 dark:text-slate-500 text-xs mb-8">Looks like you followed a broken link or mistyped the address.</p>

            <div class="flex flex-col gap-3 w-full max-w-xs">
                <button onclick="navigate('home')" class="w-full py-3 bg-indigo-600 hover:bg-indigo-500 text-white font-bold rounded-2xl text-sm active:scale-95 transition-all shadow-lg shadow-indigo-500/25 flex items-center justify-center gap-2">
                    <i data-lucide="home" class="w-4 h-4"></i>
                    Back to Home
                </button>
                <button onclick="navigate('all-tools')" class="w-full py-3 bg-slate-100 dark:bg-slate-800 hover:bg-slate-200 dark:hover:bg-slate-700 text-slate-700 dark:text-slate-300 font-bold rounded-2xl text-sm active:scale-95 transition-all flex items-center justify-center gap-2">
                    <i data-lucide="layout-grid" class="w-4 h-4"></i>
                    Browse All Tools
                </button>
            </div>
        </div>
    `;
    if (typeof lucide !== 'undefined') lucide.createIcons();
}

// ── Offline Error (inside SPA) ────────────────────────────────────────────────
function showOfflineError(contentDiv, page) {
    contentDiv.innerHTML = `
        <div class="flex flex-col items-center justify-center min-h-[70vh] text-center px-4">
            <div class="relative mb-8">
                <div class="w-28 h-28 bg-gradient-to-br from-slate-100 to-slate-200 dark:from-slate-800 dark:to-slate-900 rounded-3xl flex items-center justify-center shadow-xl mb-0 border border-slate-200 dark:border-slate-700">
                    <i data-lucide="wifi-off" class="w-14 h-14 text-slate-400 dark:text-slate-500"></i>
                </div>
                <div class="absolute -bottom-2 -right-2 w-8 h-8 bg-amber-100 dark:bg-amber-900/30 rounded-full flex items-center justify-center border-2 border-white dark:border-slate-950">
                    <i data-lucide="alert-triangle" class="w-4 h-4 text-amber-500"></i>
                </div>
            </div>

            <h2 class="text-2xl font-black text-slate-900 dark:text-white mb-2">You're Offline</h2>
            <p class="text-slate-500 dark:text-slate-400 text-sm max-w-xs mb-2">
                No internet connection detected. Check your Wi-Fi or mobile data.
            </p>
            <p class="text-slate-400 dark:text-slate-500 text-xs mb-8">
                Cached tools (Compressor, Timer, QR Generator, Text Editor) still work offline.
            </p>

            <div class="flex flex-col gap-3 w-full max-w-xs">
                <button onclick="navigate('${page}')" class="w-full py-3 bg-indigo-600 hover:bg-indigo-500 text-white font-bold rounded-2xl text-sm active:scale-95 transition-all shadow-lg shadow-indigo-500/25 flex items-center justify-center gap-2">
                    <i data-lucide="refresh-cw" class="w-4 h-4"></i>
                    Retry
                </button>
                <button onclick="navigate('home')" class="w-full py-3 bg-slate-100 dark:bg-slate-800 text-slate-700 dark:text-slate-300 font-bold rounded-2xl text-sm active:scale-95 transition-all flex items-center justify-center gap-2">
                    <i data-lucide="home" class="w-4 h-4"></i>
                    Go Home
                </button>
            </div>

            <!-- Offline available tools -->
            <div class="mt-8 w-full max-w-xs bg-slate-50 dark:bg-slate-900 rounded-2xl p-4 border border-slate-200 dark:border-slate-800">
                <p class="text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-widest mb-3">Available Offline</p>
                <div class="grid grid-cols-2 gap-2">
                    <button onclick="navigate('compressor')" class="py-2 bg-emerald-50 dark:bg-emerald-900/20 text-emerald-700 dark:text-emerald-400 text-xs font-bold rounded-xl active:scale-95 transition-transform">Compressor</button>
                    <button onclick="navigate('timer')" class="py-2 bg-rose-50 dark:bg-rose-900/20 text-rose-700 dark:text-rose-400 text-xs font-bold rounded-xl active:scale-95 transition-transform">Timer</button>
                    <button onclick="navigate('qr-generator')" class="py-2 bg-indigo-50 dark:bg-indigo-900/20 text-indigo-700 dark:text-indigo-400 text-xs font-bold rounded-xl active:scale-95 transition-transform">QR Generator</button>
                    <button onclick="navigate('text-editor')" class="py-2 bg-blue-50 dark:bg-blue-900/20 text-blue-700 dark:text-blue-400 text-xs font-bold rounded-xl active:scale-95 transition-transform">Text Editor</button>
                </div>
            </div>
        </div>
    `;
}

// ── Server Error (inside SPA) ─────────────────────────────────────────────────
function showServerError(contentDiv, page) {
    contentDiv.innerHTML = `
        <div class="flex flex-col items-center justify-center min-h-[70vh] text-center px-4">
            <div class="w-24 h-24 bg-red-50 dark:bg-red-900/20 rounded-3xl flex items-center justify-center mb-6 border border-red-100 dark:border-red-800">
                <i data-lucide="server-off" class="w-12 h-12 text-red-400"></i>
            </div>
            <h2 class="text-2xl font-black text-slate-900 dark:text-white mb-2">Something Went Wrong</h2>
            <p class="text-slate-500 dark:text-slate-400 text-sm max-w-xs mb-8">
                Couldn't load this page. The server may be temporarily unavailable.
            </p>
            <div class="flex flex-col gap-3 w-full max-w-xs">
                <button onclick="navigate('${page}')" class="w-full py-3 bg-indigo-600 text-white font-bold rounded-2xl text-sm active:scale-95 transition-all shadow-lg shadow-indigo-500/25 flex items-center justify-center gap-2">
                    <i data-lucide="refresh-cw" class="w-4 h-4"></i>
                    Try Again
                </button>
                <button onclick="navigate('home')" class="w-full py-3 bg-slate-100 dark:bg-slate-800 text-slate-700 dark:text-slate-300 font-bold rounded-2xl text-sm active:scale-95 transition-all flex items-center justify-center gap-2">
                    <i data-lucide="home" class="w-4 h-4"></i>
                    Go Home
                </button>
            </div>
        </div>
    `;
}
