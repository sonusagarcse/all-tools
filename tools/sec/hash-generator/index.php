<?php
require_once dirname(dirname(dirname(__DIR__))) . '/includes/header.php';
$tool_id = 'hash-generator';
$cat_id = 'sec';
$tool = $TOOL_CATEGORIES[$cat_id]['tools'][$tool_id];
?>

<!-- Load CryptoJS for Hash functions -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/crypto-js/4.1.1/crypto-js.min.js"></script>

<div class="pt-24 pb-12 bg-slate-50 dark:bg-gray-950 min-h-screen">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Breadcrumb & Header -->
        <div class="mb-10 text-center animate-fade-in">
            <div class="flex items-center justify-center gap-2 text-sm font-medium text-slate-500 dark:text-gray-400 mb-4">
                <a href="<?php echo SITE_URL; ?>" class="hover:text-indigo-600 dark:hover:text-indigo-400 transition-colors">Home</a>
                <i data-lucide="chevron-right" class="w-4 h-4"></i>
                <a href="<?php echo SITE_URL; ?>#<?php echo $cat_id; ?>" class="hover:text-indigo-600 dark:hover:text-indigo-400 transition-colors"><?php echo $TOOL_CATEGORIES[$cat_id]['name']; ?></a>
                <i data-lucide="chevron-right" class="w-4 h-4"></i>
                <span class="text-slate-900 dark:text-white"><?php echo $tool['name']; ?></span>
            </div>
            <h1 class="text-4xl md:text-5xl font-heading font-extrabold text-slate-900 dark:text-white mb-4"><?php echo $tool['name']; ?></h1>
            <p class="text-lg text-slate-600 dark:text-gray-400 max-w-2xl mx-auto"><?php echo $tool['desc']; ?> Processed entirely in your browser. Complete privacy guaranteed.</p>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 animate-fade-in" style="animation-delay: 0.1s">
            
            <!-- Input Area -->
            <div class="glass-card rounded-3xl p-8 flex flex-col shadow-xl dark:shadow-none">
                <div class="flex items-center justify-between mb-4">
                    <h2 class="text-lg font-bold text-slate-900 dark:text-white flex items-center gap-2">
                        Text Input
                    </h2>
                    <button id="btn-clear" class="p-2 text-slate-400 hover:text-slate-600 dark:hover:text-white transition rounded-lg hover:bg-slate-100 dark:hover:bg-gray-800" title="Clear">
                        <i data-lucide="trash-2" class="w-5 h-5"></i>
                    </button>
                </div>
                <textarea id="text-input" class="w-full h-[300px] flex-grow p-5 rounded-2xl bg-white dark:bg-gray-900 border border-slate-200 dark:border-gray-800 text-slate-900 dark:text-white focus:ring-2 focus:ring-indigo-500 resize-none font-mono text-base" placeholder="Enter text here..."></textarea>
            </div>

            <!-- Hashes Area -->
            <div class="space-y-4 flex flex-col">
                
                <!-- Hash Item Template (Repeated for MD5, SHA1, SHA256) -->
                <div class="glass-card rounded-2xl p-6 shadow-md dark:shadow-none transition hover:border-indigo-500/50">
                    <div class="flex items-center justify-between mb-2">
                        <h3 class="text-md font-bold text-slate-800 dark:text-gray-200">MD5</h3>
                        <button class="btn-copy-hash text-indigo-600 dark:text-indigo-400 font-bold text-xs uppercase tracking-widest hover:text-indigo-800 dark:hover:text-indigo-300 flex items-center gap-1" data-target="hash-md5">
                            <i data-lucide="copy" class="w-3.5 h-3.5"></i> Copy
                        </button>
                    </div>
                    <input type="text" id="hash-md5" class="w-full bg-slate-100 dark:bg-gray-900 border-none text-slate-600 dark:text-gray-400 font-mono text-sm py-3 px-4 rounded-xl focus:ring-0 cursor-text" readonly value="">
                </div>

                <div class="glass-card rounded-2xl p-6 shadow-md dark:shadow-none transition hover:border-indigo-500/50">
                    <div class="flex items-center justify-between mb-2">
                        <h3 class="text-md font-bold text-slate-800 dark:text-gray-200">SHA-1</h3>
                        <button class="btn-copy-hash text-indigo-600 dark:text-indigo-400 font-bold text-xs uppercase tracking-widest hover:text-indigo-800 dark:hover:text-indigo-300 flex items-center gap-1" data-target="hash-sha1">
                            <i data-lucide="copy" class="w-3.5 h-3.5"></i> Copy
                        </button>
                    </div>
                    <input type="text" id="hash-sha1" class="w-full bg-slate-100 dark:bg-gray-900 border-none text-slate-600 dark:text-gray-400 font-mono text-sm py-3 px-4 rounded-xl focus:ring-0 cursor-text" readonly value="">
                </div>

                <div class="glass-card rounded-2xl p-6 shadow-md dark:shadow-none transition hover:border-indigo-500/50">
                    <div class="flex items-center justify-between mb-2">
                        <h3 class="text-md font-bold text-slate-800 dark:text-gray-200">SHA-256</h3>
                        <button class="btn-copy-hash text-indigo-600 dark:text-indigo-400 font-bold text-xs uppercase tracking-widest hover:text-indigo-800 dark:hover:text-indigo-300 flex items-center gap-1" data-target="hash-sha256">
                            <i data-lucide="copy" class="w-3.5 h-3.5"></i> Copy
                        </button>
                    </div>
                    <input type="text" id="hash-sha256" class="w-full bg-slate-100 dark:bg-gray-900 border-none text-slate-600 dark:text-gray-400 font-mono text-sm py-3 px-4 rounded-xl focus:ring-0 cursor-text" readonly value="">
                </div>

                <div class="glass-card rounded-2xl p-6 shadow-md dark:shadow-none transition hover:border-indigo-500/50">
                    <div class="flex items-center justify-between mb-2">
                        <h3 class="text-md font-bold text-slate-800 dark:text-gray-200">SHA-512</h3>
                        <button class="btn-copy-hash text-indigo-600 dark:text-indigo-400 font-bold text-xs uppercase tracking-widest hover:text-indigo-800 dark:hover:text-indigo-300 flex items-center gap-1" data-target="hash-sha512">
                            <i data-lucide="copy" class="w-3.5 h-3.5"></i> Copy
                        </button>
                    </div>
                    <input type="text" id="hash-sha512" class="w-full bg-slate-100 dark:bg-gray-900 border-none text-slate-600 dark:text-gray-400 font-mono text-sm py-3 px-4 rounded-xl focus:ring-0 cursor-text" readonly value="">
                </div>

            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', () => {
    const textInput = document.getElementById('text-input');
    const hashMd5 = document.getElementById('hash-md5');
    const hashSha1 = document.getElementById('hash-sha1');
    const hashSha256 = document.getElementById('hash-sha256');
    const hashSha512 = document.getElementById('hash-sha512');
    const btnClear = document.getElementById('btn-clear');
    const copyBtns = document.querySelectorAll('.btn-copy-hash');

    function updateHashes() {
        const val = textInput.value;
        if (!val) {
            hashMd5.value = '';
            hashSha1.value = '';
            hashSha256.value = '';
            hashSha512.value = '';
            return;
        }

        // Use CryptoJS
        hashMd5.value = CryptoJS.MD5(val).toString();
        hashSha1.value = CryptoJS.SHA1(val).toString();
        hashSha256.value = CryptoJS.SHA256(val).toString();
        hashSha512.value = CryptoJS.SHA512(val).toString();
    }

    textInput.addEventListener('input', updateHashes);
    
    btnClear.addEventListener('click', () => {
        textInput.value = '';
        updateHashes();
        textInput.focus();
    });

    copyBtns.forEach(btn => {
        btn.addEventListener('click', async () => {
            const targetId = btn.getAttribute('data-target');
            const inputField = document.getElementById(targetId);
            if (!inputField.value) return;
            
            const originalText = btn.innerHTML;
            try {
                await navigator.clipboard.writeText(inputField.value);
                btn.innerHTML = '<i data-lucide="check" class="w-3.5 h-3.5"></i> Copied!';
                lucide.createIcons();
                setTimeout(() => {
                    btn.innerHTML = originalText;
                    lucide.createIcons();
                }, 2000);
            } catch (err) {
                alert('Failed to copy hash.');
            }
        });
    });
});
</script>

<?php require_once dirname(dirname(dirname(__DIR__))) . '/includes/footer.php'; ?>
