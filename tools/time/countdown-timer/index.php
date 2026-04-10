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
                    <i data-lucide="lock" class="w-5 h-5"></i>
                    <span class="text-sm font-medium">100% Client Side</span>
                </div>
            </div>
        </div>
    </div>
</section>

<<!-- Tool Area -->
<section class="pb-24 bg-slate-50 dark:bg-gray-950 transition-colors">
    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
        <div id="timer-container" class="bg-white dark:bg-gray-900 rounded-[2rem] p-8 md:p-12 border border-slate-200 dark:border-gray-800 shadow-2xl relative transition-all overflow-hidden flex flex-col items-center">
            
            <!-- Glow effect -->
            <div class="absolute -top-40 -right-40 w-80 h-80 bg-pink-500/5 dark:bg-pink-500/10 rounded-full blur-[80px] pointer-events-none"></div>

            <!-- Fullscreen Toggle -->
            <div class="absolute top-6 right-6 z-20">
                <button onclick="toggleFullScreen()" class="p-3 rounded-2xl bg-slate-100 dark:bg-gray-800 text-slate-500 dark:text-gray-400 hover:text-indigo-600 dark:hover:text-white transition-all shadow-sm" title="Fullscreen Mode">
                    <i data-lucide="maximize" id="fs-icon" class="w-5 h-5"></i>
                </button>
            </div>

            <div class="relative z-10 flex flex-col items-center w-full">
                <!-- Input Controls -->
                <div id="input-container" class="flex flex-col items-center gap-6 mb-10 bg-slate-50 dark:bg-gray-800/80 p-6 md:p-8 rounded-[2.5rem] border border-slate-200 dark:border-gray-700/50 shadow-inner w-full max-w-lg transition-colors">
                    <div class="flex items-center gap-4 justify-center w-full">
                        <div class="text-center">
                            <input type="number" id="input-hours" min="0" max="99" value="0" class="w-20 md:w-24 h-24 bg-white dark:bg-gray-900 text-slate-800 dark:text-pink-400 font-mono text-4xl text-center rounded-2xl border-2 border-slate-200 dark:border-none focus:ring-2 focus:ring-pink-500 transition-all font-bold shadow-sm">
                            <div class="text-slate-500 dark:text-gray-500 text-xs uppercase tracking-widest mt-3 font-bold">Hours</div>
                        </div>
                        <div class="text-4xl font-mono text-slate-400 dark:text-gray-600 mb-8">:</div>
                        <div class="text-center">
                            <input type="number" id="input-minutes" min="0" max="59" value="05" class="w-20 md:w-24 h-24 bg-white dark:bg-gray-900 text-slate-800 dark:text-pink-400 font-mono text-4xl text-center rounded-2xl border-2 border-slate-200 dark:border-none focus:ring-2 focus:ring-pink-500 transition-all font-bold shadow-sm">
                            <div class="text-slate-500 dark:text-gray-500 text-xs uppercase tracking-widest mt-3 font-bold">Minutes</div>
                        </div>
                        <div class="text-4xl font-mono text-slate-400 dark:text-gray-600 mb-8">:</div>
                        <div class="text-center">
                            <input type="number" id="input-seconds" min="0" max="59" value="0" class="w-20 md:w-24 h-24 bg-white dark:bg-gray-900 text-slate-800 dark:text-pink-400 font-mono text-4xl text-center rounded-2xl border-2 border-slate-200 dark:border-none focus:ring-2 focus:ring-pink-500 transition-all font-bold shadow-sm">
                            <div class="text-slate-500 dark:text-gray-500 text-xs uppercase tracking-widest mt-3 font-bold">Seconds</div>
                        </div>
                    </div>
                    
                    <div class="w-full max-w-sm">
                        <input type="text" id="company-name" placeholder="Business / Event Name (Optional)" class="w-full px-6 py-4 bg-white dark:bg-gray-900 text-slate-700 dark:text-white rounded-2xl border-2 border-slate-200 dark:border-none focus:ring-2 focus:ring-pink-500 transition-all text-center font-medium shadow-sm">
                    </div>
                </div>

                <!-- Timer Display (Hidden while inputting) -->
                <div id="timer-display" class="hidden flex-col items-center mb-10 w-full text-center">
                    <div id="display-company-name" class="text-pink-500 font-black uppercase tracking-[0.3em] mb-4 text-xl md:text-2xl min-h-[1.5em] empty:hidden"></div>
                    <div class="fs-label hidden text-slate-400 dark:text-gray-600 font-bold uppercase tracking-[0.5em] mb-4 text-sm mt-4">Time Remaining</div>
                    <div class="flex items-center justify-center font-mono text-7xl md:text-[9rem] tracking-tight text-slate-900 dark:text-white mb-2 font-black tabular-nums filter drop-shadow-sm dark:drop-shadow-lg transition-all">
                        <span id="display-hours">00</span><span class="text-slate-300 dark:text-gray-700 mx-2">:</span><span id="display-minutes">00</span><span class="text-slate-300 dark:text-gray-700 mx-2">:</span><span id="display-seconds">00</span>
                    </div>
                    <div class="w-full bg-slate-100 dark:bg-gray-800 rounded-full h-3 mt-10 mb-2 overflow-hidden border border-slate-200 dark:border-gray-700 shadow-inner">
                        <div id="progress-bar" class="bg-gradient-to-r from-pink-500 to-rose-500 h-3 rounded-full transition-all duration-1000 ease-linear shadow-[0_0_15px_rgba(236,72,153,0.3)]" style="width: 100%"></div>
                    </div>
                </div>

                <!-- Controls -->
                <div id="controls-area" class="flex flex-wrap justify-center gap-4 w-full max-w-sm relative z-20">
                    <button id="btn-start" onclick="startTimer()" class="flex-1 min-w-[140px] px-8 py-5 rounded-[1.5rem] bg-gradient-to-r from-pink-600 to-rose-600 text-white font-black uppercase tracking-widest hover:from-pink-500 hover:to-rose-500 transition-all shadow-xl shadow-pink-500/25 flex items-center justify-center gap-3 hover:scale-105 active:scale-95 text-sm">
                        <i data-lucide="play" class="w-6 h-6 fill-current"></i> Start
                    </button>
                    <button id="btn-pause" onclick="pauseTimer()" class="hidden flex-1 min-w-[140px] px-8 py-5 rounded-[1.5rem] bg-slate-100 dark:bg-gray-800 text-slate-700 dark:text-white font-black uppercase tracking-widest hover:bg-slate-200 dark:hover:bg-gray-700 transition-all flex items-center justify-center gap-3 hover:scale-105 active:scale-95 text-sm shadow-lg">
                        <i data-lucide="pause" class="w-6 h-6 fill-current"></i> Pause
                    </button>
                    <button id="btn-resume" onclick="resumeTimer()" class="hidden flex-1 min-w-[140px] px-8 py-5 rounded-[1.5rem] bg-gradient-to-r from-emerald-600 to-teal-600 text-white font-black uppercase tracking-widest hover:from-emerald-500 hover:to-teal-500 transition-all shadow-xl shadow-emerald-500/25 flex items-center justify-center gap-3 hover:scale-105 active:scale-95 text-sm">
                        <i data-lucide="play" class="w-6 h-6 fill-current"></i> Resume
                    </button>
                    <button id="btn-reset" onclick="resetTimer()" class="flex-1 min-w-[140px] px-8 py-5 rounded-[1.5rem] bg-slate-100 dark:bg-gray-800 text-slate-500 dark:text-gray-300 font-bold uppercase tracking-widest hover:bg-slate-200 dark:hover:bg-gray-700 hover:text-slate-900 dark:hover:text-white transition-all flex items-center justify-center gap-3 hover:scale-105 active:scale-95 text-sm shadow-sm">
                        <i data-lucide="rotate-ccw" class="w-6 h-6"></i> Reset
                    </button>
                </div>
                
                <div id="buzzer-message" class="hidden mt-10 text-center animate-bounce">
                    <div class="inline-flex items-center gap-3 px-8 py-4 rounded-3xl bg-red-500/10 dark:bg-red-500/20 border border-red-500/30 dark:border-red-500/50 text-red-600 dark:text-red-500 font-black text-xl shadow-xl">
                        <i data-lucide="bell-ring" class="w-8 h-8 animate-pulse"></i> Time is up!
                    </div>
                    <div class="mt-6">
                        <button onclick="stopBuzzer()" class="text-sm text-slate-400 dark:text-gray-400 hover:text-red-500 dark:hover:text-white underline transition-colors">Stop Alarm</button>
                    </div>
                </div>

            </div>
        </div>
    </div>
