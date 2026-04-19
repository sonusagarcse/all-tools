<?php
require_once '../../../includes/header.php';
?>

<div class="max-w-4xl mx-auto px-4 py-6 md:py-12">
    <!-- Tool Header -->
    <div class="text-center mb-8 md:mb-12">
        <div class="inline-flex items-center justify-center w-12 h-12 md:w-16 md:h-16 rounded-2xl bg-red-600/10 text-red-600 mb-4">
            <i data-lucide="youtube" class="w-6 h-6 md:w-8 md:h-8"></i>
        </div>
        <h1 class="text-2xl md:text-4xl font-heading font-bold mb-3 px-2">YouTube Comment Picker</h1>
        <p class="text-sm md:text-base text-slate-600 dark:text-gray-400 max-w-2xl mx-auto px-4">
            Pick a random winner for your YouTube giveaways. Paste your list of comments and let our "Fair Picker" choose the lucky winner.
        </p>
    </div>

    <!-- Main Tool Container -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
        <!-- Input Section -->
        <div class="lg:col-span-5">
            <div class="glass rounded-3xl p-6 md:p-8 shadow-xl border border-slate-200 dark:border-gray-800 h-full">
                <div class="mb-6">
                    <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-3">Paste Comments (One per line)</label>
                    <textarea id="comment-list" placeholder="User1: Amazing video!&#10;User2: Pick me please!&#10;User3: Great content... " class="w-full h-64 px-5 py-4 rounded-2xl border border-slate-200 dark:border-gray-800 bg-white dark:bg-gray-900 text-sm font-mono focus:ring-2 focus:ring-red-500 outline-none transition-all resize-none"></textarea>
                </div>

                <div class="flex items-center gap-3 mb-8">
                    <input type="checkbox" id="filter-duplicates" checked class="w-5 h-5 rounded-lg text-red-600 bg-gray-100 border-gray-300 focus:ring-0">
                    <label for="filter-duplicates" class="text-sm text-slate-600 dark:text-gray-400 cursor-pointer select-none">Filter duplicate users</label>
                </div>

                <button onclick="pickWinner()" class="w-full py-5 bg-red-600 hover:bg-red-700 text-white font-black text-lg rounded-2xl transition-all active:scale-[0.98] shadow-xl shadow-red-500/20 flex items-center justify-center gap-3">
                    <i data-lucide="dice-5" class="w-6 h-6"></i>
                    Start Raffle
                </button>
            </div>
        </div>

        <!-- Animation / Result Section -->
        <div class="lg:col-span-7">
            <div id="picker-container" class="glass rounded-3xl p-8 border border-slate-200 dark:border-gray-800 h-full flex flex-col items-center justify-center relative overflow-hidden bg-slate-50/30 dark:bg-gray-900/30">
                
                <!-- Idle State -->
                <div id="state-idle" class="text-center">
                    <div class="w-32 h-32 rounded-full border-4 border-dashed border-slate-200 dark:border-gray-800 flex items-center justify-center mx-auto mb-6">
                        <i data-lucide="users" class="w-12 h-12 text-slate-300"></i>
                    </div>
                    <p class="text-slate-400 font-medium">Ready to pick a winner</p>
                </div>

                <!-- Picking State (Animation) -->
                <div id="state-picking" class="hidden text-center w-full">
                    <div class="text-4xl md:text-6xl font-black text-red-600 mb-8 blur-[2px] transition-all duration-100" id="spinning-name">Selecting...</div>
                    <div class="w-full max-w-xs mx-auto h-2 bg-slate-100 dark:bg-gray-800 rounded-full overflow-hidden">
                        <div id="picking-progress" class="h-full bg-red-600 w-0"></div>
                    </div>
                </div>

                <!-- Winner State -->
                <div id="state-winner" class="hidden text-center scale-in">
                    <div class="w-24 h-24 bg-yellow-400 rounded-full flex items-center justify-center mx-auto mb-6 shadow-2xl shadow-yellow-500/50">
                        <i data-lucide="trophy" class="w-12 h-12 text-white"></i>
                    </div>
                    <p class="text-[10px] font-black text-yellow-600 uppercase tracking-[0.2em] mb-2">We have a winner!</p>
                    <h2 class="text-3xl md:text-5xl font-heading font-black text-slate-900 dark:text-white mb-8 px-4 break-words" id="winner-name">Lucky User</h2>
                    <button onclick="resetPicker()" class="px-6 py-2 border-2 border-slate-200 dark:border-gray-800 rounded-xl text-xs font-black uppercase text-slate-400 hover:text-slate-900 dark:hover:text-white transition-colors">Pick Another</button>
                </div>

                <!-- Confetti Canvas (Simulated) -->
                <div id="confetti" class="absolute inset-0 pointer-events-none opacity-0 transition-opacity duration-1000"></div>
            </div>
        </div>
    </div>

    <!-- SEO Content Section -->
    <div class="mt-16 prose prose-slate dark:prose-invert max-w-none">
        <div class="p-8 rounded-[2rem] bg-red-50/50 dark:bg-red-900/10 border border-red-100 dark:border-red-900/30">
            <?php echo $current_tool['seo_text']; ?>
        </div>
    </div>
