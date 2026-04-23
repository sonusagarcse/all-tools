<?php
require_once '../../../includes/header.php';
$tool = get_current_tool_info($_SERVER['REQUEST_URI']);
?>

<!-- Tool Header -->
<section class="pt-12 pb-8 bg-slate-50 dark:bg-gray-950 transition-colors">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <nav class="flex mb-8" aria-label="Breadcrumb">
            <ol class="inline-flex items-center space-x-1 md:space-x-3 text-xs font-medium text-gray-500">
                <li class="inline-flex items-center">
                    <a href="<?php echo SITE_URL; ?>" class="hover:text-white flex items-center">
                        <i data-lucide="home" class="w-3 h-3 mr-1"></i> Home
                    </a>
                </li>
                <li>
                    <div class="flex items-center">
                        <i data-lucide="chevron-right" class="w-3 h-3 mx-1"></i>
                        <a href="<?php echo SITE_URL; ?>#time" class="hover:text-white">Time Tools</a>
                    </div>
                </li>
                <li aria-current="page">
                    <div class="flex items-center">
                        <i data-lucide="chevron-right" class="w-3 h-3 mx-1"></i>
                        <span class="text-slate-500 dark:text-gray-300"><?php echo $tool['name']; ?></span>
                    </div>
                </li>
            </ol>
        </nav>

        <div class="flex flex-col md:flex-row md:items-end justify-between gap-6 mb-12">
            <div class="max-w-2xl">
                <h1 class="text-3xl md:text-5xl font-heading font-extrabold text-slate-900 dark:text-white mb-4"><?php echo $tool['name']; ?></h1>
                <p class="text-slate-600 dark:text-gray-400 text-lg leading-relaxed"><?php echo $tool['desc']; ?></p>
            </div>
            <div class="flex gap-3">
                <div class="px-4 py-2 rounded-xl bg-indigo-500/10 border border-indigo-500/20 flex items-center gap-2 text-indigo-600 dark:text-indigo-400 shadow-lg shadow-indigo-500/5 transition-all">
                    <i data-lucide="globe" class="w-5 h-5"></i>
                    <span class="text-sm font-medium">Real-time Sync</span>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Tool Area -->
