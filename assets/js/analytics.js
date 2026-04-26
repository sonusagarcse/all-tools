/**
 * BulkTools Analytics & Utility Script
 * Basic integration for page views and simple event tracking.
 */

(function() {
    // 1. Basic Page View Tracking (Simulation or Google Tag Manager)
    const pagePath = window.location.pathname;
    const pageTitle = document.title;
    
    console.log(`[Analytics] Tracked View: ${pagePath} - ${pageTitle}`);

    // 2. Simple Tool Interaction Tracking
    document.addEventListener('click', function(e) {
        const target = e.target.closest('a');
        if (target && target.href.includes('/tools/')) {
            const toolName = target.innerText.trim() || target.href.split('/').pop();
            console.log(`[Analytics] Tool Clicked: ${toolName}`);
            
            // If using GA4:
            /*
            if (typeof gtag === 'function') {
                gtag('event', 'tool_visit', {
                    'tool_name': toolName,
                    'page_location': window.location.href
                });
            }
            */
        }
    });

    // 3. Performance Metric Logging
    window.addEventListener('load', () => {
        const timing = window.performance.getEntriesByType('navigation')[0];
        if (timing) {
            const loadTime = (timing.loadEventEnd - timing.startTime).toFixed(2);
            console.log(`[Performance] Page Load: ${loadTime}ms`);
        }
    });

    // 4. Dark Mode State Persistence (Utility)
    const savedTheme = localStorage.getItem('theme');
    if (savedTheme === 'dark' || (!savedTheme && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
        document.documentElement.classList.add('dark');
    }

})();
