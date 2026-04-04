<?php
require_once '../../../includes/header.php';
$tool = get_current_tool_info($_SERVER['REQUEST_URI']);
?>

<!-- Tool Header -->
<section class="pt-12 pb-8 bg-gray-950">
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
                        <a href="<?php echo SITE_URL; ?>#text" class="hover:text-white">Text Tools</a>
                    </div>
                </li>
                <li aria-current="page">
                    <div class="flex items-center">
                        <i data-lucide="chevron-right" class="w-3 h-3 mx-1"></i>
                        <span class="text-gray-300"><?php echo $tool['name']; ?></span>
                    </div>
                </li>
            </ol>
        </nav>

        <div class="flex flex-col md:flex-row md:items-end justify-between gap-6 mb-12">
            <div class="max-w-2xl">
                <h1 class="text-3xl md:text-5xl font-heading font-extrabold text-white mb-4"><?php echo $tool['name']; ?></h1>
                <p class="text-gray-400 text-lg leading-relaxed"><?php echo $tool['desc']; ?></p>
            </div>
            <div class="flex gap-3">
                <div class="px-4 py-2 rounded-xl bg-indigo-600/10 border border-indigo-600/20 flex items-center gap-2 text-indigo-400 shadow-lg shadow-indigo-600/5 transition-all">
                    <i data-lucide="zap" class="w-5 h-5"></i>
                    <span class="text-sm font-medium">Real-time Analysis</span>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Tool Area -->
<section class="pb-24 bg-gray-950">
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">
            
            <!-- Main Content (Input) -->
            <div class="lg:col-span-3 space-y-6">
                <div class="relative group">
                    <textarea id="text-input" class="w-full h-[400px] p-8 rounded-[40px] bg-gray-900 border border-gray-800 text-white text-lg placeholder-gray-600 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all shadow-2xl resize-none" placeholder="Paste or type your text here..."></textarea>
                    
                    <button onclick="document.getElementById('text-input').value = ''; updateCounts();" class="absolute top-6 right-6 p-2 rounded-xl bg-gray-800 text-gray-400 hover:text-white transition-all" title="Clear Text">
                        <i data-lucide="trash-2" class="w-5 h-5"></i>
                    </button>
                    
                    <button onclick="copyToClipboard('text-input-copy')" class="absolute top-6 right-20 p-2 rounded-xl bg-indigo-600 text-white hover:bg-indigo-500 transition-all flex items-center gap-2 text-xs font-bold" title="Copy text">
                        <i data-lucide="copy" class="w-4 h-4"></i> Copy
                    </button>
                    <!-- Hidden for copy tool -->
                    <div id="text-input-copy" class="hidden"></div>
                </div>

                <div class="flex flex-wrap gap-3">
                    <button onclick="transformText('uppercase')" class="px-4 py-2 rounded-xl bg-gray-800 text-white text-xs font-bold hover:bg-indigo-600 transition-all uppercase tracking-widest">Uppercase</button>
                    <button onclick="transformText('lowercase')" class="px-4 py-2 rounded-xl bg-gray-800 text-white text-xs font-bold hover:bg-indigo-600 transition-all uppercase tracking-widest">Lowercase</button>
                    <button onclick="transformText('trim')" class="px-4 py-2 rounded-xl bg-gray-800 text-white text-xs font-bold hover:bg-indigo-600 transition-all uppercase tracking-widest">Trim Whitespace</button>
                </div>
            </div>

            <!-- Stats & Details (Right Sidebar) -->
            <div class="lg:col-span-1 space-y-6">
                <div class="glass-card rounded-[32px] p-8">
                    <h3 class="text-white font-bold mb-6 flex items-center gap-2">
                        <i data-lucide="bar-chart-3" class="w-5 h-5 text-indigo-400"></i>
                        Statistics
                    </h3>
                    
                    <div class="space-y-6">
                        <div class="flex justify-between items-center">
                            <span class="text-gray-400 text-sm">Words</span>
                            <span id="word-count" class="text-2xl font-black text-indigo-400">0</span>
                        </div>
                        <div class="h-px bg-gray-800"></div>
                        <div class="flex justify-between items-center">
                            <span class="text-gray-400 text-sm">Characters</span>
                            <span id="char-count" class="text-2xl font-black text-white">0</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-gray-400 text-sm">Sentences</span>
                            <span id="sentence-count" class="text-2xl font-black text-white">0</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-gray-400 text-sm">Paragraphs</span>
                            <span id="para-count" class="text-2xl font-black text-white">0</span>
                        </div>
                    </div>
                </div>

                <div class="glass-card rounded-[32px] p-8">
                    <h3 class="text-white font-bold mb-6 flex items-center gap-2">
                        <i data-lucide="clock" class="w-5 h-5 text-indigo-400"></i>
                        Readability
                    </h3>
                    <div class="space-y-4">
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-500">Reading Time</span>
                            <span id="read-time" class="text-white font-medium">0 min</span>
                        </div>
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-500">Speaking Time</span>
                            <span id="speak-time" class="text-white font-medium">0 min</span>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>

<script>
    const textarea = document.getElementById('text-input');
    const wordEl = document.getElementById('word-count');
    const charEl = document.getElementById('char-count');
    const sentenceEl = document.getElementById('sentence-count');
    const paraEl = document.getElementById('para-count');
    const readEl = document.getElementById('read-time');
    const speakEl = document.getElementById('speak-time');
    const copyTarget = document.getElementById('text-input-copy');

    textarea.addEventListener('input', updateCounts);

    function updateCounts() {
        const text = textarea.value;
        copyTarget.innerText = text;

        // Characters
        charEl.textContent = text.length;

        // Words
        const words = text.trim() === '' ? [] : text.trim().split(/\s+/);
        wordEl.textContent = words.length;

        // Sentences
        const sentences = text.trim() === '' ? [] : text.trim().split(/[.!?]+\s*/);
        sentenceEl.textContent = sentences.length;

        // Paragraphs
        const paragraphs = text.trim() === '' ? [] : text.trim().split(/\n+/);
        paraEl.textContent = paragraphs.length;

        // Reading Time (~200 wpm)
        const readTime = Math.ceil(words.length / 200);
        readEl.textContent = `${readTime} min`;

        // Speaking Time (~130 wpm)
        const speakTime = Math.ceil(words.length / 130);
        speakEl.textContent = `${speakTime} min`;
    }

    function transformText(type) {
        if (type === 'uppercase') textarea.value = textarea.value.toUpperCase();
        if (type === 'lowercase') textarea.value = textarea.value.toLowerCase();
        if (type === 'trim') textarea.value = textarea.value.replace(/\s+/g, ' ').trim();
        updateCounts();
    }
</script>

<?php
require_once '../../../includes/footer.php';
?>