</div>

<style>
.scale-in { animation: scaleIn 0.5s cubic-bezier(0.175, 0.885, 0.32, 1.275) forwards; }
@keyframes scaleIn { from { transform: scale(0.8); opacity: 0; } to { transform: scale(1); opacity: 1; } }
@keyframes confetti-fall { 0% { transform: translateY(-10px) rotate(0); } 100% { transform: translateY(100vh) rotate(360deg); } }
.confetti-piece { position: absolute; top: -10px; animation: confetti-fall 3s linear forwards; }
</style>

<script>
let isPicking = false;

function pickWinner() {
    if (isPicking) return;
    
    const text = document.getElementById('comment-list').value.trim();
    if (!text) return alert("Please paste some comments first!");

    let comments = text.split('\n').filter(line => line.trim() !== '');
    
    if (document.getElementById('filter-duplicates').checked) {
        comments = [...new Set(comments)];
    }

    if (comments.length < 2) return alert("Please enter at least 2 unique comments.");

    isPicking = true;
    showState('picking');

    const spinEl = document.getElementById('spinning-name');
    const progressBar = document.getElementById('picking-progress');
    let duration = 3000;
    let startTime = Date.now();

    const interval = setInterval(() => {
        const elapsed = Date.now() - startTime;
        const progress = Math.min(elapsed / duration, 1);
        
        progressBar.style.width = (progress * 100) + '%';
        spinEl.innerText = comments[Math.floor(Math.random() * comments.length)].split(':')[0].substring(0, 15);
        
        if (progress >= 1) {
            clearInterval(interval);
            const winner = comments[Math.floor(Math.random() * comments.length)];
            document.getElementById('winner-name').innerText = winner;
            showState('winner');
            createConfetti();
            isPicking = false;
        }
    }, 80);
}

function showState(state) {
    document.getElementById('state-idle').classList.add('hidden');
    document.getElementById('state-picking').classList.add('hidden');
    document.getElementById('state-winner').classList.add('hidden');
    document.getElementById('state-' + state).classList.remove('hidden');
}

function resetPicker() {
    showState('idle');
    document.getElementById('confetti').classList.add('opacity-0');
    document.getElementById('confetti').innerHTML = '';
}

function createConfetti() {
    const container = document.getElementById('confetti');
    container.classList.remove('opacity-0');
    container.innerHTML = '';
    const colors = ['#ef4444', '#f59e0b', '#10b981', '#3b82f6', '#8b5cf6'];
    
    for (let i = 0; i < 100; i++) {
        const piece = document.createElement('div');
        piece.className = 'confetti-piece';
        piece.style.left = Math.random() * 100 + '%';
        piece.style.backgroundColor = colors[Math.floor(Math.random() * colors.length)];
        piece.style.width = (Math.random() * 8 + 4) + 'px';
        piece.style.height = (Math.random() * 8 + 4) + 'px';
        piece.style.animationDelay = (Math.random() * 2) + 's';
        piece.style.opacity = Math.random();
        container.appendChild(piece);
    }
}
</script>

<?php require_once '../../../includes/footer.php'; ?>
