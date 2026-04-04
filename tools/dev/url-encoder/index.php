<?php
require_once dirname(dirname(dirname(__DIR__))) . '/includes/header.php';
$tool_id = 'url-encoder';
$cat_id = 'dev';
$tool = $TOOL_CATEGORIES[$cat_id]['tools'][$tool_id];
?>

<div class="pt-24 pb-12 bg-slate-50 dark:bg-gray-950 min-h-screen">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Breadcrumb & Header -->
        <div class="mb-8 animate-fade-in">
            <div class="flex items-center gap-2 text-sm font-medium text-slate-500 dark:text-gray-400 mb-4">
                <a href="<?php echo SITE_URL; ?>" class="hover:text-indigo-600 dark:hover:text-indigo-400 transition-colors">Home</a>
                <i data-lucide="chevron-right" class="w-4 h-4"></i>
                <a href="<?php echo SITE_URL; ?>#<?php echo $cat_id; ?>" class="hover:text-indigo-600 dark:hover:text-indigo-400 transition-colors"><?php echo $TOOL_CATEGORIES[$cat_id]['name']; ?></a>
                <i data-lucide="chevron-right" class="w-4 h-4"></i>
                <span class="text-slate-900 dark:text-white"><?php echo $tool['name']; ?></span>
            </div>
            <h1 class="text-4xl font-heading font-extrabold text-slate-900 dark:text-white mb-4"><?php echo $tool['name']; ?></h1>
            <p class="text-lg text-slate-600 dark:text-gray-400 max-w-2xl"><?php echo $tool['desc']; ?> Client-side processing for secure conversion.</p>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 animate-fade-in" style="animation-delay: 0.1s">
            <!-- Left Side -->
            <div class="glass-card rounded-2xl p-6 flex flex-col h-[500px]">
                <div class="flex items-center justify-between mb-4">
                    <h2 class="text-lg font-bold text-slate-900 dark:text-white flex items-center gap-2">
                        Text
                    </h2>
                    <div class="flex gap-2">
                        <button id="btn-clear" class="p-2 text-slate-400 hover:text-slate-600 dark:hover:text-white transition" title="Clear">
                            <i data-lucide="trash-2" class="w-4 h-4"></i>
                        </button>
                    </div>
                </div>
                <textarea id="input-text" class="w-full h-full flex-grow p-4 rounded-xl text-sm resize-none focus:ring-2 focus:ring-indigo-500" placeholder="Type or paste text to encode..."></textarea>
            </div>

            <!-- Right Side Controls -->
            <div class="flex flex-col gap-6">
                <!-- Action Buttons -->
                <div class="glass-card rounded-2xl p-6 flex gap-4">
                    <button id="btn-encode" class="flex-1 py-4 bg-indigo-600 text-white rounded-xl font-bold flex items-center justify-center gap-2 hover:bg-indigo-500 transition shadow-lg shadow-indigo-600/20">
                        <i data-lucide="arrow-right" class="w-5 h-5"></i> Encode URL
                    </button>
                    <button id="btn-decode" class="flex-1 py-4 bg-white dark:bg-gray-800 text-slate-900 dark:text-white border border-slate-200 dark:border-gray-700 rounded-xl font-bold flex items-center justify-center gap-2 hover:bg-slate-50 dark:hover:bg-gray-700 transition">
                        <i data-lucide="arrow-left" class="w-5 h-5"></i> Decode URL
                    </button>
                </div>

                <!-- Output Area -->
                <div class="glass-card rounded-2xl p-6 flex flex-col flex-grow">
                    <div class="flex items-center justify-between mb-4">
                        <h2 class="text-lg font-bold text-slate-900 dark:text-white flex items-center gap-2">
                            Result
                        </h2>
                        <button id="btn-copy" class="px-3 py-1.5 text-xs font-semibold rounded-lg bg-indigo-50 dark:bg-indigo-500/10 text-indigo-600 dark:text-indigo-400 hover:bg-indigo-100 dark:hover:bg-indigo-500/20 transition flex items-center gap-1">
                            <i data-lucide="copy" class="w-3.5 h-3.5"></i> Copy
                        </button>
                    </div>
                    <textarea id="output-text" class="w-full h-full flex-grow p-4 rounded-xl text-sm resize-none bg-slate-100 dark:bg-gray-900 border-none focus:ring-2 focus:ring-indigo-500" readonly placeholder="Output will appear here..."></textarea>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', () => {
    const inputText = document.getElementById('input-text');
    const outputText = document.getElementById('output-text');
    const btnEncode = document.getElementById('btn-encode');
    const btnDecode = document.getElementById('btn-decode');
    const btnClear = document.getElementById('btn-clear');
    const btnCopy = document.getElementById('btn-copy');

    btnEncode.addEventListener('click', () => {
        const val = inputText.value;
        try {
            outputText.value = encodeURIComponent(val);
        } catch(e) {
            outputText.value = "Error encoding URL";
        }
    });

    btnDecode.addEventListener('click', () => {
        const val = inputText.value;
        try {
            outputText.value = decodeURIComponent(val);
        } catch(e) {
            outputText.value = "Error decoding URL (invalid format)";
        }
    });

    btnClear.addEventListener('click', () => {
        inputText.value = '';
        outputText.value = '';
        inputText.focus();
    });

    btnCopy.addEventListener('click', async () => {
        if (!outputText.value) return;
        const originalText = btnCopy.innerHTML;
        try {
            await navigator.clipboard.writeText(outputText.value);
            btnCopy.innerHTML = '<i data-lucide="check" class="w-3.5 h-3.5"></i> Copied!';
            lucide.createIcons();
            setTimeout(() => {
                btnCopy.innerHTML = originalText;
                lucide.createIcons();
            }, 2000);
        } catch (err) {
            alert('Failed to copy text.');
        }
    });
});
</script>

<?php require_once dirname(dirname(dirname(__DIR__))) . '/includes/footer.php'; ?>
