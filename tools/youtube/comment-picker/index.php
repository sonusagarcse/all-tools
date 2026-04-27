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
                    <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-3">Video URL or ID</label>
                    <input type="text" id="yt-video-id" placeholder="https://youtube.com/watch?v=..." class="w-full px-5 py-4 rounded-2xl border border-slate-200 dark:border-gray-800 bg-white dark:bg-gray-900 text-sm focus:ring-2 focus:ring-red-500 outline-none transition-all">
                </div>

                <div class="flex items-center gap-3 mb-8">
                    <input type="checkbox" id="filter-duplicates" checked class="w-5 h-5 rounded-lg text-red-600 bg-gray-100 border-gray-300 focus:ring-0">
                    <label for="filter-duplicates" class="text-sm text-slate-600 dark:text-gray-400 cursor-pointer select-none">Filter duplicate users (1 entry per user)</label>
                </div>

                <button id="yt-fetch-btn" class="w-full py-5 bg-red-600 hover:bg-red-700 text-white font-black text-lg rounded-2xl transition-all active:scale-[0.98] shadow-xl shadow-red-500/20 flex items-center justify-center gap-3">
                    <i data-lucide="youtube" class="w-6 h-6"></i>
                    Fetch & Pick Winner
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

                <!-- Fetching State -->
                <div id="state-fetching" class="hidden text-center w-full">
                    <i data-lucide="loader-2" class="w-12 h-12 text-red-500 animate-spin mx-auto mb-4"></i>
                    <h3 class="text-xl font-bold text-slate-900 dark:text-white">Fetching comments...</h3>
                    <p id="yt-status-count" class="text-sm text-slate-500 uppercase tracking-widest mt-2">0 loaded</p>
                </div>

                <!-- Picking State (Animation) -->
                <div id="state-picking" class="hidden text-center w-full">
                    <div class="text-4xl md:text-6xl font-black text-red-600 mb-8 blur-[2px] transition-all duration-100" id="spinning-name">Selecting...</div>
                    <div class="w-full max-w-xs mx-auto h-2 bg-slate-100 dark:bg-gray-800 rounded-full overflow-hidden">
                        <div id="picking-progress" class="h-full bg-red-600 w-0"></div>
                    </div>
                </div>

                <!-- Winner State -->
                <div id="state-winner" class="hidden text-center scale-in w-full">
                    <div class="relative inline-block">
                        <img id="winner-avatar" src="" class="w-24 h-24 rounded-full mx-auto mb-4 border-4 border-yellow-400 shadow-xl object-cover">
                        <div class="absolute -bottom-2 -right-2 bg-yellow-400 rounded-full p-2 shadow-lg">
                            <i data-lucide="trophy" class="w-6 h-6 text-white"></i>
                        </div>
                    </div>
                    <p class="text-[10px] font-black text-yellow-600 uppercase tracking-[0.2em] mb-2 mt-4">We have a winner!</p>
                    <h2 class="text-3xl md:text-4xl font-heading font-black text-slate-900 dark:text-white mb-4 px-4 break-words" id="winner-name">Lucky User</h2>
                    
                    <div class="bg-white dark:bg-gray-800 rounded-2xl p-5 mb-8 relative border border-slate-200 dark:border-gray-700 text-left max-w-md mx-auto">
                        <i data-lucide="quote" class="absolute -top-3 -left-3 w-6 h-6 text-slate-300 dark:text-slate-600 bg-white dark:bg-gray-800 rounded-full p-1 border border-slate-200 dark:border-gray-700"></i>
                        <p id="winner-comment" class="text-sm text-slate-600 dark:text-slate-300 italic"></p>
                    </div>

                    <button id="yt-pick-another-btn" class="px-6 py-3 bg-slate-100 hover:bg-slate-200 dark:bg-gray-800 dark:hover:bg-gray-700 rounded-xl text-xs font-black uppercase text-slate-700 dark:text-slate-300 transition-colors inline-flex items-center gap-2">
                        <i data-lucide="dices" class="w-4 h-4"></i> Pick Another
                    </button>
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
let allComments = [];


