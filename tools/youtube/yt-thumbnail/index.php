<?php
require_once dirname(dirname(dirname(__DIR__))) . '/includes/header.php';
?>

<div class="max-w-4xl mx-auto px-4 py-6 md:py-12">
    <!-- Tool Header -->
    <div class="text-center mb-8 md:mb-12">
        <div class="inline-flex items-center justify-center w-12 h-12 md:w-16 md:h-16 rounded-2xl bg-red-600/10 text-red-600 mb-4">
            <i data-lucide="youtube" class="w-6 h-6 md:w-8 md:h-8"></i>
        </div>
        <h1 class="text-2xl md:text-4xl font-heading font-bold mb-3 md:mb-4 px-2">YouTube Thumbnail Downloader</h1>
        <p class="text-sm md:text-base text-slate-600 dark:text-gray-400 max-w-2xl mx-auto px-4">
            Extract and download high-quality thumbnails from any YouTube video instantly. 
        </p>
    </div>

    <!-- Input Section -->
    <div class="glass rounded-3xl p-5 md:p-8 shadow-xl mb-8 border border-slate-200 dark:border-gray-800">
        <div class="flex flex-col md:flex-row gap-3 md:gap-4">
            <div class="flex-1 relative">
                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                    <i data-lucide="link" class="w-4 h-4 md:w-5 md:h-5 text-slate-400"></i>
                </div>
                <input type="text" id="yt-url" 
                    placeholder="Paste YouTube Video URL..." 
                    class="block w-full pl-10 md:pl-12 pr-4 py-3.5 md:py-4 rounded-2xl border border-slate-200 dark:border-gray-800 bg-white dark:bg-gray-900 text-sm md:text-base text-slate-900 dark:text-white focus:ring-2 focus:ring-indigo-500 outline-none transition-all">
            </div>
            <button id="extract-btn" class="w-full md:w-auto px-8 py-3.5 md:py-4 bg-red-600 hover:bg-red-700 text-white font-bold rounded-2xl transition-all active:scale-95 flex items-center justify-center gap-2">
                <i data-lucide="search" class="w-4 h-4 md:w-5 md:h-5"></i>
                Extract
            </button>
        </div>
        <p id="error-msg" class="text-red-500 text-xs mt-3 hidden flex items-center gap-1">
            <i data-lucide="alert-circle" class="w-3 h-3"></i> Invalid YouTube URL. Please check and try again.
        </p>
    </div>

    <!-- Results Section (Hidden initially) -->
    <div id="results" class="hidden animate-in fade-in slide-in-from-bottom-4 duration-500">
        <h2 class="text-xl font-heading font-bold mb-6 flex items-center gap-2">
            <i data-lucide="image" class="w-5 h-5 text-indigo-500"></i> Available Resolutions
        </h2>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- HD Thumbnail -->
            <div class="glass rounded-3xl overflow-hidden border border-slate-200 dark:border-gray-800">
                <div class="aspect-video bg-slate-100 dark:bg-gray-800 relative group">
                    <img id="img-max" class="w-full h-full object-cover" src="" alt="HD Thumbnail">
                    <div class="absolute inset-0 bg-black/40 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center">
                        <span class="text-white text-xs font-bold px-3 py-1 bg-indigo-600 rounded-full">1280 x 720</span>
                    </div>
                </div>
                <div class="p-4 flex items-center justify-between">
                    <span class="text-sm font-bold">HD Quality (MaxRes)</span>
                    <button onclick="download('max')" class="p-2 bg-red-100 dark:bg-red-900/30 text-red-600 dark:text-red-400 rounded-xl hover:bg-red-600 hover:text-white transition-all">
                        <i data-lucide="download" class="w-5 h-5"></i>
                    </button>
                </div>
            </div>

            <!-- Standard -->
            <div class="glass rounded-3xl overflow-hidden border border-slate-200 dark:border-gray-800">
                <div class="aspect-video bg-slate-100 dark:bg-gray-800 relative group">
                    <img id="img-sd" class="w-full h-full object-cover" src="" alt="Standard Thumbnail">
                    <div class="absolute inset-0 bg-black/40 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center">
                        <span class="text-white text-xs font-bold px-3 py-1 bg-indigo-600 rounded-full">640 x 480</span>
                    </div>
                </div>
                <div class="p-4 flex items-center justify-between">
                    <span class="text-sm font-bold">Standard Quality</span>
                    <button onclick="download('sd')" class="p-2 bg-slate-100 dark:bg-gray-800 text-slate-600 dark:text-gray-400 rounded-xl hover:bg-indigo-600 hover:text-white transition-all">
                        <i data-lucide="download" class="w-5 h-5"></i>
                    </button>
                </div>
            </div>

            <!-- High -->
            <div class="glass rounded-3xl overflow-hidden border border-slate-200 dark:border-gray-800">
                <div class="aspect-video bg-slate-100 dark:bg-gray-800 relative group">
                    <img id="img-hq" class="w-full h-full object-cover" src="" alt="High Thumbnail">
                    <div class="absolute inset-0 bg-black/40 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center">
                        <span class="text-white text-xs font-bold px-3 py-1 bg-indigo-600 rounded-full">480 x 360</span>
                    </div>
                </div>
                <div class="p-4 flex items-center justify-between">
                    <span class="text-sm font-bold">Medium Quality (HQ)</span>
                    <button onclick="download('hq')" class="p-2 bg-slate-100 dark:bg-gray-800 text-slate-600 dark:text-gray-400 rounded-xl hover:bg-indigo-600 hover:text-white transition-all">
                        <i data-lucide="download" class="w-5 h-5"></i>
                    </button>
                </div>
            </div>

            <!-- Low -->
            <div class="glass rounded-3xl overflow-hidden border border-slate-200 dark:border-gray-800">
                <div class="aspect-video bg-slate-100 dark:bg-gray-800 relative group">
                    <img id="img-mq" class="w-full h-full object-cover" src="" alt="Medium Thumbnail">
                    <div class="absolute inset-0 bg-black/40 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center">
                        <span class="text-white text-xs font-bold px-3 py-1 bg-indigo-600 rounded-full">320 x 180</span>
                    </div>
                </div>
                <div class="p-4 flex items-center justify-between">
                    <span class="text-sm font-bold">Low Quality (MQ)</span>
                    <button onclick="download('mq')" class="p-2 bg-slate-100 dark:bg-gray-800 text-slate-600 dark:text-gray-400 rounded-xl hover:bg-indigo-600 hover:text-white transition-all">
                        <i data-lucide="download" class="w-5 h-5"></i>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- SEO Text Section -->
    <div class="mt-16 prose prose-slate dark:prose-invert max-w-none">
        <div class="p-8 rounded-[2rem] bg-indigo-50/50 dark:bg-indigo-900/10 border border-indigo-100 dark:border-indigo-900/30">
            <?php echo $current_tool['seo_text']; ?>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', () => {
    const urlInput = document.getElementById('yt-url');
    const extractBtn = document.getElementById('extract-btn');
    const results = document.getElementById('results');
    const errorMsg = document.getElementById('error-msg');
    
    const imgs = {
        max: document.getElementById('img-max'),
        sd: document.getElementById('img-sd'),
        hq: document.getElementById('img-hq'),
        mq: document.getElementById('img-mq')
    };

    let videoId = '';

    extractBtn.onclick = () => {
        const url = urlInput.value.trim();
        videoId = extractId(url);

        if (videoId) {
            errorMsg.classList.add('hidden');
            
            // Set image sources
            imgs.max.src = `https://img.youtube.com/vi/${videoId}/maxresdefault.jpg`;
            imgs.sd.src = `https://img.youtube.com/vi/${videoId}/sddefault.jpg`;
            imgs.hq.src = `https://img.youtube.com/vi/${videoId}/hqdefault.jpg`;
            imgs.mq.src = `https://img.youtube.com/vi/${videoId}/mqdefault.jpg`;

            results.classList.remove('hidden');
            results.scrollIntoView({ behavior: 'smooth', block: 'start' });
        } else {
            errorMsg.classList.remove('hidden');
            results.classList.add('hidden');
        }
    };

    function extractId(url) {
        const regExp = /^.*((youtu.be\/)|(v\/)|(\/u\/\w\/)|(embed\/)|(watch\?))\??v?=?([^#&?]*).*/;
        const regExpShorts = /\/shorts\/([a-zA-Z0-9_-]+)/;
        
        const match = url.match(regExp);
        const matchShorts = url.match(regExpShorts);

        if (matchShorts) return matchShorts[1];
        return (match && match[7].length == 11) ? match[7] : false;
    }

    window.download = (type) => {
        if (!videoId) return;
        const imgUrl = imgs[type].src;
        
        // Use proxy or open in new tab if CORS prevents direct download
        // For simple viral tools, opening in new tab is standard if direct fetch fails
        fetch(imgUrl)
            .then(res => res.blob())
            .then(blob => {
                const url = window.URL.createObjectURL(blob);
                const a = document.createElement('a');
                a.href = url;
                a.download = `youtube-thumbnail-${videoId}-${type}.jpg`;
                document.body.appendChild(a);
                a.click();
                a.remove();
            })
            .catch(() => {
                // Fallback: Open in new tab
                window.open(imgUrl, '_blank');
            });
    };
});
</script>

<?php require_once dirname(dirname(dirname(__DIR__))) . '/includes/footer.php'; ?>
