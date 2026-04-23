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
                <div class="px-4 py-2 rounded-xl bg-green-500/10 border border-green-500/20 flex items-center gap-2 text-green-600 dark:text-green-400 shadow-lg shadow-green-500/5 transition-all">
                    <i data-lucide="zap" class="w-5 h-5"></i>
                    <span class="text-sm font-medium">Real-time Precision</span>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Tool Area -->
<section class="pb-24 bg-slate-50 dark:bg-gray-950 transition-colors">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <div id="stopwatch-container" class="bg-white dark:bg-gray-900 rounded-[3rem] p-6 md:p-16 border border-slate-200 dark:border-gray-800 shadow-2xl relative transition-all overflow-hidden flex flex-col items-center">
            
            <!-- Glow effect -->
            <div class="absolute -top-40 -right-40 w-80 h-80 bg-indigo-500/5 dark:bg-indigo-500/10 rounded-full blur-[80px] pointer-events-none"></div>

            <div class="relative z-10 flex flex-col items-center w-full">
                <!-- Stopwatch Display -->
                <div class="flex flex-col items-center mb-12 w-full text-center">
                    <div class="flex items-center justify-center font-mono text-6xl sm:text-8xl md:text-[10rem] tracking-tight text-slate-900 dark:text-white mb-2 font-black tabular-nums filter drop-shadow-sm transition-all leading-none">
                        <span id="display-min">00</span><span class="text-slate-200 dark:text-gray-800 mx-1">:</span><span id="display-sec">00</span><span class="text-indigo-500 text-4xl sm:text-6xl md:text-8xl ml-2 md:ml-4 self-end pb-2 md:pb-4">.<span id="display-ms">00</span></span>
                    </div>
                </div>

                <!-- Controls -->
                <div class="grid grid-cols-2 sm:grid-cols-3 gap-4 w-full max-w-2xl px-2">
                    <button id="btn-start" onclick="startStopwatch()" class="px-6 py-5 rounded-2xl bg-indigo-600 text-white font-black uppercase tracking-widest hover:bg-indigo-500 transition-all shadow-xl shadow-indigo-500/25 flex items-center justify-center gap-3 hover:scale-105 active:scale-95 text-sm md:text-base">
                        <i data-lucide="play" class="w-5 h-5 md:w-6 md:h-6 fill-current"></i> Start
                    </button>
                    <button id="btn-stop" onclick="stopStopwatch()" class="hidden px-6 py-5 rounded-2xl bg-rose-600 text-white font-black uppercase tracking-widest hover:bg-rose-500 transition-all shadow-xl shadow-rose-500/25 flex items-center justify-center gap-3 hover:scale-105 active:scale-95 text-sm md:text-base">
                        <i data-lucide="square" class="w-5 h-5 md:w-6 md:h-6 fill-current"></i> Stop
                    </button>
                    <button id="btn-lap" onclick="addLap()" class="px-6 py-5 rounded-2xl bg-slate-100 dark:bg-gray-800 text-slate-700 dark:text-white font-black uppercase tracking-widest hover:bg-slate-200 dark:hover:bg-gray-700 transition-all flex items-center justify-center gap-3 hover:scale-105 active:scale-95 text-sm md:text-base shadow-sm">
                        <i data-lucide="timer" class="w-5 h-5 md:w-6 md:h-6"></i> Lap
                    </button>
                    <button id="btn-reset" onclick="resetStopwatch()" class="px-6 py-5 rounded-2xl bg-slate-100 dark:bg-gray-800 text-slate-500 dark:text-gray-400 font-bold uppercase tracking-widest hover:bg-slate-200 dark:hover:bg-gray-700 hover:text-slate-900 dark:hover:text-white transition-all flex items-center justify-center gap-3 hover:scale-105 active:scale-95 text-sm md:text-base shadow-sm">
                        <i data-lucide="rotate-ccw" class="w-5 h-5 md:w-6 md:h-6"></i> Reset
                    </button>
                </div>

                <!-- Laps Table -->
                <div id="laps-container" class="hidden mt-12 w-full max-w-2xl bg-slate-50 dark:bg-gray-800/50 rounded-3xl overflow-hidden border border-slate-200 dark:border-gray-800">
                    <div class="px-6 py-4 bg-slate-100 dark:bg-gray-800 flex items-center justify-between border-b border-slate-200 dark:border-gray-700">
                        <span class="text-xs font-black uppercase tracking-widest text-slate-500 dark:text-gray-400">Lap Records</span>
                        <button onclick="clearLaps()" class="text-[10px] font-bold uppercase tracking-widest text-rose-500 hover:text-rose-600 transition-colors">Clear All</button>
                    </div>
                    <div class="max-h-60 overflow-y-auto">
                        <table class="w-full text-left">
                            <tbody id="laps-body" class="divide-y divide-slate-100 dark:divide-gray-800">
                                <!-- Laps inserted here -->
                            </tbody>
                        </table>
                    </div>
                </div>
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
    let startTime;
    let elapsedTime = 0;
    let timerInterval;
    let laps = [];

    const displayMin = document.getElementById('display-min');
    const displaySec = document.getElementById('display-sec');
    const displayMs = document.getElementById('display-ms');
    const lapsContainer = document.getElementById('laps-container');
    const lapsBody = document.getElementById('laps-body');
    const btnStart = document.getElementById('btn-start');
    const btnStop = document.getElementById('btn-stop');

    function timeToString(time) {
        let diffInMin = time / (1000 * 60);
        let mm = Math.floor(diffInMin);

        let diffInSec = (diffInMin - mm) * 60;
        let ss = Math.floor(diffInSec);

        let diffInMs = (diffInSec - ss) * 100;
        let ms = Math.floor(diffInMs);

        return {
            mm: mm.toString().padStart(2, "0"),
            ss: ss.toString().padStart(2, "0"),
            ms: ms.toString().padStart(2, "0")
        };
    }

    function print(txt) {
        displayMin.innerHTML = txt.mm;
        displaySec.innerHTML = txt.ss;
        displayMs.innerHTML = txt.ms;
    }

    function startStopwatch() {
        startTime = Date.now() - elapsedTime;
        timerInterval = setInterval(function printTime() {
            elapsedTime = Date.now() - startTime;
            print(timeToString(elapsedTime));
        }, 10);
        showButton("STOP");
    }

    function stopStopwatch() {
        clearInterval(timerInterval);
        showButton("START");
    }

    function resetStopwatch() {
        clearInterval(timerInterval);
        print({ mm: "00", ss: "00", ms: "00" });
        elapsedTime = 0;
        showButton("START");
        clearLaps();
    }

    function addLap() {
        if (elapsedTime === 0) return;
        const time = timeToString(elapsedTime);
        const lapTime = `${time.mm}:${time.ss}.${time.ms}`;
        laps.unshift(lapTime);
        renderLaps();
    }

    function renderLaps() {
        lapsContainer.classList.remove('hidden');
        lapsBody.innerHTML = laps.map((lap, index) => `
            <tr class="animate-in fade-in slide-in-from-top-2 duration-300">
                <td class="px-6 py-4 text-sm font-bold text-slate-400 dark:text-gray-500">Lap ${laps.length - index}</td>
                <td class="px-6 py-4 text-sm font-mono font-bold text-slate-700 dark:text-gray-300 text-right">${lap}</td>
            </tr>
        `).join('');
    }

    function clearLaps() {
        laps = [];
        lapsBody.innerHTML = '';
        lapsContainer.classList.add('hidden');
    }

    function showButton(buttonKey) {
        if (buttonKey === "STOP") {
            btnStart.classList.add("hidden");
            btnStop.classList.remove("hidden");
        } else {
            btnStart.classList.remove("hidden");
            btnStop.classList.add("hidden");
        }
    }
</script>

<?php require_once '../../../includes/footer.php'; ?>
