<?php
require_once '../../../includes/header.php';

$videoId = '';
$tags = [];
$error = '';
$videoTitle = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['url'])) {
    $url = $_POST['url'];
    
    // Extract Video ID
    $regExp = '/^.*((youtu.be\/)|(v\/)|(\/u\/\w\/)|(embed\/)|(watch\?))\??v?=?([^#&?]*).*/';
    $regExpShorts = '/\/shorts\/([a-zA-Z0-9_-]+)/';
    
    if (preg_match($regExpShorts, $url, $matchShorts)) {
        $videoId = $matchShorts[1];
    } elseif (preg_match($regExp, $url, $match)) {
        $videoId = (strlen($match[7]) == 11) ? $match[7] : '';
    }

    if ($videoId) {
        $api_url = "https://www.youtube.com/watch?v=" . $videoId;
        
        // Use cURL for better handling
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $api_url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/91.0.4472.124 Safari/537.36');
        $html = curl_exec($ch);
        curl_close($ch);

        if ($html) {
            // Extract Keywords
            if (preg_match('/<meta name="keywords" content="(.*?)">/', $html, $matches)) {
                $tags = array_map('trim', explode(',', $matches[1]));
            }
            
            // Extract Title
            if (preg_match('/<title>(.*?)<\/title>/', $html, $titleMatches)) {
                $videoTitle = str_replace(' - YouTube', '', $titleMatches[1]);
            }
            
            if (empty($tags)) {
                $error = "No tags found for this video. Note: Some videos keep their tags hidden or don't have any.";
            }
        } else {
            $error = "Could not connect to YouTube. Please check the URL and try again.";
        }
    } else {
        $error = "Invalid YouTube URL. Please enter a valid video link.";
    }
}
?>

<div class="max-w-4xl mx-auto px-4 py-6 md:py-12">
    <!-- Tool Header -->
    <div class="text-center mb-8 md:mb-12">
        <div class="inline-flex items-center justify-center w-12 h-12 md:w-16 md:h-16 rounded-2xl bg-red-600/10 text-red-600 mb-4">
            <i data-lucide="youtube" class="w-6 h-6 md:w-8 md:h-8"></i>
        </div>
        <h1 class="text-2xl md:text-4xl font-heading font-bold mb-3 px-2">YouTube Tag Extractor</h1>
        <p class="text-sm md:text-base text-slate-600 dark:text-gray-400 max-w-2xl mx-auto px-4">
            Extract hidden SEO tags and keywords from any YouTube video or Shorts to boost your own rankings.
        </p>
    </div>

    <!-- Input Section -->
    <div class="glass rounded-3xl p-5 md:p-8 shadow-xl mb-8 border border-slate-200 dark:border-gray-800">
        <form method="POST">
            <div class="flex flex-col md:flex-row gap-3 md:gap-4">
                <div class="flex-1 relative">
                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                        <i data-lucide="link" class="w-4 h-4 md:w-5 md:h-5 text-slate-400"></i>
                    </div>
                    <input type="text" name="url" 
                        value="<?php echo isset($_POST['url']) ? htmlspecialchars($_POST['url']) : ''; ?>"
                        placeholder="Paste YouTube Video URL..." 
                        required
                        class="block w-full pl-10 md:pl-12 pr-4 py-3.5 md:py-4 rounded-2xl border border-slate-200 dark:border-gray-800 bg-white dark:bg-gray-900 text-sm md:text-base text-slate-900 dark:text-white focus:ring-2 focus:ring-red-500 outline-none transition-all">
                </div>
                <button type="submit" class="w-full md:w-auto px-8 py-3.5 md:py-4 bg-red-600 hover:bg-red-700 text-white font-bold rounded-2xl transition-all active:scale-95 flex items-center justify-center gap-2">
                    <i data-lucide="search" class="w-4 h-4 md:w-5 md:h-5"></i>
                    Extract Tags
                </button>
            </div>
        </form>
        <?php if ($error): ?>
            <p class="text-red-500 text-xs mt-3 flex items-center gap-1">
                <i data-lucide="alert-circle" class="w-3 h-3"></i> <?php echo $error; ?>
            </p>
        <?php endif; ?>
    </div>

    <!-- Results Section -->
    <?php if (!empty($tags)): ?>
        <div class="animate-in fade-in slide-in-from-bottom-4 duration-500">
            <div class="flex items-center justify-between mb-4 px-2">
                <h2 class="text-lg md:text-xl font-heading font-bold flex items-center gap-2">
                    <i data-lucide="youtube" class="w-5 h-5 text-red-500"></i> Extracted Tags
                </h2>
                <button onclick="copyAllTags()" class="text-xs font-black text-red-600 dark:text-red-400 uppercase tracking-widest hover:underline flex items-center gap-1">
                    <i data-lucide="copy" class="w-3 h-3"></i> Copy All
                </button>
            </div>

            <div class="glass rounded-[2rem] p-6 md:p-8 border border-emerald-100 dark:border-emerald-900/30">
                <?php if ($videoTitle): ?>
                    <p class="text-[10px] uppercase font-black text-slate-400 mb-2">Source Video</p>
                    <h3 class="text-sm font-bold text-slate-900 dark:text-white mb-6 break-words"><?php echo htmlspecialchars($videoTitle); ?></h3>
                <?php endif; ?>

                <div class="flex flex-wrap gap-2" id="tags-container">
                    <?php foreach ($tags as $tag): ?>
                        <div class="group px-4 py-2 bg-slate-50 dark:bg-gray-900/50 rounded-xl border border-slate-100 dark:border-gray-800 text-sm text-slate-700 dark:text-slate-300 flex items-center gap-2 transition-all hover:border-emerald-500/50">
                            <span><?php echo htmlspecialchars($tag); ?></span>
                            <button onclick="copySingleTag(this, '<?php echo addslashes($tag); ?>')" class="opacity-0 group-hover:opacity-100 transition-opacity text-slate-400 hover:text-emerald-500">
                                <i data-lucide="copy" class="w-3 h-3"></i>
                            </button>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    <?php endif; ?>

    <!-- SEO Text Section -->
    <div class="mt-16 prose prose-slate dark:prose-invert max-w-none">
        <div class="p-8 rounded-[2rem] bg-emerald-50/50 dark:bg-emerald-900/10 border border-emerald-100 dark:border-emerald-900/30">
            <?php echo $current_tool['seo_text']; ?>
        </div>
    </div>
</div>

<script>
function copyAllTags() {
    const tags = Array.from(document.querySelectorAll('#tags-container span')).map(s => s.innerText);
    const text = tags.join(', ');
    navigator.clipboard.writeText(text).then(() => {
        alert("All tags copied to clipboard!");
    });
}

function copySingleTag(btn, text) {
    navigator.clipboard.writeText(text).then(() => {
        const originalIcon = btn.innerHTML;
        btn.innerHTML = '<i data-lucide="check" class="w-3 h-3"></i>';
        btn.classList.add('text-emerald-500');
        setTimeout(() => {
            btn.innerHTML = originalIcon;
            btn.classList.remove('text-emerald-500');
        }, 1500);
    });
}
</script>

<?php require_once '../../../includes/footer.php'; ?>