</section>

<style>
    /* Fullscreen Specific Styles */
    #timer-container:fullscreen {
        background: #000;
        width: 100vw;
        height: 100vh;
        display: flex;
        align-items: center;
        justify-content: center;
        border: none;
        padding: 5vw;
        border-radius: 0;
    }
    
    html:not(.dark) #timer-container:fullscreen {
        background: #fff;
    }

    #timer-container:fullscreen .fs-label {
        display: block;
    }

    #timer-container:fullscreen #timer-display {
        display: flex !important;
        margin-bottom: 0;
    }

    #timer-container:fullscreen font-mono {
        font-size: 25vw !important;
    }

    #timer-container:fullscreen #progress-bar {
        height: 1.5vh;
    }
    
    #timer-container:fullscreen #controls-area {
        position: fixed;
        bottom: 10vh;
        max-width: none;
        width: auto;
    }
</style>

<script>
    // A simple pure tone generated by Web Audio API to act as a buzzer
    const audioCtx = new (window.AudioContext || window.webkitAudioContext)();
    let beepOscillator = null;
    let beepInterval = null;

    function playBuzzer() {
        if(beepInterval) return; // already playing
        
        let on = true;
        
        const b = () => {
             // Resume context if suspended
            if(audioCtx.state === 'suspended') {
                audioCtx.resume();
            }
            if(on) {
                beepOscillator = audioCtx.createOscillator();
                const gainNode = audioCtx.createGain();
                beepOscillator.type = 'square';
                beepOscillator.frequency.value = 880; // A5
                beepOscillator.connect(gainNode);
                gainNode.connect(audioCtx.destination);
                beepOscillator.start();
                gainNode.gain.exponentialRampToValueAtTime(0.00001, audioCtx.currentTime + 0.3);
                setTimeout(() => beepOscillator?.stop(), 300);
            }
            on = !on;
        };
        
        b();
        beepInterval = setInterval(b, 400); // beep pattern
    }

    function stopBuzzer() {
        if(beepInterval) {
            clearInterval(beepInterval);
            beepInterval = null;
        }
        if(beepOscillator) {
            try { beepOscillator.stop(); } catch(e){}
            beepOscillator = null;
        }
        document.getElementById('buzzer-message').classList.add('hidden');
    }

    let totalSeconds = 0;
    let timerInterval = null;
    let initialTotalSeconds = 0;

    const displayContainer = document.getElementById('timer-display');
    const progressBar = document.getElementById('progress-bar');

    function updateDisplay(h, m, s) {
        document.getElementById('display-hours').textContent = String(h).padStart(2, '0');
        document.getElementById('display-minutes').textContent = String(m).padStart(2, '0');
        document.getElementById('display-seconds').textContent = String(s).padStart(2, '0');
    }

    function startTimer() {
        const h = parseInt(document.getElementById('input-hours').value) || 0;
        const m = parseInt(document.getElementById('input-minutes').value) || 0;
        const s = parseInt(document.getElementById('input-seconds').value) || 0;
        const company = document.getElementById('company-name').value;
        
        totalSeconds = (h * 3600) + (m * 60) + s;
        if(totalSeconds <= 0) return;
        
        initialTotalSeconds = totalSeconds;

        // Set company name
        document.getElementById('display-company-name').textContent = company;

        document.getElementById('input-container').classList.add('hidden');
        displayContainer.classList.remove('hidden');
        displayContainer.classList.add('flex');
        
        document.getElementById('btn-start').classList.add('hidden');
        document.getElementById('btn-pause').classList.remove('hidden');
        document.getElementById('btn-pause').classList.add('flex');
        document.getElementById('btn-resume').classList.add('hidden');
        
        stopBuzzer();
        tick();
        timerInterval = setInterval(tick, 1000);
        
        // Ensure audio context is ready on user interaction
        if(audioCtx.state === 'suspended') {
            audioCtx.resume();
        }
    }

    function tick() {
        if(totalSeconds <= 0) {
            clearInterval(timerInterval);
            timerInterval = null;
            updateDisplay(0, 0, 0);
            progressBar.style.width = '0%';
            onTimerEnd();
            return;
        }
        
        const h = Math.floor(totalSeconds / 3600);
        const m = Math.floor((totalSeconds % 3600) / 60);
        const s = totalSeconds % 60;
        
        updateDisplay(h, m, s);
        
        const percentage = (totalSeconds / initialTotalSeconds) * 100;
        progressBar.style.width = percentage + '%';
        
        totalSeconds--;
    }

    function pauseTimer() {
        if(timerInterval) {
            clearInterval(timerInterval);
            timerInterval = null;
            document.getElementById('btn-pause').classList.add('hidden');
            document.getElementById('btn-resume').classList.remove('hidden');
            document.getElementById('btn-resume').classList.add('flex');
        }
    }

    function resumeTimer() {
        if(!timerInterval && totalSeconds > 0) {
            timerInterval = setInterval(tick, 1000);
            document.getElementById('btn-resume').classList.add('hidden');
            document.getElementById('btn-pause').classList.remove('hidden');
            document.getElementById('btn-pause').classList.add('flex');
        }
    }

    function resetTimer() {
        stopBuzzer();
        if(timerInterval) {
            clearInterval(timerInterval);
            timerInterval = null;
        }
        
        // Reset inputs to 0
        document.getElementById('input-hours').value = "0";
        document.getElementById('input-minutes').value = "05";
        document.getElementById('input-seconds').value = "0";
        document.getElementById('company-name').value = "";
        document.getElementById('display-company-name').textContent = "";
        
        document.getElementById('input-container').classList.remove('hidden');
        displayContainer.classList.add('hidden');
        displayContainer.classList.remove('flex');
        
        document.getElementById('btn-start').classList.remove('hidden');
        document.getElementById('btn-pause').classList.add('hidden');
        document.getElementById('btn-pause').classList.remove('flex');
        document.getElementById('btn-resume').classList.add('hidden');
        document.getElementById('btn-resume').classList.remove('flex');
        
        progressBar.style.width = '100%';
    }

    function onTimerEnd() {
        document.getElementById('btn-pause').classList.add('hidden');
        document.getElementById('btn-resume').classList.add('hidden');
        document.getElementById('btn-start').classList.add('hidden');
        // Let the user reset or we can just leave it as is
        // Display buzzer message
        document.getElementById('buzzer-message').classList.remove('hidden');
        playBuzzer();
    }

    // Fullscreen Logic
    function toggleFullScreen() {
        const container = document.getElementById('timer-container');
        if (!document.fullscreenElement) {
            container.requestFullscreen().catch(err => {
                alert(`Error attempting to enable full-screen mode: ${err.message} (${err.name})`);
            });
        } else {
            document.exitFullscreen();
        }
    }

    document.addEventListener('fullscreenchange', () => {
        const icon = document.getElementById('fs-icon');
        if (document.fullscreenElement) {
            icon.setAttribute('data-lucide', 'minimize');
        } else {
            icon.setAttribute('data-lucide', 'maximize');
        }
        lucide.createIcons();
    });
</script>

<?php require_once '../../../includes/footer.php'; ?>
