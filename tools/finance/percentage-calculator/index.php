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
                        <a href="<?php echo SITE_URL; ?>#finance" class="hover:text-white">Financial Tools</a>
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
                <div class="px-4 py-2 rounded-xl bg-indigo-500/10 border border-indigo-500/20 flex items-center gap-2 text-indigo-600 dark:text-indigo-400 shadow-lg shadow-indigo-500/5 transition-all">
                    <i data-lucide="percent" class="w-5 h-5"></i>
                    <span class="text-sm font-medium">Fast Math</span>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Tool Area -->
<section class="pb-24 bg-slate-50 dark:bg-gray-950 transition-colors">
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            
            <!-- Type 1: What is X% of Y? -->
            <div class="bg-white dark:bg-gray-900 rounded-[2.5rem] p-8 border border-slate-200 dark:border-gray-800 shadow-xl relative overflow-hidden group">
                <div class="absolute top-0 right-0 w-32 h-32 bg-indigo-500/5 rounded-full blur-3xl -mr-10 -mt-10 group-hover:bg-indigo-500/10 transition-colors"></div>
                <h3 class="text-xl font-bold text-slate-900 dark:text-white mb-6 flex items-center gap-2">
                    <span class="w-8 h-8 rounded-lg bg-indigo-500/10 text-indigo-500 flex items-center justify-center text-xs font-black">01</span>
                    Basic Percentage
                </h3>
                
                <div class="space-y-4">
                    <div class="flex items-center gap-3">
                        <span class="text-sm font-bold text-slate-500 uppercase tracking-widest w-12 text-center">What is</span>
                        <input type="number" id="p1-x" placeholder="10" class="flex-1 px-4 py-3 bg-slate-50 dark:bg-gray-800 border-2 border-transparent focus:border-indigo-500 rounded-xl text-slate-900 dark:text-white font-bold transition-all outline-none">
                        <span class="text-sm font-black text-slate-400">%</span>
                    </div>
                    <div class="flex items-center gap-3">
                        <span class="text-sm font-bold text-slate-500 uppercase tracking-widest w-12 text-center">of</span>
                        <input type="number" id="p1-y" placeholder="100" class="flex-1 px-4 py-3 bg-slate-50 dark:bg-gray-800 border-2 border-transparent focus:border-indigo-500 rounded-xl text-slate-900 dark:text-white font-bold transition-all outline-none">
                    </div>
                    
                    <div class="mt-8 pt-8 border-t border-slate-100 dark:border-gray-800">
                        <p class="text-[10px] font-black uppercase tracking-widest text-slate-400 mb-2">Result</p>
                        <p class="text-4xl font-black text-indigo-500"><span id="p1-res">0</span></p>
                    </div>
                </div>
            </div>

            <!-- Type 2: X is what % of Y? -->
            <div class="bg-white dark:bg-gray-900 rounded-[2.5rem] p-8 border border-slate-200 dark:border-gray-800 shadow-xl relative overflow-hidden group">
                <div class="absolute top-0 right-0 w-32 h-32 bg-purple-500/5 rounded-full blur-3xl -mr-10 -mt-10 group-hover:bg-purple-500/10 transition-colors"></div>
                <h3 class="text-xl font-bold text-slate-900 dark:text-white mb-6 flex items-center gap-2">
                    <span class="w-8 h-8 rounded-lg bg-purple-500/10 text-purple-500 flex items-center justify-center text-xs font-black">02</span>
                    Percentage Of
                </h3>
                
                <div class="space-y-4">
                    <div class="flex items-center gap-3">
                        <input type="number" id="p2-x" placeholder="20" class="flex-1 px-4 py-3 bg-slate-50 dark:bg-gray-800 border-2 border-transparent focus:border-purple-500 rounded-xl text-slate-900 dark:text-white font-bold transition-all outline-none">
                        <span class="text-sm font-bold text-slate-500 uppercase tracking-widest w-12 text-center">is what</span>
                        <span class="text-sm font-black text-slate-400">%</span>
                    </div>
                    <div class="flex items-center gap-3">
                        <span class="text-sm font-bold text-slate-500 uppercase tracking-widest w-12 text-center">of</span>
                        <input type="number" id="p2-y" placeholder="200" class="flex-1 px-4 py-3 bg-slate-50 dark:bg-gray-800 border-2 border-transparent focus:border-purple-500 rounded-xl text-slate-900 dark:text-white font-bold transition-all outline-none">
                    </div>
                    
                    <div class="mt-8 pt-8 border-t border-slate-100 dark:border-gray-800">
                        <p class="text-[10px] font-black uppercase tracking-widest text-slate-400 mb-2">Result</p>
                        <p class="text-4xl font-black text-purple-500"><span id="p2-res">0</span>%</p>
                    </div>
                </div>
            </div>

            <!-- Type 3: Percentage Increase/Decrease -->
            <div class="bg-white dark:bg-gray-900 rounded-[2.5rem] p-8 border border-slate-200 dark:border-gray-800 shadow-xl relative overflow-hidden group md:col-span-2">
                <div class="absolute top-0 right-0 w-64 h-64 bg-emerald-500/5 rounded-full blur-3xl -mr-20 -mt-20 group-hover:bg-emerald-500/10 transition-colors"></div>
                <h3 class="text-xl font-bold text-slate-900 dark:text-white mb-6 flex items-center gap-2">
                    <span class="w-8 h-8 rounded-lg bg-emerald-500/10 text-emerald-500 flex items-center justify-center text-xs font-black">03</span>
                    Percentage Change (Increase/Decrease)
                </h3>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8 items-end">
                    <div class="space-y-4">
                        <div class="flex items-center gap-3">
                            <span class="text-sm font-bold text-slate-500 uppercase tracking-widest w-24">Initial Value</span>
                            <input type="number" id="p3-x" placeholder="100" class="flex-1 px-4 py-3 bg-slate-50 dark:bg-gray-800 border-2 border-transparent focus:border-emerald-500 rounded-xl text-slate-900 dark:text-white font-bold transition-all outline-none">
                        </div>
                        <div class="flex items-center gap-3">
                            <span class="text-sm font-bold text-slate-500 uppercase tracking-widest w-24">Final Value</span>
                            <input type="number" id="p3-y" placeholder="150" class="flex-1 px-4 py-3 bg-slate-50 dark:bg-gray-800 border-2 border-transparent focus:border-emerald-500 rounded-xl text-slate-900 dark:text-white font-bold transition-all outline-none">
                        </div>
                    </div>
                    
                    <div class="bg-slate-50 dark:bg-gray-800/50 p-6 rounded-3xl border border-slate-100 dark:border-gray-800">
                        <p class="text-[10px] font-black uppercase tracking-widest text-slate-400 mb-2">Percentage Change</p>
                        <div class="flex items-center gap-4">
                            <p class="text-5xl font-black text-emerald-500"><span id="p3-res">0</span>%</p>
                            <div id="p3-badge" class="px-3 py-1 rounded-full text-[10px] font-black uppercase tracking-widest bg-emerald-500/10 text-emerald-500 hidden">Increase</div>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <!-- SEO Content -->
        <div class="mt-20 prose prose-slate dark:prose-invert max-w-none">
            <div class="p-8 md:p-12 rounded-[3rem] bg-white dark:bg-gray-900 border border-slate-200 dark:border-gray-800 shadow-sm relative overflow-hidden">
                <div class="absolute top-0 right-0 w-64 h-64 bg-indigo-500/5 rounded-full blur-3xl -mr-20 -mt-20"></div>
                <div class="relative z-10">
                    <?php echo $tool['seo_text']; ?>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
    // Tool 1
    const p1x = document.getElementById('p1-x');
    const p1y = document.getElementById('p1-y');
    const p1res = document.getElementById('p1-res');

    function calc1() {
        const x = parseFloat(p1x.value) || 0;
        const y = parseFloat(p1y.value) || 0;
        p1res.textContent = ((x / 100) * y).toLocaleString(undefined, {maximumFractionDigits: 2});
    }
    p1x.addEventListener('input', calc1);
    p1y.addEventListener('input', calc1);

    // Tool 2
    const p2x = document.getElementById('p2-x');
    const p2y = document.getElementById('p2-y');
    const p2res = document.getElementById('p2-res');

    function calc2() {
        const x = parseFloat(p2x.value) || 0;
        const y = parseFloat(p2y.value) || 0;
        if (y === 0) { p2res.textContent = '0'; return; }
        p2res.textContent = ((x / y) * 100).toLocaleString(undefined, {maximumFractionDigits: 2});
    }
    p2x.addEventListener('input', calc2);
    p2y.addEventListener('input', calc2);

    // Tool 3
    const p3x = document.getElementById('p3-x');
    const p3y = document.getElementById('p3-y');
    const p3res = document.getElementById('p3-res');
    const p3badge = document.getElementById('p3-badge');

    function calc3() {
        const x = parseFloat(p3x.value) || 0;
        const y = parseFloat(p3y.value) || 0;
        if (x === 0) { p3res.textContent = '0'; p3badge.classList.add('hidden'); return; }
        
        const change = ((y - x) / x) * 100;
        p3res.textContent = Math.abs(change).toLocaleString(undefined, {maximumFractionDigits: 2});
        
        p3badge.classList.remove('hidden');
        if (change > 0) {
            p3badge.textContent = 'Increase';
            p3badge.className = 'px-3 py-1 rounded-full text-[10px] font-black uppercase tracking-widest bg-emerald-500/10 text-emerald-500';
            p3res.className = 'text-5xl font-black text-emerald-500';
        } else if (change < 0) {
            p3badge.textContent = 'Decrease';
            p3badge.className = 'px-3 py-1 rounded-full text-[10px] font-black uppercase tracking-widest bg-rose-500/10 text-rose-500';
            p3res.className = 'text-5xl font-black text-rose-500';
        } else {
            p3badge.classList.add('hidden');
            p3res.className = 'text-5xl font-black text-slate-400';
        }
    }
    p3x.addEventListener('input', calc3);
    p3y.addEventListener('input', calc3);
</script>

<?php require_once '../../../includes/footer.php'; ?>
