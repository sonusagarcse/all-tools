<?php
require_once '../../../includes/header.php';
?>

<div class="max-w-4xl mx-auto px-4 py-6 md:py-12">
    <!-- Tool Header -->
    <div class="text-center mb-8 md:mb-12">
        <div class="inline-flex items-center justify-center w-12 h-12 md:w-16 md:h-16 rounded-2xl bg-rose-600/10 text-rose-600 mb-4">
            <i data-lucide="activity" class="w-6 h-6 md:w-8 md:h-8"></i>
        </div>
        <h1 class="text-2xl md:text-4xl font-heading font-bold mb-3 px-2">Professional BMI Calculator</h1>
        <p class="text-sm md:text-base text-slate-600 dark:text-gray-400 max-w-2xl mx-auto px-4">
            Calculate your Body Mass Index (BMI) and discover your ideal weight range based on official WHO standards.
        </p>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
        <!-- Input Panel -->
        <div class="lg:col-span-5">
            <div class="glass rounded-3xl p-6 md:p-8 shadow-xl border border-slate-200 dark:border-gray-800">
                <!-- Unit Toggle -->
                <div class="flex p-1 bg-slate-100 dark:bg-gray-900 rounded-2xl mb-8">
                    <button onclick="setUnit('metric')" id="btn-metric" class="flex-1 py-3 rounded-xl text-xs font-black uppercase tracking-widest transition-all bg-white dark:bg-gray-800 shadow-sm text-rose-600">Metric (kg/cm)</button>
                    <button onclick="setUnit('imperial')" id="btn-imperial" class="flex-1 py-3 rounded-xl text-xs font-black uppercase tracking-widest transition-all text-slate-400 opacity-60">Imperial (lb/ft)</button>
                </div>

                <!-- Metric Inputs -->
                <div id="metric-inputs">
                    <div class="mb-6">
                        <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2">Height (Centimeters)</label>
                        <input type="number" id="height-cm" placeholder="175" class="w-full px-5 py-4 rounded-2xl border border-slate-200 dark:border-gray-800 bg-white dark:bg-gray-900 text-lg font-mono focus:ring-2 focus:ring-rose-500 outline-none transition-all">
                    </div>
                    <div class="mb-8">
                        <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2">Weight (Kilograms)</label>
                        <input type="number" id="weight-kg" placeholder="70" class="w-full px-5 py-4 rounded-2xl border border-slate-200 dark:border-gray-800 bg-white dark:bg-gray-900 text-lg font-mono focus:ring-2 focus:ring-rose-500 outline-none transition-all">
                    </div>
                </div>

                <!-- Imperial Inputs -->
                <div id="imperial-inputs" class="hidden">
                    <div class="grid grid-cols-2 gap-4 mb-6">
                        <div>
                            <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2">Height (Feet)</label>
                            <input type="number" id="height-ft" placeholder="5" class="w-full px-5 py-4 rounded-2xl border border-slate-200 dark:border-gray-800 bg-white dark:bg-gray-900 text-lg font-mono focus:ring-2 focus:ring-rose-500 outline-none transition-all">
                        </div>
                        <div>
                            <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2">Height (Inches)</label>
                            <input type="number" id="height-in" placeholder="9" class="w-full px-5 py-4 rounded-2xl border border-slate-200 dark:border-gray-800 bg-white dark:bg-gray-900 text-lg font-mono focus:ring-2 focus:ring-rose-500 outline-none transition-all">
                        </div>
                    </div>
                    <div class="mb-8">
                        <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2">Weight (Pounds)</label>
                        <input type="number" id="weight-lb" placeholder="154" class="w-full px-5 py-4 rounded-2xl border border-slate-200 dark:border-gray-800 bg-white dark:bg-gray-900 text-lg font-mono focus:ring-2 focus:ring-rose-500 outline-none transition-all">
                    </div>
                </div>

                <button onclick="calculateBMI()" class="w-full py-5 bg-rose-600 hover:bg-rose-700 text-white font-black text-lg rounded-2xl transition-all active:scale-[0.98] shadow-xl shadow-rose-500/20 flex items-center justify-center gap-3">
                    <i data-lucide="zap" class="w-6 h-6"></i>
                    Calculate BMI
                </button>
            </div>
        </div>

        <!-- Result Panel -->
        <div class="lg:col-span-7">
            <div id="result-placeholder" class="h-full min-h-[300px] flex flex-col items-center justify-center glass rounded-3xl border border-dashed border-slate-200 dark:border-gray-800 text-slate-400">
                <i data-lucide="calculator" class="w-16 h-16 mb-4 opacity-20"></i>
                <p class="font-medium">Enter your details to see results</p>
            </div>

            <div id="result-card" class="hidden animate-in fade-in zoom-in-95 duration-500">
                <div class="glass rounded-3xl p-8 shadow-xl border border-rose-100 dark:border-rose-900/30 text-center relative overflow-hidden h-full">
                    <div class="absolute top-0 left-0 w-full h-2 bg-slate-100 dark:bg-gray-900">
                        <div id="bmi-bar" class="h-full bg-emerald-500 transition-all duration-1000" style="width: 50%;"></div>
                    </div>
                    
                    <p class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-4 mt-4">Your BMI Score</p>
                    <h2 class="text-6xl md:text-8xl font-heading font-black text-slate-900 dark:text-white mb-2" id="res-bmi">22.4</h2>
                    <p class="text-xl md:text-2xl font-black italic uppercase tracking-widest text-emerald-500 mb-8" id="res-category">Healthy Weight</p>

                    <!-- Stats Grid -->
                    <div class="grid grid-cols-2 gap-4 mb-8">
                        <div class="p-4 bg-slate-50 dark:bg-gray-900/50 rounded-2xl border border-slate-100 dark:border-gray-800">
                            <p class="text-[9px] font-black uppercase text-slate-400 mb-1">Ideal Weight Range</p>
                            <p class="text-lg font-black text-slate-800 dark:text-white" id="res-ideal">56.7kg - 76.5kg</p>
                        </div>
                        <div class="p-4 bg-slate-50 dark:bg-gray-900/50 rounded-2xl border border-slate-100 dark:border-gray-800">
                            <p class="text-[9px] font-black uppercase text-slate-400 mb-1">Risk Level</p>
                            <p class="text-lg font-black text-slate-800 dark:text-white" id="res-risk">Low / Minimal</p>
                        </div>
                    </div>

                    <!-- Small Gauge Label -->
                    <div class="flex justify-between text-[8px] font-black text-slate-400 px-2 uppercase">
                        <span>Under</span>
                        <span class="text-emerald-500">Normal</span>
                        <span class="text-orange-500">Over</span>
                        <span class="text-rose-500">Obese</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- SEO Text Section -->
    <div class="mt-16 prose prose-slate dark:prose-invert max-w-none">
        <div class="p-8 rounded-[2rem] bg-rose-50/50 dark:bg-rose-900/10 border border-rose-100 dark:border-rose-900/30">
            <?php echo $current_tool['seo_text']; ?>
        </div>
    </div>
