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
                <div class="px-4 py-2 rounded-xl bg-orange-500/10 border border-orange-500/20 flex items-center gap-2 text-orange-600 dark:text-orange-400 shadow-lg shadow-orange-500/5 transition-all">
                    <i data-lucide="terminal" class="w-5 h-5"></i>
                    <span class="text-sm font-medium">Dev Essentials</span>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Tool Area -->
<section class="pb-24 bg-slate-50 dark:bg-gray-950 transition-colors">
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            <!-- Left Side: Current Timestamp & Conversion -->
            <div class="space-y-6">
                <!-- Current Unix Card -->
                <div class="bg-gradient-to-br from-gray-900 to-black dark:from-gray-800 dark:to-gray-950 rounded-[2.5rem] p-8 text-white shadow-2xl relative overflow-hidden">
                    <div class="absolute top-0 right-0 w-32 h-32 bg-orange-500/10 rounded-full blur-3xl"></div>
                    <span class="inline-block px-3 py-1 bg-white/10 rounded-full text-[10px] font-black uppercase tracking-widest mb-4">Current Unix Epoch</span>
                    <div id="current-unix" class="font-mono text-4xl md:text-5xl font-black text-orange-500 tabular-nums mb-4">0000000000</div>
                    <div class="flex items-center gap-4">
                        <button onclick="copyCurrentUnix()" class="px-4 py-2 bg-white/10 hover:bg-white/20 rounded-xl text-xs font-bold transition-all flex items-center gap-2">
                            <i data-lucide="copy" class="w-3.5 h-3.5"></i> Copy
                        </button>
                        <button onclick="refreshUnix()" class="px-4 py-2 bg-white/10 hover:bg-white/20 rounded-xl text-xs font-bold transition-all flex items-center gap-2">
                            <i data-lucide="refresh-cw" class="w-3.5 h-3.5"></i> Refresh
                        </button>
                    </div>
                </div>

                <!-- Convert Unix to Date -->
                <div class="bg-white dark:bg-gray-900 rounded-[2.5rem] p-8 border border-slate-200 dark:border-gray-800 shadow-sm">
                    <h3 class="text-lg font-black text-slate-900 dark:text-white mb-6 flex items-center gap-2">
                        <i data-lucide="arrow-right-left" class="w-5 h-5 text-indigo-500"></i>
                        Unix to Human Readable
                    </h3>
                    <div class="space-y-4">
                        <div class="relative">
                            <input type="text" id="input-unix" placeholder="Enter Unix Timestamp (seconds or ms)" class="w-full px-6 py-4 bg-slate-50 dark:bg-gray-800 border-2 border-transparent focus:border-indigo-500 dark:focus:border-indigo-500 rounded-2xl text-slate-900 dark:text-white font-mono transition-all outline-none">
                        </div>
                        <button onclick="convertUnixToDate()" class="w-full py-4 bg-indigo-600 hover:bg-indigo-500 text-white font-black uppercase tracking-widest rounded-2xl transition-all shadow-lg shadow-indigo-500/20">Convert</button>
                    </div>
                </div>

                <!-- Convert Date to Unix -->
                <div class="bg-white dark:bg-gray-900 rounded-[2.5rem] p-8 border border-slate-200 dark:border-gray-800 shadow-sm">
                    <h3 class="text-lg font-black text-slate-900 dark:text-white mb-6 flex items-center gap-2">
                        <i data-lucide="calendar" class="w-5 h-5 text-orange-500"></i>
                        Human Date to Unix
                    </h3>
                    <div class="space-y-4">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div class="space-y-2">
                                <label class="text-[10px] font-black uppercase tracking-widest text-slate-400">Date</label>
                                <input type="date" id="input-date" class="w-full px-4 py-3 bg-slate-50 dark:bg-gray-800 border-2 border-transparent focus:border-indigo-500 rounded-xl text-slate-900 dark:text-white transition-all outline-none">
                            </div>
                            <div class="space-y-2">
                                <label class="text-[10px] font-black uppercase tracking-widest text-slate-400">Time</label>
                                <input type="time" id="input-time" value="00:00" step="1" class="w-full px-4 py-3 bg-slate-50 dark:bg-gray-800 border-2 border-transparent focus:border-indigo-500 rounded-xl text-slate-900 dark:text-white transition-all outline-none">
                            </div>
                        </div>
                        <button onclick="convertDateToUnix()" class="w-full py-4 bg-slate-900 dark:bg-gray-800 hover:bg-slate-800 dark:hover:bg-gray-700 text-white font-black uppercase tracking-widest rounded-2xl transition-all shadow-lg">Generate Timestamp</button>
                    </div>
                </div>
            </div>

            <!-- Right Side: Results -->
            <div id="results-area" class="hidden animate-in fade-in slide-in-from-right-4 duration-500">
                <div class="bg-indigo-50 dark:bg-indigo-950/30 rounded-[3rem] p-8 md:p-12 border-2 border-indigo-200 dark:border-indigo-500/20 h-full">
                    <div class="flex items-center justify-between mb-8">
                        <span class="px-4 py-1.5 bg-indigo-100 dark:bg-indigo-500/20 text-indigo-600 dark:text-indigo-400 rounded-full text-[10px] font-black uppercase tracking-widest">Conversion Results</span>
                        <button onclick="clearResults()" class="text-slate-400 hover:text-rose-500 transition-colors">
                            <i data-lucide="x" class="w-5 h-5"></i>
                        </button>
                    </div>

                    <div class="space-y-8">
                        <div class="space-y-2">
                            <label class="text-[10px] font-black uppercase tracking-widest text-indigo-500/60">ISO 8601 Format</label>
                            <div class="flex items-center gap-3">
                                <p id="res-iso" class="text-lg md:text-xl font-bold text-slate-900 dark:text-white break-all"></p>
                                <button onclick="copyToClipboard('res-iso')" class="p-2 hover:bg-indigo-100 dark:hover:bg-indigo-500/10 rounded-lg transition-all"><i data-lucide="copy" class="w-4 h-4 text-indigo-500"></i></button>
                            </div>
                        </div>

                        <div class="space-y-2">
                            <label class="text-[10px] font-black uppercase tracking-widest text-indigo-500/60">Your Local Time</label>
                            <div class="flex items-center gap-3">
                                <p id="res-local" class="text-lg md:text-xl font-bold text-slate-900 dark:text-white break-all"></p>
                                <button onclick="copyToClipboard('res-local')" class="p-2 hover:bg-indigo-100 dark:hover:bg-indigo-500/10 rounded-lg transition-all"><i data-lucide="copy" class="w-4 h-4 text-indigo-500"></i></button>
                            </div>
                        </div>

                        <div class="space-y-2">
                            <label class="text-[10px] font-black uppercase tracking-widest text-indigo-500/60">UTC / GMT Time</label>
                            <div class="flex items-center gap-3">
                                <p id="res-utc" class="text-lg md:text-xl font-bold text-slate-900 dark:text-white break-all"></p>
                                <button onclick="copyToClipboard('res-utc')" class="p-2 hover:bg-indigo-100 dark:hover:bg-indigo-500/10 rounded-lg transition-all"><i data-lucide="copy" class="w-4 h-4 text-indigo-500"></i></button>
                            </div>
                        </div>

                        <div class="space-y-2">
                            <label class="text-[10px] font-black uppercase tracking-widest text-indigo-500/60">Unix Timestamp (Seconds)</label>
                            <div class="flex items-center gap-3">
                                <p id="res-unix" class="text-3xl md:text-4xl font-black text-indigo-600 dark:text-indigo-400 break-all tabular-nums"></p>
                                <button onclick="copyToClipboard('res-unix')" class="p-2 hover:bg-indigo-100 dark:hover:bg-indigo-500/10 rounded-lg transition-all"><i data-lucide="copy" class="w-4 h-4 text-indigo-500"></i></button>
                            </div>
                        </div>
                        
                        <div id="res-ms-area" class="space-y-2 hidden">
                            <label class="text-[10px] font-black uppercase tracking-widest text-indigo-500/60">Unix Timestamp (Milliseconds)</label>
                            <div class="flex items-center gap-3">
                                <p id="res-unix-ms" class="text-lg md:text-xl font-bold text-indigo-400 break-all tabular-nums"></p>
                                <button onclick="copyToClipboard('res-unix-ms')" class="p-2 hover:bg-indigo-100 dark:hover:bg-indigo-500/10 rounded-lg transition-all"><i data-lucide="copy" class="w-4 h-4 text-indigo-500"></i></button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Placeholder for results -->
            <div id="results-placeholder" class="bg-slate-100 dark:bg-gray-800/50 rounded-[3rem] p-12 border-2 border-dashed border-slate-200 dark:border-gray-700 flex flex-col items-center justify-center text-center">
                <div class="w-20 h-20 bg-slate-200 dark:bg-gray-800 rounded-full flex items-center justify-center mb-6 text-slate-400">
                    <i data-lucide="clock" class="w-10 h-10"></i>
                </div>
                <h3 class="text-lg font-bold text-slate-500 dark:text-gray-400">Ready to Convert</h3>
                <p class="text-sm text-slate-400 max-w-xs mt-2">Enter a timestamp or pick a date to see the results here.</p>
            </div>
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
    function updateCurrentUnix() {
        const now = Math.floor(Date.now() / 1000);
        document.getElementById('current-unix').textContent = now;
    }

    setInterval(updateCurrentUnix, 1000);
    updateCurrentUnix();

    function copyCurrentUnix() {
        const val = document.getElementById('current-unix').textContent;
        navigator.clipboard.writeText(val);
        // Toast logic could go here if available
    }

    function refreshUnix() {
        updateCurrentUnix();
    }

    function convertUnixToDate() {
        let val = document.getElementById('input-unix').value.trim();
        if (!val) return;

        let date;
        // Check if ms or seconds
        if (val.length > 11) {
            date = new Date(parseInt(val));
        } else {
            date = new Date(parseInt(val) * 1000);
        }

        if (isNaN(date.getTime())) {
            alert('Invalid Unix Timestamp');
            return;
        }

        showResults(date, val.length > 11 ? val : Math.floor(date.getTime() / 1000));
    }

    function convertDateToUnix() {
        const dateVal = document.getElementById('input-date').value;
        const timeVal = document.getElementById('input-time').value;
        
        if (!dateVal) {
            alert('Please select a date');
            return;
        }

        const date = new Date(`${dateVal}T${timeVal || '00:00:00'}`);
        if (isNaN(date.getTime())) {
            alert('Invalid Date or Time');
            return;
        }

        showResults(date, Math.floor(date.getTime() / 1000));
    }

    function showResults(date, unix) {
        document.getElementById('results-placeholder').classList.add('hidden');
        document.getElementById('results-area').classList.remove('hidden');

        document.getElementById('res-iso').textContent = date.toISOString();
        document.getElementById('res-local').textContent = date.toString();
        document.getElementById('res-utc').textContent = date.toUTCString();
        document.getElementById('res-unix').textContent = typeof unix === 'string' && unix.length > 11 ? Math.floor(parseInt(unix)/1000) : unix;
        
        const msArea = document.getElementById('res-ms-area');
        if (typeof unix === 'string' && unix.length > 11) {
            msArea.classList.remove('hidden');
            document.getElementById('res-unix-ms').textContent = unix;
        } else {
            msArea.classList.add('hidden');
        }

        lucide.createIcons();
    }

    function clearResults() {
        document.getElementById('results-area').classList.add('hidden');
        document.getElementById('results-placeholder').classList.remove('hidden');
        document.getElementById('input-unix').value = '';
    }

    function copyToClipboard(id) {
        const text = document.getElementById(id).textContent;
        navigator.clipboard.writeText(text);
    }
</script>

<?php require_once '../../../includes/footer.php'; ?>