<section class="pb-24 bg-slate-50 dark:bg-gray-950 transition-colors">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Primary Dashboard -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-12">
            <!-- Local Time Card -->
            <div class="col-span-1 lg:col-span-3 bg-gradient-to-br from-indigo-600 to-purple-600 rounded-[2.5rem] p-8 md:p-12 text-white shadow-2xl relative overflow-hidden flex flex-col md:flex-row items-center justify-between gap-8">
                <div class="absolute top-0 right-0 w-64 h-64 bg-white/10 rounded-full blur-3xl -mt-20 -mr-20"></div>
                <div class="relative z-10 text-center md:text-left">
                    <span class="inline-block px-3 py-1 bg-white/20 rounded-full text-[10px] font-black uppercase tracking-widest mb-4">Your Local Time</span>
                    <h2 id="local-city" class="text-2xl md:text-3xl font-black mb-2">Detecting Location...</h2>
                    <p id="local-date" class="text-indigo-100 font-medium opacity-80">Loading current date...</p>
                </div>
                <div class="relative z-10 text-center md:text-right">
                    <div id="local-time" class="font-mono text-5xl md:text-7xl font-black tracking-tighter tabular-nums mb-2">00:00:00</div>
                    <div id="local-timezone" class="text-sm font-bold text-indigo-100 uppercase tracking-widest opacity-60">GMT +0:00</div>
                </div>
            </div>
        </div>

        <!-- World Cities Grid -->
        <div id="world-clocks" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
            <!-- World clocks will be inserted here -->
        </div>

        <!-- SEO Content -->
        <div class="mt-20 prose prose-slate dark:prose-invert max-w-none">
            <div class="p-8 md:p-12 rounded-[3rem] bg-white dark:bg-gray-900 border border-slate-200 dark:border-gray-800 shadow-sm relative overflow-hidden">
                <div class="absolute top-0 right-0 w-64 h-64 bg-indigo-500/5 rounded-full blur-3xl -mr-20 -mt-20"></div>
                <div class="relative z-10">
                    <?php echo $tool['seo_text']; ?>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
    const cities = [
        { name: 'London', zone: 'Europe/London', country: 'United Kingdom' },
        { name: 'New York', zone: 'America/New_York', country: 'United States' },
        { name: 'Tokyo', zone: 'Asia/Tokyo', country: 'Japan' },
        { name: 'Dubai', zone: 'Asia/Dubai', country: 'UAE' },
        { name: 'Mumbai', zone: 'Asia/Kolkata', country: 'India' },
        { name: 'Sydney', zone: 'Australia/Sydney', country: 'Australia' },
        { name: 'Paris', zone: 'Europe/Paris', country: 'France' },
        { name: 'Singapore', zone: 'Asia/Singapore', country: 'Singapore' },
        { name: 'Moscow', zone: 'Europe/Moscow', country: 'Russia' },
        { name: 'Los Angeles', zone: 'America/Los_Angeles', country: 'United States' },
        { name: 'Berlin', zone: 'Europe/Berlin', country: 'Germany' },
        { name: 'Hong Kong', zone: 'Asia/Hong_Kong', country: 'China' }
    ];

    function updateClocks() {
        const now = new Date();
        
        // Update Local Clock
        const localTimeEl = document.getElementById('local-time');
        const localDateEl = document.getElementById('local-date');
        const localCityEl = document.getElementById('local-city');
        const localTimezoneEl = document.getElementById('local-timezone');

        localTimeEl.textContent = now.toLocaleTimeString('en-US', { hour12: false });
        localDateEl.textContent = now.toLocaleDateString('en-US', { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' });
        
        // Try to get timezone name
        try {
            const tz = Intl.DateTimeFormat().resolvedOptions().timeZone;
            localCityEl.textContent = tz.split('/').pop().replace('_', ' ');
            const offset = now.getTimezoneOffset();
            const absOffset = Math.abs(offset);
            const h = Math.floor(absOffset / 60);
            const m = absOffset % 60;
            localTimezoneEl.textContent = `${tz} (GMT ${offset <= 0 ? '+' : '-'}${h}:${m.toString().padStart(2, '0')})`;
        } catch(e) {}

        // Update World Clocks
        const container = document.getElementById('world-clocks');
        if (container.children.length === 0) {
            // Initial render
            container.innerHTML = cities.map((city, index) => `
                <div class="bg-white dark:bg-gray-900 rounded-[2rem] p-6 border border-slate-200 dark:border-gray-800 shadow-sm hover:shadow-xl transition-all group reveal" style="transition-delay: ${index * 0.05}s">
                    <div class="flex items-center justify-between mb-4">
                        <div class="w-10 h-10 bg-slate-100 dark:bg-gray-800 rounded-xl flex items-center justify-center text-slate-500 group-hover:bg-indigo-600 group-hover:text-white transition-all">
                            <i data-lucide="map-pin" class="w-5 h-5"></i>
                        </div>
                        <span class="text-[10px] font-black uppercase tracking-widest text-slate-400 dark:text-gray-500">${city.country}</span>
                    </div>
                    <h3 class="text-lg font-bold text-slate-900 dark:text-white mb-1">${city.name}</h3>
                    <div id="clock-${index}-time" class="font-mono text-2xl font-black text-indigo-600 dark:text-indigo-400 mb-2">00:00:00</div>
                    <div id="clock-${index}-date" class="text-xs font-medium text-slate-500 dark:text-gray-500 mb-4 truncate">Loading...</div>
                    <div id="clock-${index}-offset" class="inline-block px-2 py-1 bg-slate-100 dark:bg-gray-800 rounded-lg text-[9px] font-bold text-slate-400 dark:text-gray-500 uppercase tracking-tighter">GMT +00:00</div>
                </div>
            `).join('');
            lucide.createIcons();
        }

        cities.forEach((city, index) => {
            const timeEl = document.getElementById(`clock-${index}-time`);
            const dateEl = document.getElementById(`clock-${index}-date`);
            const offsetEl = document.getElementById(`clock-${index}-offset`);

            const cityTime = now.toLocaleTimeString('en-US', { timeZone: city.zone, hour12: false });
            const cityDate = now.toLocaleDateString('en-US', { timeZone: city.zone, month: 'short', day: 'numeric', year: 'numeric' });
            
            // Get GMT offset for the specific timezone
            const parts = new Intl.DateTimeFormat('en-US', {
                timeZone: city.zone,
                timeZoneName: 'shortOffset'
            }).formatToParts(now);
            const tzName = parts.find(p => p.type === 'timeZoneName').value;

            timeEl.textContent = cityTime;
            dateEl.textContent = cityDate;
            offsetEl.textContent = tzName;
        });
    }

    setInterval(updateClocks, 1000);
    updateClocks();
</script>

<?php require_once '../../../includes/footer.php'; ?>
