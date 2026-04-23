<?php
require_once '../../../includes/header.php';
$tool = get_current_tool_info($_SERVER['REQUEST_URI']);
?>

<!-- Tool Header -->
<section class="pt-12 pb-8 bg-slate-50 dark:bg-gray-950 transition-colors">
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
                        <span class="text-slate-500 dark:text-gray-300"><?php echo $tool['name']; ?></span>
                    </div>
                </li>
            </ol>
        </nav>

        <div class="flex flex-col md:flex-row md:items-end justify-between gap-6 mb-12">
            <div class="max-w-2xl">
                <h1 class="text-3xl md:text-5xl font-heading font-extrabold text-slate-900 dark:text-white mb-4"><?php echo $tool['name']; ?></h1>
                <p class="text-slate-600 dark:text-gray-400 text-lg leading-relaxed"><?php echo $tool['desc']; ?></p>
            </div>
            <div class="flex gap-3">
                <div class="px-4 py-2 rounded-xl bg-sky-500/10 border border-sky-500/20 flex items-center gap-2 text-sky-600 dark:text-sky-400 shadow-lg shadow-sky-500/5 transition-all">
                    <i data-lucide="code" class="w-5 h-5"></i>
                    <span class="text-sm font-medium">Safe Encoding</span>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Tool Area -->
<section class="pb-24 bg-slate-50 dark:bg-gray-950 transition-colors">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            
            <!-- Encoder -->
            <div class="bg-white dark:bg-gray-900 rounded-[2.5rem] p-8 md:p-10 border border-slate-200 dark:border-gray-800 shadow-xl flex flex-col h-full">
                <label class="block text-[10px] font-black uppercase tracking-widest text-slate-400 mb-6">Input Content</label>
                <textarea id="input-text" placeholder="Enter text or HTML here..." class="flex-grow w-full px-6 py-4 bg-slate-50 dark:bg-gray-800 border-2 border-transparent focus:border-sky-500 rounded-2xl text-slate-900 dark:text-white font-mono text-sm transition-all outline-none min-h-[300px] mb-6"></textarea>
                
                <div class="grid grid-cols-2 gap-4">
                    <button onclick="process('encode')" class="py-4 bg-sky-600 hover:bg-sky-500 text-white rounded-2xl font-black uppercase tracking-widest shadow-xl shadow-sky-500/20 active:scale-95 transition-all flex items-center justify-center gap-2">
                        <i data-lucide="lock" class="w-4 h-4"></i> Encode
                    </button>
                    <button onclick="process('decode')" class="py-4 bg-slate-100 dark:bg-gray-800 hover:bg-slate-200 dark:hover:bg-gray-700 text-slate-900 dark:text-white rounded-2xl font-black uppercase tracking-widest active:scale-95 transition-all flex items-center justify-center gap-2">
                        <i data-lucide="unlock" class="w-4 h-4"></i> Decode
                    </button>
                </div>
            </div>

            <!-- Output -->
            <div class="bg-slate-900 rounded-[2.5rem] p-8 md:p-10 shadow-2xl flex flex-col h-full relative group">
                <div class="flex items-center justify-between mb-6">
                    <span class="text-[10px] font-black uppercase tracking-widest text-sky-400">Result</span>
                    <button onclick="copyOutput()" class="p-2.5 rounded-xl bg-white/5 hover:bg-white/10 text-white transition-all">
                        <i data-lucide="copy" class="w-4 h-4"></i>
                    </button>
                </div>
                <textarea id="output-text" readonly placeholder="Result will appear here..." class="flex-grow w-full px-6 py-4 bg-white/5 border-2 border-transparent rounded-2xl text-sky-100 font-mono text-sm transition-all outline-none min-h-[300px]"></textarea>
            </div>

        </div>

        <!-- SEO Content -->
        <div class="mt-20 prose prose-slate dark:prose-invert max-w-none">
            <div class="p-8 md:p-12 rounded-[3rem] bg-white dark:bg-gray-900 border border-slate-200 dark:border-gray-800 shadow-sm relative overflow-hidden">
                <div class="absolute top-0 right-0 w-64 h-64 bg-sky-500/5 rounded-full blur-3xl -mr-20 -mt-20"></div>
                <div class="relative z-10">
                    <?php echo $tool['seo_text']; ?>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
    const input = document.getElementById('input-text');
    const output = document.getElementById('output-text');

    function process(mode) {
        const val = input.value;
        if (mode === 'encode') {
            const temp = document.createElement('div');
            temp.textContent = val;
            output.value = temp.innerHTML;
        } else {
            const temp = document.createElement('div');
            temp.innerHTML = val;
            output.value = temp.textContent;
        }
    }

    function copyOutput() {
        output.select();
        document.execCommand('copy');
        alert('Copied to clipboard!');
    }
</script>

<?php require_once '../../../includes/footer.php'; ?>
