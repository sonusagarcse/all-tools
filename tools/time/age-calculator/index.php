<?php
require_once dirname(dirname(dirname(__DIR__))) . '/includes/header.php';
?>

<div class="max-w-4xl mx-auto px-4 py-12">
    <!-- Tool Header -->
    <div class="text-center mb-12">
        <div class="inline-flex items-center justify-center w-16 h-16 rounded-2xl bg-indigo-600/10 text-indigo-600 mb-4">
            <i data-lucide="calculator" class="w-8 h-8"></i>
        </div>
        <h1 class="text-3xl md:text-4xl font-heading font-bold mb-4">Age Calculator</h1>
        <p class="text-slate-600 dark:text-gray-400 max-w-2xl mx-auto">
            Find out exactly how many years, months, and days you've been on this planet. Fast, accurate, and free.
        </p>
    </div>

    <!-- Input Section -->
    <div class="glass rounded-3xl p-6 md:p-8 shadow-xl mb-12">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            <div>
                <label class="block text-xs font-black text-indigo-600 dark:text-indigo-400 uppercase tracking-widest mb-3">Date of Birth</label>
                <input type="date" id="dob" 
                    class="block w-full px-5 py-4 rounded-2xl border border-slate-200 dark:border-gray-800 bg-white dark:bg-gray-900 text-lg font-medium text-slate-900 dark:text-white focus:ring-2 focus:ring-indigo-500 outline-none transition-all">
            </div>
            <div>
                <label class="block text-xs font-black text-slate-400 dark:text-gray-500 uppercase tracking-widest mb-3">Today's Date (Default)</label>
                <input type="date" id="at-date" 
                    value="<?php echo date('Y-m-d'); ?>"
                    class="block w-full px-5 py-4 rounded-2xl border border-slate-200 dark:border-gray-800 bg-slate-50 dark:bg-gray-950 text-lg font-medium text-slate-500 dark:text-gray-500 focus:ring-2 focus:ring-indigo-500 outline-none transition-all">
            </div>
        </div>
        <div class="mt-8">
            <button id="calculate-btn" class="w-full py-5 bg-indigo-600 hover:bg-indigo-700 text-white font-black text-lg rounded-2xl transition-all active:scale-[0.98] shadow-xl shadow-indigo-500/20 flex items-center justify-center gap-3">
                <i data-lucide="zap" class="w-6 h-6"></i>
                Calculate My Age
            </button>
        </div>
    </div>

    <!-- Results Section (Hidden initially) -->
    <div id="results" class="hidden animate-in fade-in slide-in-from-bottom-4 duration-500">
        
        <!-- Primary Age Card -->
        <div class="glass rounded-[2rem] p-6 md:p-12 border border-indigo-100 dark:border-indigo-900/30 mb-8 text-center relative overflow-hidden">
            <div class="absolute top-0 right-0 w-64 h-64 bg-indigo-600/5 rounded-full blur-3xl -mr-32 -mt-32"></div>
            
            <p class="text-[10px] md:text-xs font-black text-indigo-600 dark:text-indigo-400 uppercase tracking-[0.2em] mb-4">Your Exact Age</p>
            <h2 class="text-4xl md:text-7xl font-heading font-black text-slate-900 dark:text-white mb-8" id="age-text">
                00 <span class="text-xl md:text-2xl text-slate-400">Years</span>
            </h2>
            
            <div class="grid grid-cols-3 gap-3 md:gap-4 max-w-md mx-auto">
                <div class="p-3 md:p-4 bg-slate-50 dark:bg-gray-900/50 rounded-2xl border border-slate-100 dark:border-gray-800">
                    <p class="text-xl md:text-2xl font-black text-indigo-600 dark:text-indigo-400" id="res-years">0</p>
                    <p class="text-[9px] md:text-[10px] uppercase font-bold text-slate-400">Years</p>
                </div>
                <div class="p-3 md:p-4 bg-slate-50 dark:bg-gray-900/50 rounded-2xl border border-slate-100 dark:border-gray-800">
                    <p class="text-xl md:text-2xl font-black text-indigo-600 dark:text-indigo-400" id="res-months">0</p>
                    <p class="text-[9px] md:text-[10px] uppercase font-bold text-slate-400">Months</p>
                </div>
                <div class="p-3 md:p-4 bg-slate-50 dark:bg-gray-900/50 rounded-2xl border border-slate-100 dark:border-gray-800">
                    <p class="text-xl md:text-2xl font-black text-indigo-600 dark:text-indigo-400" id="res-days">0</p>
                    <p class="text-[9px] md:text-[10px] uppercase font-bold text-slate-400">Days</p>
                </div>
            </div>
        </div>

        <!-- Lifetime Stats Grid -->
        <div class="grid grid-cols-2 md:grid-cols-4 gap-3 md:gap-4 mb-8">
            <div class="glass p-4 md:p-5 rounded-2xl border border-slate-200 dark:border-gray-800">
                <p class="text-[9px] md:text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1">Total Months</p>
                <p class="text-lg md:text-xl font-bold text-slate-900 dark:text-white" id="total-months">0</p>
            </div>
            <div class="glass p-4 md:p-5 rounded-2xl border border-slate-200 dark:border-gray-800">
                <p class="text-[9px] md:text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1">Total Weeks</p>
                <p class="text-lg md:text-xl font-bold text-slate-900 dark:text-white" id="total-weeks">0</p>
            </div>
            <div class="glass p-4 md:p-5 rounded-2xl border border-slate-200 dark:border-gray-800">
                <p class="text-[9px] md:text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1">Total Days</p>
                <p class="text-lg md:text-xl font-bold text-slate-900 dark:text-white" id="total-days">0</p>
            </div>
            <div class="glass p-4 md:p-5 rounded-2xl border border-slate-200 dark:border-gray-800">
                <p class="text-[9px] md:text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1">Total Hours</p>
                <p class="text-lg md:text-xl font-bold text-slate-900 dark:text-white" id="total-hours">0</p>
            </div>
        </div>

        <!-- Next Birthday Card -->
        <div class="p-6 rounded-[2rem] bg-indigo-600 text-white shadow-xl shadow-indigo-500/20 flex flex-col md:flex-row items-center justify-between gap-6">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 md:w-14 md:h-14 bg-white/20 backdrop-blur-md rounded-2xl flex items-center justify-center">
                    <i data-lucide="cake" class="w-6 h-6 md:w-8 md:h-8"></i>
                </div>
                <div>
                    <h3 class="text-base md:text-lg font-black italic">Upcoming Birthday</h3>
                    <p class="text-indigo-100 text-[10px] md:text-xs" id="birthday-day-text">Your next birthday is on a Monday.</p>
                </div>
            </div>
            <div class="text-center md:text-right">
                <p class="text-[9px] md:text-[10px] font-black uppercase tracking-widest opacity-70 mb-1">Countdown</p>
                <p class="text-xl md:text-2xl font-black" id="next-birthday-countdown">0 Months, 0 Days</p>
            </div>
        </div>
    </div>

    <!-- SEO Text Section -->
    <div class="mt-16 prose prose-slate dark:prose-invert max-w-none">
        <div class="p-8 rounded-[2rem] bg-indigo-50/50 dark:bg-indigo-900/10 border border-indigo-100 dark:border-indigo-900/30">
            <?php echo $current_tool['seo_text']; ?>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', () => {
    const dobInput = document.getElementById('dob');
    const atDateInput = document.getElementById('at-date');
    const calculateBtn = document.getElementById('calculate-btn');
    const results = document.getElementById('results');

    // Display elements
    const ageText = document.getElementById('age-text');
    const resYears = document.getElementById('res-years');
    const resMonths = document.getElementById('res-months');
    const resDays = document.getElementById('res-days');
    const totalMonths = document.getElementById('total-months');
    const totalWeeks = document.getElementById('total-weeks');
    const totalDays = document.getElementById('total-days');
    const totalHours = document.getElementById('total-hours');
    const nextBdayText = document.getElementById('birthday-day-text');
    const nextBdayCountdown = document.getElementById('next-birthday-countdown');

    calculateBtn.onclick = () => {
        const dob = new Date(dobInput.value);
        const now = new Date(atDateInput.value);

        if (isNaN(dob.getTime())) {
            alert("Please enter a valid Date of Birth.");
            return;
        }

        if (dob > now) {
            alert("Date of birth cannot be in the future!");
            return;
        }

        // 1. Calculate Age (Y, M, D)
        let years = now.getFullYear() - dob.getFullYear();
        let months = now.getMonth() - dob.getMonth();
        let days = now.getDate() - dob.getDate();

        if (days < 0) {
            months--;
            const lastMonth = new Date(now.getFullYear(), now.getMonth(), 0);
            days += lastMonth.getDate();
        }
        if (months < 0) {
            years--;
            months += 12;
        }

        // 2. Display Secondary Stats
        const totalMs = now - dob;
        const tDays = Math.floor(totalMs / (1000 * 60 * 60 * 24));
        const tMonths = (years * 12) + months;
        const tWeeks = Math.floor(tDays / 7);
        const tHours = tDays * 24;

        // 3. Next Birthday
        let nextBday = new Date(now.getFullYear(), dob.getMonth(), dob.getDate());
        if (nextBday < now) {
            nextBday.setFullYear(now.getFullYear() + 1);
        }
        
        const diffMs = nextBday - now;
        const dDays = Math.floor(diffMs / (1000 * 60 * 60 * 24));
        
        // Calculate remaining months/days for countdown
        let nextBdayMonths = nextBday.getMonth() - now.getMonth();
        let nextBdayDays = nextBday.getDate() - now.getDate();
        
        if (nextBdayDays < 0) {
            nextBdayMonths--;
            const lastMonth = new Date(nextBday.getFullYear(), nextBday.getMonth(), 0);
            nextBdayDays += lastMonth.getDate();
        }
        if (nextBdayMonths < 0) {
            nextBdayMonths += 12;
        }

        const daysOfWeek = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];
        const dayOfBday = daysOfWeek[nextBday.getDay()];

        // Update UI
        ageText.innerHTML = `${years} <span class="text-2xl text-slate-400">Years Old</span>`;
        resYears.innerText = years;
        resMonths.innerText = months;
        resDays.innerText = days;

        totalMonths.innerText = tMonths.toLocaleString();
        totalWeeks.innerText = tWeeks.toLocaleString();
        totalDays.innerText = tDays.toLocaleString();
        totalHours.innerText = tHours.toLocaleString();

        nextBdayText.innerText = `Your next birthday falls on a ${dayOfBday}.`;
        nextBdayCountdown.innerText = `${nextBdayMonths} Months, ${nextBdayDays} Days`;

        results.classList.remove('hidden');
        results.scrollIntoView({ behavior: 'smooth', block: 'start' });
        
        if (typeof lucide !== 'undefined') lucide.createIcons();
    };
});
</script>

<?php require_once dirname(dirname(dirname(__DIR__))) . '/includes/footer.php'; ?>
