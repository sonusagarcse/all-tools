/**
 * BulkTools PWA Core App Logic
 * Handles SPA Routing and UI interactions
 */

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

    // Update connectivity state
    window.addEventListener('online', () => updateConnectivity(true));
    window.addEventListener('offline', () => updateConnectivity(false));

    function updateConnectivity(status) {
        window.appState.isOnline = status;
        document.body.classList.toggle('is-offline', !status);
        console.log(`PWA Status: ${status ? 'Online' : 'Offline'}`);
        // Optionally notify user
        if(status) fetchSession();
    }

    // Initial session fetch
    fetchSession();

    // PWA Install Prompt Listener
    window.addEventListener('beforeinstallprompt', (e) => {
        e.preventDefault();
        window.appState.deferredPrompt = e;
        // Optionally trigger local refresh of components that have install buttons
        console.log('PWA Install Prompt available');
    });

    // Provide a fail-safe to ALWAYS hide splash screen after 3 seconds max
    const forceHideSplash = setTimeout(() => {
        const splash = document.getElementById('splash-screen');
        if(splash) {
            splash.style.opacity = '0';
            setTimeout(() => splash.remove(), 500);
        }
    }, 3000);

    // Initial Route
    navigate('home').then(() => {
        clearTimeout(forceHideSplash);
        setTimeout(() => {
            const splash = document.getElementById('splash-screen');
            if(splash) {
                splash.style.opacity = '0';
                setTimeout(() => splash.remove(), 500);
            }
        }, 500);
    });
});

// Theme Toggle helper
window.toggleGlobalTheme = (theme) => {
    if (theme === 'dark') {
        document.documentElement.classList.add('dark');
    } else {
        document.documentElement.classList.remove('dark');
    }
    localStorage.setItem('bt_theme', theme);
    window.appState.theme = theme;
};

// CSRF & Session fetch
async function fetchSession() {
    if (!navigator.onLine) return;
    try {
        const res = await fetch('/pwa-app/api/v1/session.php');
        const data = await res.json();
        if (data.success) {
            window.appState.csrfToken = data.csrf_token;
            window.appState.sessionHash = data.session_hash;
            console.log('Session Bridge Active');
        }
    } catch (e) {
        console.warn('Session Bridge failed - server side features unavailable.');
    }
}

// History API support for back button
window.addEventListener('popstate', (event) => {
    if (event.state && event.state.page) {
        loadComponent(event.state.page, false);
    } else {
        loadComponent('home', false);
    }
});

async function navigate(page) {
    const activeNav = document.querySelector(`.nav-btn[data-target="${page}"]`);
    
    // Manage Nav States
    document.querySelectorAll('.nav-btn').forEach(btn => {
        btn.classList.remove('text-indigo-600');
        btn.classList.add('text-slate-400');
        // Reset translate
        const icon = btn.querySelector('i');
        if(icon) icon.style.transform = 'translateY(0)';
    });
    
    if (activeNav) {
        activeNav.classList.remove('text-slate-400');
        activeNav.classList.add('text-indigo-600');
        const icon = activeNav.querySelector('i');
        if(icon) icon.style.transform = 'translateY(-4px)';
    }

    await loadComponent(page, true);
}

async function loadComponent(page, pushState = true) {
    const contentDiv = document.getElementById('app-content');
    
    // Skeleton Loader (App feel)
    contentDiv.style.opacity = '0.5';
    contentDiv.innerHTML = `
        <div class="animate-pulse space-y-4 pt-4">
            <div class="h-10 bg-slate-200 rounded-xl w-1/3 mb-6 relative overflow-hidden"><div class="absolute inset-0 bg-gradient-to-r from-transparent via-white/40 to-transparent w-full h-full skeleton-shimmer"></div></div>
            <div class="grid grid-cols-2 gap-4">
                <div class="h-24 bg-slate-200 rounded-2xl relative overflow-hidden"><div class="absolute inset-0 bg-gradient-to-r from-transparent via-white/40 to-transparent w-full h-full skeleton-shimmer"></div></div>
                <div class="h-24 bg-slate-200 rounded-2xl relative overflow-hidden"><div class="absolute inset-0 bg-gradient-to-r from-transparent via-white/40 to-transparent w-full h-full skeleton-shimmer"></div></div>
            </div>
            <div class="h-32 bg-slate-200 rounded-2xl w-full mt-4 relative overflow-hidden"><div class="absolute inset-0 bg-gradient-to-r from-transparent via-white/40 to-transparent w-full h-full skeleton-shimmer"></div></div>
        </div>
    `;

    try {
        // Build timestamp to bust cache in dev, but SW will intercept in prod
        const res = await fetch(`app/components/${page}.html?v=1.0`);
        if (!res.ok) throw new Error('Network response was not ok');
        const html = await res.text();
        
        // Slight delay to simulate network latency if it loaded too fast from cache
        // to show the sleek skeleton animation for at least 150ms
        setTimeout(() => {
            contentDiv.innerHTML = html;
            contentDiv.style.opacity = '1';
            if (typeof lucide !== 'undefined') lucide.createIcons();
            
            // Execute any scripts in the component
            const scripts = contentDiv.querySelectorAll('script');
            scripts.forEach(script => {
                const newScript = document.createElement('script');
                newScript.text = script.text;
                document.body.appendChild(newScript).parentNode.removeChild(newScript);
            });

            if (pushState) {
                window.history.pushState({page}, page, `#${page}`);
            }
        }, 150);

    } catch (e) {
        console.error(e);
        contentDiv.style.opacity = '1';
        contentDiv.innerHTML = `
            <div class="p-8 mt-10 text-center rounded-3xl bg-red-50 border border-red-100">
                <i data-lucide="wifi-off" class="w-12 h-12 text-red-500 mx-auto mb-4"></i>
                <h3 class="text-lg font-bold text-red-900 mb-2">Offline</h3>
                <p class="text-sm text-red-600">Please check your internet connection and try again.</p>
                <button onclick="navigate('${page}')" class="mt-6 px-4 py-2 bg-red-100 text-red-700 font-bold rounded-xl text-sm hover:bg-red-200 active:scale-95 transition-transform">Retry</button>
            </div>
        `;
        if (typeof lucide !== 'undefined') lucide.createIcons();
    }
}
