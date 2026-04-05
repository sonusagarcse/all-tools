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
                        <a href="<?php echo SITE_URL; ?>#sec" class="hover:text-white">Security Tools</a>
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
                <button onclick="generateBcrypt()" id="btn-generate" class="px-6 py-3 rounded-2xl bg-orange-600 text-white font-bold hover:bg-orange-500 transition-all flex items-center gap-2 shadow-lg shadow-orange-600/20">
                    <i data-lucide="shield" class="w-5 h-5"></i> Generate Hash
                </button>
            </div>
        </div>
    </div>
</section>

<!-- Tool Area -->
<section class="pb-24 bg-gray-950">
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-5 gap-8">
            
            <!-- Main Content Area -->
            <div class="lg:col-span-3 space-y-6">
                <!-- Input String -->
                <div class="space-y-3">
                    <h3 class="text-white font-bold inline-flex items-center gap-2">
                        <i data-lucide="key" class="w-4 h-4 text-orange-400"></i> String to Hash
                    </h3>
                    <div class="relative">
                        <input type="text" id="input-string" class="w-full p-6 text-lg rounded-2xl bg-gray-900 border border-gray-800 text-white focus:outline-none focus:ring-2 focus:ring-orange-500 transition-all shadow-inner" placeholder="Enter your password/string here...">
                    </div>
                </div>

                <!-- Generated Hash -->
                <div class="space-y-3">
                    <h3 class="text-white font-bold inline-flex items-center gap-2">
                        <i data-lucide="lock" class="w-4 h-4 text-emerald-400"></i> Generated Bcrypt Hash
                    </h3>
                    <div class="relative">
                        <textarea id="output-hash" readonly class="w-full h-[120px] p-6 text-lg rounded-2xl bg-gray-900/50 border border-gray-800 text-emerald-400 font-mono focus:outline-none focus:ring-2 focus:ring-emerald-500 transition-all shadow-inner resize-none break-all" placeholder="$2a$..."></textarea>
                        
                        <button onclick="copyHash()" class="absolute top-4 right-4 p-2 rounded-xl bg-gray-800 text-gray-400 hover:text-white transition-all flex items-center gap-2" title="Copy Hash">
                            <i data-lucide="copy" class="w-5 h-5"></i>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Settings Sidebar -->
            <div class="lg:col-span-2 space-y-6">
                <div class="glass-card rounded-[32px] p-8">
                    <h3 class="text-white font-bold mb-6 flex items-center gap-2">
                        <i data-lucide="settings-2" class="w-5 h-5 text-orange-400"></i> Configuration
                    </h3>
                    
                    <div class="space-y-6">
                        <div>
                            <div class="flex justify-between items-center mb-4">
                                <label for="rounds" class="text-sm font-medium text-gray-300">Salt Rounds (Work Factor)</label>
                                <span id="rounds-val" class="text-lg font-black text-orange-400">10</span>
                            </div>
                            <input type="range" id="rounds" min="4" max="15" value="10" class="w-full h-2 bg-gray-800 rounded-lg appearance-none cursor-pointer accent-orange-500" oninput="document.getElementById('rounds-val').textContent = this.value">
                        </div>
                        <div class="p-4 rounded-xl bg-orange-500/10 border border-orange-500/20">
                            <p class="text-xs text-orange-400 leading-relaxed">
                                <i data-lucide="alert-triangle" class="w-4 h-4 inline mr-1"></i> Higher rounds increase computation time significantly. A value of 10 or 12 is recommended for modern security standards.
                            </p>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>

<!-- Include bcrypt.js from CDN -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/bcryptjs/2.4.3/bcrypt.min.js"></script>
<script>
    function generateBcrypt() {
        const inputStr = document.getElementById('input-string').value;
        const rounds = parseInt(document.getElementById('rounds').value);
        const outputEl = document.getElementById('output-hash');
        const btn = document.getElementById('btn-generate');
        
        if (!inputStr) {
            outputEl.value = '';
            alert("Please provide a string to hash.");
            return;
        }

        // Show generating state
        const originalText = btn.innerHTML;
        btn.innerHTML = `<i data-lucide="loader" class="w-5 h-5 animate-spin"></i> Generating...`;
        btn.classList.add('opacity-75', 'cursor-not-allowed');
        // Re-init icon
        if(window.lucide) window.lucide.createIcons();

        // Use setTimeout to allow UI to update before heavy synchronous computation
        setTimeout(() => {
            try {
                // Generate salt and hash
                const salt = dcodeIO.bcrypt.genSaltSync(rounds);
                const hash = dcodeIO.bcrypt.hashSync(inputStr, salt);
                
                outputEl.value = hash;
            } catch (err) {
                console.error(err);
                outputEl.value = "Error generating hash. Check console for details.";
            } finally {
                // Restore button
                btn.innerHTML = originalText;
                btn.classList.remove('opacity-75', 'cursor-not-allowed');
                if(window.lucide) window.lucide.createIcons();
            }
        }, 50);
    }

    function copyHash() {
        const output = document.getElementById('output-hash');
        if (!output.value) return;
        
        output.select();
        output.setSelectionRange(0, 99999);
        navigator.clipboard.writeText(output.value);
        alert("Hash copied to clipboard!");
    }
</script>

<?php require_once '../../../includes/footer.php'; ?>