function extractVideoId(url) {
    const regExp = /^.*(youtu.be\/|v\/|u\/\w\/|embed\/|watch\?v=|\&v=)([^#\&\?]*).*/;
    const match = url.match(regExp);
    return (match && match[2].length === 11) ? match[2] : url;
}

async function fetchAllComments(videoId) {
    let comments = [];
    let nextPageToken = '';
    
    showState('fetching');
    const fetchBtn = document.getElementById('yt-fetch-btn');
    fetchBtn.disabled = true;
    fetchBtn.classList.add('opacity-50', 'cursor-not-allowed');
    
    try {
        do {
            const url = `/tools/ajax/yt-comments.php?videoId=${videoId}${nextPageToken ? `&pageToken=${nextPageToken}` : ''}`;
            const response = await fetch(url);
            const data = await response.json();
            
            if (data.error) {
                throw new Error(data.error.message || 'API Error');
            }
            
            if (data.items) {
                comments = comments.concat(data.items);
                document.getElementById('yt-status-count').innerText = `${comments.length} loaded`;
            }
            
            nextPageToken = data.nextPageToken;
        } while (nextPageToken);

        allComments = comments;
        startRaffleAnimation();

    } catch (error) {
        alert('Error fetching comments: ' + error.message);
        showState('idle');
        fetchBtn.disabled = false;
        fetchBtn.classList.remove('opacity-50', 'cursor-not-allowed');
    }
}

function startRaffleAnimation() {
    if (allComments.length === 0) {
        alert('No comments found for this video.');
        showState('idle');
        const fetchBtn = document.getElementById('yt-fetch-btn');
        fetchBtn.disabled = false;
        fetchBtn.classList.remove('opacity-50', 'cursor-not-allowed');
        return;
    }

    let pool = allComments;

    if (document.getElementById('filter-duplicates').checked) {
        const uniqueAuthors = new Map();
        pool.forEach(item => {
            const authorId = item.snippet.topLevelComment.snippet.authorChannelId?.value || item.snippet.topLevelComment.snippet.authorDisplayName;
            if (!uniqueAuthors.has(authorId)) {
                uniqueAuthors.set(authorId, item);
            }
        });
        pool = Array.from(uniqueAuthors.values());
    }

    if (pool.length < 1) {
        alert("Not enough unique comments to pick a winner.");
        showState('idle');
        const fetchBtn = document.getElementById('yt-fetch-btn');
        fetchBtn.disabled = false;
        fetchBtn.classList.remove('opacity-50', 'cursor-not-allowed');
        return;
    }

    isPicking = true;
    showState('picking');
    document.getElementById('confetti').classList.add('opacity-0');
    document.getElementById('confetti').innerHTML = '';

    const spinEl = document.getElementById('spinning-name');
    const progressBar = document.getElementById('picking-progress');
    let duration = 3000;
    let startTime = Date.now();

    const interval = setInterval(() => {
        const elapsed = Date.now() - startTime;
        const progress = Math.min(elapsed / duration, 1);
        
        progressBar.style.width = (progress * 100) + '%';
        
        // Show random names during spin
        const randomComment = pool[Math.floor(Math.random() * pool.length)];
        spinEl.innerText = randomComment.snippet.topLevelComment.snippet.authorDisplayName.substring(0, 15);
        
        if (progress >= 1) {
            clearInterval(interval);
            const winner = pool[Math.floor(Math.random() * pool.length)];
            const snippet = winner.snippet.topLevelComment.snippet;
            
            document.getElementById('winner-name').innerText = snippet.authorDisplayName;
            document.getElementById('winner-avatar').src = snippet.authorProfileImageUrl;
            document.getElementById('winner-comment').innerText = snippet.textOriginal;
            
            showState('winner');
            createConfetti();
            isPicking = false;
            
            const fetchBtn = document.getElementById('yt-fetch-btn');
            fetchBtn.disabled = false;
            fetchBtn.classList.remove('opacity-50', 'cursor-not-allowed');
            fetchBtn.innerHTML = `<i data-lucide="refresh-cw" class="w-6 h-6"></i> Fetch Again`;
            if (typeof lucide !== 'undefined') lucide.createIcons();
        }
    }, 80);
}

document.getElementById('yt-fetch-btn').addEventListener('click', () => {
    if (isPicking) return;
    
    const videoInput = document.getElementById('yt-video-id').value.trim();
    
    if (!videoInput) {
        alert('Please enter a Video URL or ID.');
        return;
    }

    const videoId = extractVideoId(videoInput);

    fetchAllComments(videoId);
});

document.getElementById('yt-pick-another-btn').addEventListener('click', () => {
    if (!isPicking && allComments.length > 0) {
        startRaffleAnimation();
    }
});

function showState(state) {
    document.getElementById('state-idle').classList.add('hidden');
    document.getElementById('state-fetching').classList.add('hidden');
    document.getElementById('state-picking').classList.add('hidden');
    document.getElementById('state-winner').classList.add('hidden');
    document.getElementById('state-' + state).classList.remove('hidden');
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