</div>

<script>
let currentUnit = 'metric';

function setUnit(unit) {
    currentUnit = unit;
    const metric = document.getElementById('metric-inputs');
    const imperial = document.getElementById('imperial-inputs');
    const btnM = document.getElementById('btn-metric');
    const btnI = document.getElementById('btn-imperial');

    if (unit === 'metric') {
        metric.classList.remove('hidden');
        imperial.classList.add('hidden');
        btnM.classList.add('bg-white', 'dark:bg-gray-800', 'shadow-sm', 'text-rose-600');
        btnI.classList.remove('bg-white', 'dark:bg-gray-800', 'shadow-sm', 'text-rose-600');
        btnM.classList.remove('text-slate-400', 'opacity-60');
        btnI.classList.add('text-slate-400', 'opacity-60');
    } else {
        metric.classList.add('hidden');
        imperial.classList.remove('hidden');
        btnI.classList.add('bg-white', 'dark:bg-gray-800', 'shadow-sm', 'text-rose-600');
        btnM.classList.remove('bg-white', 'dark:bg-gray-800', 'shadow-sm', 'text-rose-600');
        btnI.classList.remove('text-slate-400', 'opacity-60');
        btnM.classList.add('text-slate-400', 'opacity-60');
    }
}

function calculateBMI() {
    let height = 0; // meters
    let weight = 0; // kilograms

    if (currentUnit === 'metric') {
        const cm = parseFloat(document.getElementById('height-cm').value);
        weight = parseFloat(document.getElementById('weight-kg').value);
        if (!cm || !weight) return alert("Please enter valid height and weight.");
        height = cm / 100;
    } else {
        const ft = parseFloat(document.getElementById('height-ft').value) || 0;
        const inch = parseFloat(document.getElementById('height-in').value) || 0;
        const lbs = parseFloat(document.getElementById('weight-lb').value);
        if (!lbs || (ft === 0 && inch === 0)) return alert("Please enter valid height and weight.");
        
        height = ((ft * 12) + inch) * 0.0254; // to meters
        weight = lbs * 0.453592; // to kg
    }

    const bmi = weight / (height * height);
    const resBmi = document.getElementById('res-bmi');
    const resCat = document.getElementById('res-category');
    const resIdeal = document.getElementById('res-ideal');
    const resRisk = document.getElementById('res-risk');
    const bmiBar = document.getElementById('bmi-bar');

    resBmi.innerText = bmi.toFixed(1);

    // Categories
    let category = '';
    let color = '';
    let pct = 0;
    let risk = '';

    if (bmi < 18.5) {
        category = 'Underweight';
        color = '#3b82f6'; // blue
        pct = (bmi / 18.5) * 25;
        risk = 'Possible Malnutrition';
    } else if (bmi < 25) {
        category = 'Normal Weight';
        color = '#10b981'; // emerald
        pct = 25 + ((bmi - 18.5) / 6.5) * 25;
        risk = 'Low / Minimal';
    } else if (bmi < 30) {
        category = 'Overweight';
        color = '#f59e0b'; // orange
        pct = 50 + ((bmi - 25) / 5) * 25;
        risk = 'Increased Risk';
    } else {
        category = 'Obese';
        color = '#ef4444'; // rose
        pct = 75 + Math.min(((bmi - 30) / 10) * 25, 25);
        risk = 'High Health Risk';
    }

    const idealLow = (18.5 * height * height).toFixed(1);
    const idealHigh = (24.9 * height * height).toFixed(1);
    const unitLabel = currentUnit === 'metric' ? 'kg' : 'lb';
    
    let idealText = `${idealLow}${unitLabel} - ${idealHigh}${unitLabel}`;
    if (currentUnit === 'imperial') {
        const lbLow = (idealLow * 2.20462).toFixed(1);
        const lbHigh = (idealHigh * 2.20462).toFixed(1);
        idealText = `${lbLow}lb - ${lbHigh}lb`;
    }

    resCat.innerText = category;
    resCat.style.color = color;
    resIdeal.innerText = idealText;
    resRisk.innerText = risk;
    bmiBar.style.width = pct + '%';
    bmiBar.style.backgroundColor = color;

    document.getElementById('result-placeholder').classList.add('hidden');
    document.getElementById('result-card').classList.remove('hidden');
    
    if (typeof lucide !== 'undefined') lucide.createIcons();
}
</script>

<?php require_once '../../../includes/footer.php'; ?>
