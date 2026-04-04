<?php
require_once dirname(dirname(dirname(__DIR__))) . '/includes/header.php';
$tool_id = 'password-generator';
$cat_id = 'sec';
$tool = $TOOL_CATEGORIES[$cat_id]['tools'][$tool_id];
?>

<div class="pt-24 pb-12 bg-slate-50 dark:bg-gray-950 min-h-screen">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
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
            <p class="text-lg text-slate-600 dark:text-gray-400 max-w-2xl mx-auto"><?php echo $tool['desc']; ?> Passwords are generated securely in your browser and are never sent to the server.</p>
        </div>

        <div class="glass-card rounded-3xl p-8 md:p-12 animate-fade-in shadow-xl dark:shadow-none" style="animation-delay: 0.1s">
            
            <!-- Output Area -->
            <div class="relative mb-10 group">
                <input type="text" id="password-output" class="w-full bg-slate-100 dark:bg-gray-900 border border-slate-200 dark:border-gray-800 text-slate-900 dark:text-white text-3xl font-mono p-6 rounded-2xl text-center focus:outline-none focus:ring-2 focus:ring-indigo-500 cursor-text" readonly>
                <div class="absolute inset-y-0 right-4 flex items-center gap-2">
                    <button id="btn-copy" class="p-3 bg-white dark:bg-gray-800 rounded-xl text-slate-600 dark:text-gray-300 hover:text-indigo-600 dark:hover:text-indigo-400 shadow-sm border border-slate-200 dark:border-gray-700 transition" title="Copy Password">
                        <i data-lucide="copy" class="w-5 h-5"></i>
                    </button>
                    <button id="btn-generate" class="p-3 bg-indigo-600 text-white rounded-xl hover:bg-indigo-500 shadow-lg shadow-indigo-600/30 transition group-hover:rotate-180 duration-500" title="Generate New">
                        <i data-lucide="refresh-cw" class="w-5 h-5"></i>
                    </button>
                </div>
            </div>

            <!-- Settings -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-10">
                
                <!-- Length Slider -->
                <div>
                    <div class="flex justify-between items-center mb-4">
                        <label class="text-slate-900 dark:text-white font-bold text-lg">Password Length</label>
                        <span id="length-val" class="px-3 py-1 bg-indigo-50 dark:bg-indigo-500/20 text-indigo-600 dark:text-indigo-400 text-sm font-bold rounded-lg border border-indigo-100 dark:border-transparent">16</span>
                    </div>
                    <input type="range" id="length-slider" min="6" max="64" value="16" class="w-full h-2 bg-slate-200 dark:bg-gray-800 rounded-lg appearance-none cursor-pointer accent-indigo-600 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                    <div class="flex justify-between text-xs text-slate-400 dark:text-gray-500 mt-2 font-medium">
                        <span>6</span>
                        <span>64</span>
                    </div>
                </div>

                <!-- Checkboxes -->
                <div class="space-y-4">
                    <label class="flex items-center gap-3 cursor-pointer group">
                        <div class="relative flex items-center justify-center w-6 h-6">
                            <input type="checkbox" id="chk-uppercase" class="peer sr-only" checked>
                            <div class="w-6 h-6 bg-white dark:bg-gray-900 border-2 border-slate-300 dark:border-gray-700 rounded peer-checked:bg-indigo-600 peer-checked:border-indigo-600 transition"></div>
                            <i data-lucide="check" class="absolute w-4 h-4 text-white opacity-0 peer-checked:opacity-100 transition pointer-events-none"></i>
                        </div>
                        <span class="text-slate-700 dark:text-gray-300 font-medium group-hover:text-slate-900 dark:group-hover:text-white transition">Uppercase (A-Z)</span>
                    </label>

                    <label class="flex items-center gap-3 cursor-pointer group">
                        <div class="relative flex items-center justify-center w-6 h-6">
                            <input type="checkbox" id="chk-lowercase" class="peer sr-only" checked>
                            <div class="w-6 h-6 bg-white dark:bg-gray-900 border-2 border-slate-300 dark:border-gray-700 rounded peer-checked:bg-indigo-600 peer-checked:border-indigo-600 transition"></div>
                            <i data-lucide="check" class="absolute w-4 h-4 text-white opacity-0 peer-checked:opacity-100 transition pointer-events-none"></i>
                        </div>
                        <span class="text-slate-700 dark:text-gray-300 font-medium group-hover:text-slate-900 dark:group-hover:text-white transition">Lowercase (a-z)</span>
                    </label>

                    <label class="flex items-center gap-3 cursor-pointer group">
                        <div class="relative flex items-center justify-center w-6 h-6">
                            <input type="checkbox" id="chk-numbers" class="peer sr-only" checked>
                            <div class="w-6 h-6 bg-white dark:bg-gray-900 border-2 border-slate-300 dark:border-gray-700 rounded peer-checked:bg-indigo-600 peer-checked:border-indigo-600 transition"></div>
                            <i data-lucide="check" class="absolute w-4 h-4 text-white opacity-0 peer-checked:opacity-100 transition pointer-events-none"></i>
                        </div>
                        <span class="text-slate-700 dark:text-gray-300 font-medium group-hover:text-slate-900 dark:group-hover:text-white transition">Numbers (0-9)</span>
                    </label>

                    <label class="flex items-center gap-3 cursor-pointer group">
                        <div class="relative flex items-center justify-center w-6 h-6">
                            <input type="checkbox" id="chk-symbols" class="peer sr-only" checked>
                            <div class="w-6 h-6 bg-white dark:bg-gray-900 border-2 border-slate-300 dark:border-gray-700 rounded peer-checked:bg-indigo-600 peer-checked:border-indigo-600 transition"></div>
                            <i data-lucide="check" class="absolute w-4 h-4 text-white opacity-0 peer-checked:opacity-100 transition pointer-events-none"></i>
                        </div>
                        <span class="text-slate-700 dark:text-gray-300 font-medium group-hover:text-slate-900 dark:group-hover:text-white transition">Symbols (!@#$%)</span>
                    </label>
                </div>
            </div>
            
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', () => {
    const passwordOutput = document.getElementById('password-output');
    const lengthSlider = document.getElementById('length-slider');
    const lengthVal = document.getElementById('length-val');
    const chkUpper = document.getElementById('chk-uppercase');
    const chkLower = document.getElementById('chk-lowercase');
    const chkNumbers = document.getElementById('chk-numbers');
    const chkSymbols = document.getElementById('chk-symbols');
    const btnGenerate = document.getElementById('btn-generate');
    const btnCopy = document.getElementById('btn-copy');

    const UPPER = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
    const LOWER = 'abcdefghijklmnopqrstuvwxyz';
    const NUMBERS = '0123456789';
    const SYMBOLS = '!@#$%^&*()_+~`|}{[]:;?><,./-=';

    function generatePassword() {
        let chars = '';
        if (chkUpper.checked) chars += UPPER;
        if (chkLower.checked) chars += LOWER;
        if (chkNumbers.checked) chars += NUMBERS;
        if (chkSymbols.checked) chars += SYMBOLS;

        // Fallback if nothing checked
        if (chars === '') {
            chkLower.checked = true;
            chars += LOWER;
        }

        const length = parseInt(lengthSlider.value);
        let password = '';
        
        // Use crypto for better randomness
        const array = new Uint32Array(length);
        window.crypto.getRandomValues(array);
        
        for (let i = 0; i < length; i++) {
            password += chars[array[i] % chars.length];
        }

        passwordOutput.value = password;
    }

    // Attach listeners
    lengthSlider.addEventListener('input', (e) => {
        lengthVal.innerText = e.target.value;
        generatePassword();
    });

    [chkUpper, chkLower, chkNumbers, chkSymbols].forEach(chk => {
        chk.addEventListener('change', generatePassword);
    });

    btnGenerate.addEventListener('click', generatePassword);

    btnCopy.addEventListener('click', async () => {
        if (!passwordOutput.value) return;
        const icon = btnCopy.querySelector('i');
        try {
            await navigator.clipboard.writeText(passwordOutput.value);
            icon.setAttribute('data-lucide', 'check');
            lucide.createIcons();
            setTimeout(() => {
                icon.setAttribute('data-lucide', 'copy');
                lucide.createIcons();
            }, 2000);
        } catch (err) {
            alert('Failed to copy password.');
        }
    });

    // Generate initial password
    generatePassword();
});
</script>

<?php require_once dirname(dirname(dirname(__DIR__))) . '/includes/footer.php'; ?>
