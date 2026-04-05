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
                        <a href="<?php echo SITE_URL; ?>#dev" class="hover:text-white">Developer Tools</a>
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
                <button onclick="minifyHTML()" class="px-6 py-3 rounded-2xl bg-indigo-600 text-white font-bold hover:bg-indigo-500 transition-all flex items-center gap-2 shadow-lg shadow-indigo-600/20">
                    <i data-lucide="minimize-2" class="w-5 h-5"></i> Minify HTML
                </button>
            </div>
        </div>
    </div>
</section>

<!-- Tool Area -->
<section class="pb-24 bg-gray-950">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            
            <!-- Input -->
            <div class="space-y-4">
                <div class="flex items-center justify-between">
                    <h3 class="text-white font-bold inline-flex items-center gap-2">
                        <i data-lucide="code" class="w-4 h-4 text-indigo-400"></i> Original HTML
                    </h3>
                    <button onclick="document.getElementById('input-html').value = '';" class="text-xs text-gray-500 hover:text-white transition-colors">Clear</button>
                </div>
                <div class="relative">
                    <textarea id="input-html" class="w-full h-[500px] p-6 rounded-2xl bg-gray-900 border border-gray-800 text-gray-300 font-mono text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 transition-all resize-none shadow-inner" placeholder="Paset your raw HTML here..."></textarea>
                </div>
            </div>

            <!-- Output -->
            <div class="space-y-4">
                <div class="flex items-center justify-between">
                    <h3 class="text-white font-bold inline-flex items-center gap-2">
                        <i data-lucide="file-check" class="w-4 h-4 text-emerald-400"></i> Minified HTML
                    </h3>
                    <div class="flex items-center gap-3">
                        <span id="savings" class="text-xs text-emerald-400 font-medium hidden">Saved: 0%</span>
                        <button onclick="copyMinified()" class="text-xs text-indigo-400 hover:text-indigo-300 transition-colors font-medium">Copy Result</button>
                    </div>
                </div>
                <div class="relative">
                    <textarea id="output-html" readonly class="w-full h-[500px] p-6 rounded-2xl bg-gray-900/50 border border-gray-800 text-gray-300 font-mono text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 transition-all resize-none" placeholder="Minified HTML will appear here..."></textarea>
                </div>
            </div>

        </div>
    </div>
</section>

<script>
    function countBytes(str) {
        return new Blob([str]).size;
    }

    function minifyHTML() {
        const input = document.getElementById('input-html').value;
        const outputEl = document.getElementById('output-html');
        const savingsEl = document.getElementById('savings');
        
        if (!input.trim()) {
            outputEl.value = '';
            savingsEl.classList.add('hidden');
            return;
        }

        // Extremely basic client-side minification
        let minified = input
            .replace(/<!--[\s\S]*?-->/g, '') // remove comments
            .replace(/\s+/g, ' ') // collapse whitespaces
            .replace(/>\s+</g, '><') // remove space between tags
            .replace(/ \/>/g, '/>') // clean self closing
            .trim();

        outputEl.value = minified;

        // Calculate savings
        const originalSize = countBytes(input);
        const newSize = countBytes(minified);
        
        if (originalSize > 0) {
            const savingsPercent = (((originalSize - newSize) / originalSize) * 100).toFixed(1);
            savingsEl.textContent = `Saved: ${savingsPercent}%`;
            savingsEl.classList.remove('hidden');
        }
    }

    function copyMinified() {
        const output = document.getElementById('output-html');
        if (!output.value) return;
        
        output.select();
        output.setSelectionRange(0, 99999);
        navigator.clipboard.writeText(output.value);
        
        // Show tooltip or visual feedback
        const btn = event.target;
        const originalText = btn.innerText;
        btn.innerText = "Copied!";
        setTimeout(() => { btn.innerText = originalText; }, 2000);
    }
</script>

<?php require_once '../../../includes/footer.php'; ?>
