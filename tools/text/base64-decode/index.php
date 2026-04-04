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
                    <span class="text-sm font-medium">Instant Decoding</span>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Tool Area -->
<section class="pb-24 bg-gray-950">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <div class="space-y-6">
            <div class="relative group">
                <label for="text-input" class="block text-white font-bold mb-2">Base64 Input</label>
                <textarea id="text-input" class="w-full h-[200px] p-6 rounded-3xl bg-gray-900 border border-gray-800 text-white text-lg placeholder-gray-600 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all shadow-xl resize-none" placeholder="Paste Base64 string here..."></textarea>
            </div>

            <div class="flex justify-center py-2">
                <i data-lucide="arrow-down" class="w-8 h-8 text-gray-500"></i>
            </div>

            <div class="relative group">
                <label for="text-output" class="block text-white font-bold mb-2">Decoded Text Result</label>
                <textarea id="text-output" class="w-full h-[200px] p-6 rounded-3xl bg-gray-900 border border-gray-800 text-indigo-400 text-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 transition-all shadow-xl resize-none" readonly placeholder="Decoded text will appear here..."></textarea>
                
                <button onclick="copyToClipboard('text-output')" class="absolute bottom-6 right-6 p-3 rounded-xl bg-indigo-600 text-white hover:bg-indigo-500 transition-all flex items-center gap-2 text-sm font-bold shadow-lg" title="Copy result">
                    <i data-lucide="copy" class="w-5 h-5"></i> Copy Text
                </button>
            </div>
        </div>

    </div>
</section>

<script>
    const inputArea = document.getElementById('text-input');
    const outputArea = document.getElementById('text-output');

    inputArea.addEventListener('input', () => {
        try {
            const text = inputArea.value.trim();
            outputArea.value = text ? decodeURIComponent(escape(atob(text))) : '';
        } catch(e) {
            outputArea.value = 'Invalid Base64 string';
        }
    });
</script>

<?php
require_once '../../../includes/footer.php';
?>
