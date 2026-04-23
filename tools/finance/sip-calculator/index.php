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
                    <i data-lucide="trending-up" class="w-5 h-5"></i>
                    <span class="text-sm font-medium">Compound Power</span>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Tool Area -->
<section class="pb-24 bg-slate-50 dark:bg-gray-950 transition-colors">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
            
            <!-- Calculator Input -->
            <div class="lg:col-span-5 bg-white dark:bg-gray-900 rounded-[2.5rem] p-8 md:p-10 border border-slate-200 dark:border-gray-800 shadow-xl">
                <div class="space-y-8">
                    <div>
                        <div class="flex justify-between mb-4">
                            <label class="text-xs font-black uppercase tracking-widest text-slate-400">Monthly Investment</label>
                            <span class="text-sm font-black text-indigo-600 dark:text-indigo-400">₹<span id="label-amount">5000</span></span>
                        </div>
                        <input type="range" id="range-amount" min="500" max="100000" step="500" value="5000" class="w-full h-2 bg-slate-100 dark:bg-gray-800 rounded-lg appearance-none cursor-pointer accent-indigo-600">
                    </div>

                    <div>
                        <div class="flex justify-between mb-4">
                            <label class="text-xs font-black uppercase tracking-widest text-slate-400">Expected Return Rate (p.a)</label>
                            <span class="text-sm font-black text-indigo-600 dark:text-indigo-400"><span id="label-rate">12</span>%</span>
                        </div>
                        <input type="range" id="range-rate" min="1" max="30" step="0.5" value="12" class="w-full h-2 bg-slate-100 dark:bg-gray-800 rounded-lg appearance-none cursor-pointer accent-indigo-600">
                    </div>

                    <div>
                        <div class="flex justify-between mb-4">
                            <label class="text-xs font-black uppercase tracking-widest text-slate-400">Time Period (Years)</label>
                            <span class="text-sm font-black text-indigo-600 dark:text-indigo-400"><span id="label-years">10</span>Y</span>
                        </div>
                        <input type="range" id="range-years" min="1" max="40" step="1" value="10" class="w-full h-2 bg-slate-100 dark:bg-gray-800 rounded-lg appearance-none cursor-pointer accent-indigo-600">
                    </div>
                </div>
            </div>

            <!-- Results Display -->
            <div class="lg:col-span-7 space-y-6">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div class="bg-white dark:bg-gray-900 p-6 rounded-3xl border border-slate-200 dark:border-gray-800 shadow-sm">
                        <p class="text-[10px] font-black uppercase tracking-widest text-slate-400 mb-2">Invested Amount</p>
                        <p class="text-xl font-black text-slate-900 dark:text-white">₹<span id="res-invested">0</span></p>
                    </div>
                    <div class="bg-white dark:bg-gray-900 p-6 rounded-3xl border border-slate-200 dark:border-gray-800 shadow-sm">
                        <p class="text-[10px] font-black uppercase tracking-widest text-slate-400 mb-2">Est. Returns</p>
                        <p class="text-xl font-black text-emerald-500">₹<span id="res-returns">0</span></p>
                    </div>
                    <div class="bg-indigo-600 p-6 rounded-3xl shadow-lg shadow-indigo-500/20">
                        <p class="text-[10px] font-black uppercase tracking-widest text-indigo-100/60 mb-2">Total Value</p>
                        <p class="text-xl font-black text-white">₹<span id="res-total">0</span></p>
                    </div>
                </div>

                <!-- Visual Chart (Simplified) -->
                <div class="bg-white dark:bg-gray-900 rounded-[2.5rem] p-8 md:p-12 border border-slate-200 dark:border-gray-800 shadow-xl flex flex-col items-center">
                    <div class="w-full flex items-end justify-center gap-4 h-48 mb-8 border-b border-slate-100 dark:border-gray-800 pb-2">
                        <div class="flex flex-col items-center gap-2 w-24">
                            <div id="bar-invested" class="w-full bg-slate-200 dark:bg-gray-800 rounded-t-xl transition-all duration-500" style="height: 40%"></div>
                            <span class="text-[9px] font-bold text-slate-400 uppercase">Invested</span>
                        </div>
                        <div class="flex flex-col items-center gap-2 w-24">
                            <div id="bar-total" class="w-full bg-indigo-600 rounded-t-xl transition-all duration-500" style="height: 100%"></div>
                            <span class="text-[9px] font-bold text-slate-400 uppercase">Total</span>
                        </div>
                    </div>
                    
                    <div class="text-center">
                        <h4 class="text-sm font-black text-slate-900 dark:text-white mb-2">Wealth Breakdown</h4>
                        <p class="text-xs text-slate-500 dark:text-gray-400 leading-relaxed">In <span class="font-bold text-indigo-500" id="info-years">10</span> years, your wealth will grow by <span class="font-bold text-emerald-500" id="info-growth">0</span>%</p>
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
    const rangeAmount = document.getElementById('range-amount');
    const rangeRate = document.getElementById('range-rate');
    const rangeYears = document.getElementById('range-years');

    const labelAmount = document.getElementById('label-amount');
    const labelRate = document.getElementById('label-rate');
    const labelYears = document.getElementById('label-years');

    const resInvested = document.getElementById('res-invested');
    const resReturns = document.getElementById('res-returns');
    const resTotal = document.getElementById('res-total');

    const barInvested = document.getElementById('bar-invested');
    const barTotal = document.getElementById('bar-total');
    const infoYears = document.getElementById('info-years');
    const infoGrowth = document.getElementById('info-growth');

    function calculate() {
        const P = parseFloat(rangeAmount.value);
        const annualRate = parseFloat(rangeRate.value);
        const years = parseFloat(rangeYears.value);

        const i = (annualRate / 100) / 12;
        const n = years * 12;

        // SIP Formula: M = P × ({[1 + i]^n – 1} / i) × (1 + i)
        const totalValue = P * ((Math.pow(1 + i, n) - 1) / i) * (1 + i);
        const investedAmount = P * n;
        const estReturns = totalValue - investedAmount;

        // Update Labels
        labelAmount.textContent = P.toLocaleString('en-IN');
        labelRate.textContent = annualRate;
        labelYears.textContent = years;

        // Update Results
        resInvested.textContent = Math.round(investedAmount).toLocaleString('en-IN');
        resReturns.textContent = Math.round(estReturns).toLocaleString('en-IN');
        resTotal.textContent = Math.round(totalValue).toLocaleString('en-IN');

        // Update Visuals
        const investedPercent = (investedAmount / totalValue) * 100;
        barInvested.style.height = investedPercent + '%';
        barTotal.style.height = '100%';
        
        infoYears.textContent = years;
        infoGrowth.textContent = Math.round((estReturns / investedAmount) * 100);
    }

    [rangeAmount, rangeRate, rangeYears].forEach(el => el.addEventListener('input', calculate));
    calculate();
</script>

<?php require_once '../../../includes/footer.php'; ?>
