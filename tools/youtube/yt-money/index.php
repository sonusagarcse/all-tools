<?php
require_once '../../../includes/header.php';
?>

<div class="max-w-4xl mx-auto px-4 py-6 md:py-12">
    <!-- Tool Header -->
    <div class="text-center mb-8 md:mb-12">
        <div class="inline-flex items-center justify-center w-12 h-12 md:w-16 md:h-16 rounded-2xl bg-red-600/10 text-red-600 mb-4">
            <i data-lucide="youtube" class="w-6 h-6 md:w-8 md:h-8"></i>
        </div>
        <h1 class="text-2xl md:text-4xl font-heading font-bold mb-3 px-2">YouTube Money Calculator</h1>
        <p class="text-sm md:text-base text-slate-600 dark:text-gray-400 max-w-2xl mx-auto px-4">
            Ever wondered how much you could earn on YouTube? Estimate your potential daily, monthly, and yearly revenue based on your views and industry RPM.
        </p>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
        <!-- Input Panel -->
        <div class="lg:col-span-5">
            <div class="glass rounded-3xl p-6 md:p-8 shadow-xl border border-slate-200 dark:border-gray-800">
                
                <!-- Daily Views Slider -->
                <div class="mb-8">
                    <div class="flex justify-between items-center mb-3">
                        <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Average Daily Views</label>
                        <span class="text-red-500 font-mono font-bold" id="view-display">50,000</span>
                    </div>
                    <input type="range" id="daily-views" min="100" max="1000000" step="100" value="50000" class="w-full h-2 bg-slate-100 dark:bg-gray-800 rounded-lg appearance-none cursor-pointer accent-red-600">
                    <div class="flex justify-between text-[8px] font-black text-slate-300 mt-2 uppercase">
                        <span>100</span>
                        <span>1M</span>
                    </div>
                </div>

                <!-- Estimated CPM Slider -->
                <div class="mb-10">
                    <div class="flex justify-between items-center mb-3">
                        <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Est. RPM ($)</label>
                        <span class="text-red-500 font-mono font-bold" id="cpm-display">$2.50</span>
                    </div>
                    <input type="range" id="est-cpm" min="0.10" max="25.00" step="0.10" value="2.50" class="w-full h-2 bg-slate-100 dark:bg-gray-800 rounded-lg appearance-none cursor-pointer accent-red-600">
                    <div class="flex justify-between text-[8px] font-black text-slate-300 mt-2 uppercase">
                        <span>$0.10</span>
                        <span>$25.00</span>
                    </div>
                </div>

                <div class="p-4 bg-red-50 dark:bg-red-900/10 rounded-2xl border border-red-100 dark:border-red-900/30">
                    <p class="text-[10px] text-red-600 dark:text-red-400 font-bold leading-relaxed">
                        <span class="opacity-60 uppercase tracking-widest block mb-1">💡 Pro Tip</span>
                        RPM (Revenue Per Mille) is what you earn after YouTube's 45% cut. Finance/Tech niches often have $10+, while Kids/Gaming might be $1-$2.
                    </p>
                </div>
            </div>
        </div>

        <!-- Results Panel -->
        <div class="lg:col-span-7">
            <div class="grid grid-cols-1 gap-4 h-full">
                <!-- Daily Card -->
                <div class="glass rounded-3xl p-6 border border-slate-100 dark:border-gray-800 flex items-center justify-between group hover:border-red-500/30 transition-all">
                    <div>
                        <p class="text-[10px] font-black uppercase text-slate-400 tracking-widest mb-1">Estimated Daily</p>
                        <h3 class="text-2xl md:text-3xl font-black text-slate-900 dark:text-white" id="earn-daily">$125.00</h3>
                    </div>
                    <div class="w-12 h-12 rounded-2xl bg-red-100 dark:bg-red-900/30 flex items-center justify-center text-red-600">
                        <i data-lucide="calendar" class="w-6 h-6"></i>
                    </div>
                </div>

                <!-- Monthly Card -->
                <div class="glass rounded-3xl p-8 border border-red-100 dark:border-red-900/30 bg-red-600 shadow-2xl shadow-red-600/20 flex items-center justify-between text-white scale-in">
                    <div>
                        <p class="text-[10px] font-black uppercase text-red-100 tracking-widest mb-2 opacity-70">Estimated Monthly</p>
                        <h3 class="text-4xl md:text-5xl font-black" id="earn-monthly">$3,750</h3>
                    </div>
                    <div class="w-16 h-16 rounded-3xl bg-white/20 backdrop-blur-md flex items-center justify-center">
                        <i data-lucide="trending-up" class="w-8 h-8"></i>
                    </div>
                </div>

                <!-- Yearly Card -->
                <div class="glass rounded-3xl p-6 border border-slate-100 dark:border-gray-800 flex items-center justify-between group hover:border-red-500/30 transition-all">
                    <div>
                        <p class="text-[10px] font-black uppercase text-slate-400 tracking-widest mb-1">Estimated Yearly</p>
                        <h3 class="text-2xl md:text-3xl font-black text-slate-900 dark:text-white" id="earn-yearly">$45,000</h3>
                    </div>
                    <div class="w-12 h-12 rounded-2xl bg-red-100 dark:bg-red-900/30 flex items-center justify-center text-red-600">
                        <i data-lucide="globe" class="w-6 h-6"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- SEO Text Section -->
    <div class="mt-16 prose prose-slate dark:prose-invert max-w-none">
        <div class="p-8 rounded-[2rem] bg-red-50/50 dark:bg-red-900/10 border border-red-100 dark:border-red-900/30">
            <?php echo $current_tool['seo_text']; ?>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', () => {
    const viewsSlider = document.getElementById('daily-views');
    const cpmSlider = document.getElementById('est-cpm');
    const viewDisplay = document.getElementById('view-display');
    const cpmDisplay = document.getElementById('cpm-display');
    
    const earnDaily = document.getElementById('earn-daily');
    const earnMonthly = document.getElementById('earn-monthly');
    const earnYearly = document.getElementById('earn-yearly');

    function updateCalculations() {
        const views = parseInt(viewsSlider.value);
        const cpm = parseFloat(cpmSlider.value);

        viewDisplay.innerText = views.toLocaleString();
        cpmDisplay.innerText = '$' + cpm.toFixed(2);

        const daily = (views / 1000) * cpm;
        const monthly = daily * 30.44; // average month
        const yearly = daily * 365;

        earnDaily.innerText = '$' + daily.toLocaleString(undefined, {minimumFractionDigits: 2, maximumFractionDigits: 2});
        earnMonthly.innerText = '$' + Math.round(monthly).toLocaleString();
        earnYearly.innerText = '$' + Math.round(yearly).toLocaleString();
    }

    viewsSlider.addEventListener('input', updateCalculations);
    cpmSlider.addEventListener('input', updateCalculations);

    // Initial run
    updateCalculations();
});
</script>

<?php require_once '../../../includes/footer.php'; ?>
