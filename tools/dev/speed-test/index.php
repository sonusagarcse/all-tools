<?php
require_once dirname(dirname(dirname(__DIR__))) . '/includes/header.php';
$tool_id = 'speed-test';
$cat_id = 'dev';
$tool = $TOOL_CATEGORIES[$cat_id]['tools'][$tool_id];
?>

<div class="pt-24 pb-12 bg-slate-50 dark:bg-gray-950 min-h-screen">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Breadcrumb & Header -->
        <div class="mb-10 text-center animate-fade-in">
            <div class="flex items-center justify-center gap-2 text-sm font-medium text-slate-500 dark:text-gray-400 mb-4">
                <a href="<?php echo SITE_URL; ?>" class="hover:text-indigo-600 dark:hover:text-indigo-400 transition-colors">Home</a>
                <i data-lucide="chevron-right" class="w-4 h-4"></i>
                <a href="<?php echo SITE_URL; ?>#<?php echo $cat_id; ?>" class="hover:text-indigo-600 dark:hover:text-indigo-400 transition-colors"><?php echo $TOOL_CATEGORIES[$cat_id]['name']; ?></a>
                <i data-lucide="chevron-right" class="w-4 h-4"></i>
                <span class="text-slate-900 dark:text-white"><?php echo $tool['name']; ?></span>
            </div>
            <h1 class="text-4xl md:text-5xl font-heading font-extrabold text-slate-900 dark:text-white mb-4"><?php echo $tool['name']; ?></h1>
            <p class="text-lg text-slate-600 dark:text-gray-400 max-w-2xl mx-auto"><?php echo $tool['desc']; ?></p>
        </div>

        <!-- Tool Container -->
        <div class="glass-card rounded-[40px] p-8 md:p-12 animate-fade-in shadow-xl dark:shadow-none relative overflow-hidden" style="animation-delay: 0.1s">
            
            <!-- Gauge Section -->
            <div class="relative flex flex-col items-center justify-center mb-12">
                <div class="relative w-64 h-64 md:w-80 md:h-80">
                    <!-- Progress Semicircle -->
                    <svg viewBox="0 0 200 120" class="w-full h-full transform translate-y-4">
                        <!-- Track -->
                        <path d="M20,100 A80,80 0 1,1 180,100" fill="none" class="stroke-slate-200 dark:stroke-gray-800" stroke-width="12" stroke-linecap="round"/>
                        <!-- Progress -->
                        <path id="gauge-progress" d="M20,100 A80,80 0 1,1 180,100" fill="none" class="stroke-indigo-600 transition-all duration-300" stroke-width="12" stroke-linecap="round" stroke-dasharray="251.2" stroke-dashoffset="251.2"/>
                    </svg>
                    
                    <!-- Text Overlay -->
                    <div class="absolute inset-0 flex flex-col items-center justify-center pt-8">
                        <span id="current-speed" class="text-6xl md:text-7xl font-black text-slate-900 dark:text-white tracking-tighter transition-all">0</span>
                        <span class="text-sm font-bold uppercase tracking-widest text-slate-400 dark:text-gray-500 mt-[-5px]">Mbps</span>
                        <div id="test-status" class="mt-4 px-4 py-1.5 rounded-full bg-slate-100 dark:bg-gray-800 text-slate-500 dark:text-gray-400 text-[10px] font-black uppercase tracking-widest transition-opacity opacity-0">
                            Testing Download...
                        </div>
                    </div>
                </div>

                <!-- Start Button -->
                <button id="start-btn" class="mt-8 px-10 py-5 bg-indigo-600 hover:bg-indigo-500 text-white font-black rounded-2xl shadow-xl shadow-indigo-600/30 transition-all active:scale-95 flex items-center gap-3 text-lg group">
                    <i data-lucide="play" class="w-6 h-6 fill-current"></i>
                    Start Test
                </button>
            </div>

            <!-- Results Grid -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 relative z-10">
                <!-- Ping -->
                <div class="bg-white dark:bg-gray-900/50 p-6 rounded-3xl border border-slate-100 dark:border-gray-800 shadow-sm flex flex-col items-center">
                    <div class="w-10 h-10 rounded-xl bg-orange-50 dark:bg-orange-900/30 text-orange-600 dark:text-orange-400 flex items-center justify-center mb-4">
                        <i data-lucide="activity" class="w-5 h-5"></i>
                    </div>
                    <span class="text-[10px] font-black uppercase tracking-widest text-slate-400 dark:text-gray-500 mb-1">Ping</span>
                    <div class="flex items-baseline gap-1">
                        <span id="res-ping" class="text-2xl font-black text-slate-800 dark:text-white">--</span>
                        <span class="text-xs font-bold text-slate-400 dark:text-gray-600">ms</span>
                    </div>
                </div>

                <!-- Download -->
                <div class="bg-white dark:bg-gray-900/50 p-6 rounded-3xl border border-slate-100 dark:border-gray-800 shadow-sm flex flex-col items-center relative overflow-hidden group">
                    <div id="download-active-bg" class="absolute inset-0 bg-indigo-600/5 opacity-0 transition-opacity"></div>
                    <div class="w-10 h-10 rounded-xl bg-indigo-50 dark:bg-indigo-900/30 text-indigo-600 dark:text-indigo-400 flex items-center justify-center mb-4 relative z-10">
                        <i data-lucide="download" class="w-5 h-5"></i>
                    </div>
                    <span class="text-[10px] font-black uppercase tracking-widest text-slate-400 dark:text-gray-500 mb-1 relative z-10">Download</span>
                    <div class="flex items-baseline gap-1 relative z-10">
                        <span id="res-download" class="text-2xl font-black text-slate-800 dark:text-white">--</span>
                        <span class="text-xs font-bold text-slate-400 dark:text-gray-600">Mbps</span>
                    </div>
                </div>

                <!-- Upload -->
                <div class="bg-white dark:bg-gray-900/50 p-6 rounded-3xl border border-slate-100 dark:border-gray-800 shadow-sm flex flex-col items-center relative overflow-hidden group">
                    <div id="upload-active-bg" class="absolute inset-0 bg-emerald-600/5 opacity-0 transition-opacity"></div>
                    <div class="w-10 h-10 rounded-xl bg-emerald-50 dark:bg-emerald-900/30 text-emerald-600 dark:text-emerald-400 flex items-center justify-center mb-4 relative z-10">
                        <i data-lucide="upload" class="w-5 h-5"></i>
                    </div>
                    <span class="text-[10px] font-black uppercase tracking-widest text-slate-400 dark:text-gray-500 mb-1 relative z-10">Upload</span>
                    <div class="flex items-baseline gap-1 relative z-10">
                        <span id="res-upload" class="text-2xl font-black text-slate-800 dark:text-white">--</span>
                        <span class="text-xs font-bold text-slate-400 dark:text-gray-600">Mbps</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- SEO Content -->
        <div class="mt-16 prose prose-slate dark:prose-invert max-w-none animate-fade-in" style="animation-delay: 0.2s">
            <?php echo $tool['seo_text']; ?>
        </div>
    </div>
