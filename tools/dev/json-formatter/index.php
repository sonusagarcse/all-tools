<?php
require_once dirname(dirname(dirname(__DIR__))) . '/includes/header.php';
$tool_id = 'json-formatter';
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
            <p class="text-lg text-slate-600 dark:text-gray-400 max-w-2xl"><?php echo $tool['desc']; ?> processed completely in your browser for total privacy.</p>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 animate-fade-in" style="animation-delay: 0.1s">
            <!-- Input Area -->
            <div class="glass-card rounded-2xl p-6 flex flex-col h-[600px]">
                <div class="flex items-center justify-between mb-4">
                    <h2 class="text-lg font-bold text-slate-900 dark:text-white flex items-center gap-2">
                        <i data-lucide="code" class="w-5 h-5 text-indigo-500"></i> Input JSON
                    </h2>
                    <div class="flex gap-2">
                        <button id="btn-clear" class="px-3 py-1.5 text-xs font-semibold rounded-lg bg-slate-100 dark:bg-gray-800 text-slate-600 dark:text-gray-400 hover:bg-slate-200 dark:hover:bg-gray-700 transition">Clear</button>
                        <button id="btn-paste" class="px-3 py-1.5 text-xs font-semibold rounded-lg bg-indigo-50 dark:bg-indigo-500/10 text-indigo-600 dark:text-indigo-400 hover:bg-indigo-100 dark:hover:bg-indigo-500/20 transition flex items-center gap-1">
                            <i data-lucide="clipboard" class="w-3.5 h-3.5"></i> Paste
                        </button>
                    </div>
                </div>
                <!-- Line numbered simple textarea or just textarea for simplicity. Let's use a standard textarea styled well -->
                <textarea id="json-input" class="w-full h-full flex-grow p-4 rounded-xl font-mono text-sm resize-none focus:ring-2 focus:ring-indigo-500" placeholder='{"welcome": "Paste your JSON here to format it."}'></textarea>
                
                <!-- Status/Error Output -->
                <div id="error-msg" class="mt-4 text-red-500 text-sm font-medium hidden flex items-center gap-2">
                    <i data-lucide="alert-circle" class="w-4 h-4"></i> <span>Invalid JSON format</span>
                </div>
            </div>

            <!-- Output Area -->
            <div class="glass-card rounded-2xl p-6 flex flex-col h-[600px]">
                <div class="flex items-center justify-between mb-4">
                    <h2 class="text-lg font-bold text-slate-900 dark:text-white flex items-center gap-2">
                        <i data-lucide="check-circle" class="w-5 h-5 text-green-500"></i> Formatted Output
                    </h2>
                    <div class="flex gap-2">
                        <select id="indent-select" class="px-3 py-1.5 text-xs font-semibold rounded-lg bg-slate-100 dark:bg-gray-800 text-slate-600 dark:text-gray-400 border-none focus:ring-2 focus:ring-indigo-500 text-center">
                            <option value="2">2 Spaces</option>
                            <option value="4">4 Spaces</option>
                            <option value="\t">Tabs</option>
                            <option value="0">Minify</option>
                        </select>
                        <button id="btn-copy" class="px-3 py-1.5 text-xs font-semibold rounded-lg bg-indigo-600 text-white hover:bg-indigo-500 transition shadow-lg shadow-indigo-500/20 flex items-center gap-1">
                            <i data-lucide="copy" class="w-3.5 h-3.5"></i> Copy Result
                        </button>
                    </div>
                </div>
                <textarea id="json-output" class="w-full h-full flex-grow p-4 rounded-xl font-mono text-sm resize-none focus:ring-2 focus:ring-indigo-500 bg-slate-100 dark:bg-gray-900 border-none" readonly placeholder="Result will appear here..."></textarea>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', () => {
    const jsonInput = document.getElementById('json-input');
    const jsonOutput = document.getElementById('json-output');
    const btnClear = document.getElementById('btn-clear');
    const btnPaste = document.getElementById('btn-paste');
    const btnCopy = document.getElementById('btn-copy');
    const indentSelect = document.getElementById('indent-select');
    const errorMsg = document.getElementById('error-msg');
    
    function processJSON() {
        const val = jsonInput.value.trim();
        if (!val) {
            jsonOutput.value = '';
            errorMsg.classList.add('hidden');
            jsonInput.classList.remove('border-red-500', 'focus:ring-red-500');
            return;
        }

        try {
            const parsed = JSON.parse(val);
            let indent = indentSelect.value;
            if (indent === "0") {
                jsonOutput.value = JSON.stringify(parsed);
            } else if (indent === "2" || indent === "4") {
                jsonOutput.value = JSON.stringify(parsed, null, parseInt(indent));
            } else {
                jsonOutput.value = JSON.stringify(parsed, null, '\t');
            }
            
            errorMsg.classList.add('hidden');
            jsonInput.classList.remove('border-red-500', 'focus:ring-red-500');
            jsonInput.classList.add('border-green-500');
            setTimeout(() => jsonInput.classList.remove('border-green-500'), 1500);
        } catch (e) {
            errorMsg.querySelector('span').innerText = e.message;
            errorMsg.classList.remove('hidden');
            jsonInput.classList.add('border-red-500', 'focus:ring-red-500');
        }
    }

    jsonInput.addEventListener('input', processJSON);
    indentSelect.addEventListener('change', processJSON);

    btnClear.addEventListener('click', () => {
        jsonInput.value = '';
        processJSON();
        jsonInput.focus();
    });

    btnPaste.addEventListener('click', async () => {
        try {
            const text = await navigator.clipboard.readText();
            jsonInput.value = text;
            processJSON();
        } catch (err) {
            alert('Failed to read clipboard.');
        }
    });

    btnCopy.addEventListener('click', async () => {
        if (!jsonOutput.value) return;
        const originalText = btnCopy.innerHTML;
        try {
            await navigator.clipboard.writeText(jsonOutput.value);
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