</div>

<style>
#gauge-progress {
    transition: stroke-dashoffset 0.5s cubic-bezier(0.4, 0, 0.2, 1);
}
.testing #gauge-progress {
    filter: drop-shadow(0 0 8px rgba(79, 70, 229, 0.4));
}
</style>

<script>
document.addEventListener('DOMContentLoaded', () => {
    // UI Elements
    const startBtn = document.getElementById('start-btn');
    const statusEl = document.getElementById('test-status');
    const speedEl = document.getElementById('current-speed');
    const gaugeProgress = document.getElementById('gauge-progress');
    const resPing = document.getElementById('res-ping');
    const resDownload = document.getElementById('res-download');
    const resUpload = document.getElementById('res-upload');
    const dlBg = document.getElementById('download-active-bg');
    const ulBg = document.getElementById('upload-active-bg');

    // Constants
    const AJAX_URL = '<?php echo SITE_URL; ?>/ajax/';
    const GAUGE_TOTAL = 251.2;
    const THREADS = 4; // Multi-thread level

    // State
    let isTesting = false;
    let gaugeMax = 100;
    let currentMbps = 0;
    let activePhase = null; // 'ping', 'download', 'upload'

    // Multi-thread state
    let globalBytes = 0;
    let phaseStartTime = 0;
    let statsInterval = null;

    async function runTest() {
        if (isTesting) return;
        isTesting = true;
        
        // Reset UI
        startBtn.disabled = true;
        startBtn.innerHTML = '<i data-lucide="loader-2" class="w-6 h-6 animate-spin"></i> Testing...';
        if(window.lucide) lucide.createIcons();
        statusEl.classList.remove('opacity-0');
        resPing.innerText = '--';
        resDownload.innerText = '--';
        resUpload.innerText = '--';
        gaugeMax = 100;
        updateUI(0);

        try {
            // 1. PING
            activePhase = 'ping';
            statusEl.innerText = 'Measuring Latency...';
            const pingRes = await measurePing();
            resPing.innerText = pingRes.toFixed(0);

            // 2. DOWNLOAD
            activePhase = 'download';
            statusEl.innerText = 'Testing Download Speed...';
            dlBg.classList.add('opacity-100');
            const dlRes = await runParallelTest('download');
            updateUI(dlRes); // Ensure center matches final
            resDownload.innerText = dlRes.toFixed(1);
            dlBg.classList.remove('opacity-100');

            // 3. UPLOAD
            activePhase = 'upload';
            statusEl.innerText = 'Testing Upload Speed...';
            ulBg.classList.add('opacity-100');
            const ulRes = await runParallelTest('upload');
            updateUI(ulRes); // Ensure center matches final
            resUpload.innerText = ulRes.toFixed(1);
            ulBg.classList.remove('opacity-100');

            statusEl.innerText = 'Test Complete';
        } catch (err) {
            console.error('[SpeedTest Engine Error]', err);
            statusEl.innerText = 'Error: ' + (err.message || 'Check Server Limits');
        } finally {
            isTesting = false;
            activePhase = null;
            clearInterval(statsInterval);
            startBtn.disabled = false;
            startBtn.innerHTML = '<i data-lucide="play" class="w-6 h-6 fill-current"></i> Run Again';
            if(window.lucide) lucide.createIcons();
            // Final sync: ensure the center matches the last phase's actual result
        }
    }

    async function measurePing() {
        const samples = 6;
        let ticks = [];
        for (let i = 0; i < samples; i++) {
            const start = performance.now();
            await fetch(AJAX_URL + 'search.php?t=' + Math.random());
            ticks.push(performance.now() - start);
        }
        // Outlier removal: remove highest and lowest
        ticks.sort((a, b) => a - b);
        const filtered = ticks.slice(1, -1);
        return filtered.reduce((a, b) => a + b) / filtered.length;
    }

    async function runParallelTest(type) {
        globalBytes = 0;
        phaseStartTime = performance.now();
        const controllers = [];
        const TEST_DURATION = 10000; // 10 Seconds max

        let history = [];
        // Start sliding window UI ticker
        statsInterval = setInterval(() => {
            const now = performance.now();
            history.push({ time: now, bytes: globalBytes });
            // keep 1 second of history window
            while (history.length > 0 && now - history[0].time > 1000) {
                history.shift();
            }

            if (history.length > 1) {
                const first = history[0];
                const last = history[history.length - 1];
                const deltaSecs = (last.time - first.time) / 1000;
                if (deltaSecs > 0) {
                    const currentMbps = (last.bytes - first.bytes) * 8 / deltaSecs / 1000000;
                    // Apply a tiny bit of smoothing to prevent rapid UI flashing
                    updateUI(currentMbps);
                }
            }
        }, 100);

        const promises = [];
        for (let i = 0; i < THREADS; i++) {
            if (type === 'download') {
                promises.push(downloadThread(controllers, TEST_DURATION));
            } else {
                promises.push(uploadThread(TEST_DURATION));
            }
        }

        await Promise.all(promises);
        clearInterval(statsInterval);
        
        const finalElapsed = (performance.now() - phaseStartTime) / 1000;
        return (globalBytes * 8) / finalElapsed / 1000000;
    }

    async function downloadThread(controllers, duration) {
        const ctrl = new AbortController();
        controllers.push(ctrl);
        try {
            while (performance.now() - phaseStartTime < duration) {
                const response = await fetch(AJAX_URL + 'speedtest_download.php?t=' + Math.random(), { signal: ctrl.signal });
                const reader = response.body.getReader();
                while (true) {
                    const { done, value } = await reader.read();
                    if (done) break; // Finished this chunk, go re-fetch
                    globalBytes += value.length;

                    if (performance.now() - phaseStartTime >= duration) {
                        ctrl.abort(); // Time is up!
                        return;
                    }
                }
            }
        } catch (e) {
            if (e.name !== 'AbortError') console.error(e);
        }
    }

    async function uploadThread(duration) {
        const size = 15 * 1024 * 1024; // 15MB chunks
        const data = new Uint8Array(size);
        const CHUNK = 65536;
        for(let i=0; i<size; i+=CHUNK) {
            crypto.getRandomValues(data.subarray(i, Math.min(i+CHUNK, size)));
        }

        while (performance.now() - phaseStartTime < duration) {
            await new Promise((resolve) => {
                const xhr = new XMLHttpRequest();
                xhr.upload.onprogress = (e) => {
                    if (!xhr._lastLoaded) xhr._lastLoaded = 0;
                    globalBytes += (e.loaded - xhr._lastLoaded);
                    xhr._lastLoaded = e.loaded;

                    if (performance.now() - phaseStartTime >= duration) {
                        xhr.abort(); // Time is up!
                        resolve();
                    }
                };
                xhr.onload = () => resolve();
                xhr.onerror = () => resolve(); // Ignore networking drops during abort
                xhr.open('POST', AJAX_URL + 'speedtest_upload.php?t=' + Math.random());
                xhr.send(data);
            });
        }
    }

    function updateUI(mbps) {
        // Auto-scale gauge
        if (mbps > gaugeMax * 0.9) {
            if (gaugeMax < 1000) gaugeMax = 1000;
            else if (gaugeMax < 10000) gaugeMax = 10000;
        }

        // Update Text
        speedEl.innerText = mbps > 100 ? Math.round(mbps) : mbps.toFixed(1);

        // Update Gauge
        const percent = Math.min(mbps / gaugeMax, 1);
        const offset = GAUGE_TOTAL - (percent * GAUGE_TOTAL);
        gaugeProgress.style.strokeDashoffset = offset;
    }

    startBtn.addEventListener('click', runTest);
});
</script>

<?php require_once dirname(dirname(dirname(__DIR__))) . '/includes/footer.php'; ?>
