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
                <div class="px-4 py-2 rounded-xl bg-emerald-500/10 border border-emerald-500/20 flex items-center gap-2 text-emerald-600 dark:text-emerald-400 shadow-lg shadow-emerald-500/5 transition-all">
                    <i data-lucide="calculator" class="w-5 h-5"></i>
                    <span class="text-sm font-medium">Accurate Calc</span>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Tool Area -->
<section class="pb-24 bg-slate-50 dark:bg-gray-950 transition-colors">
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
            
            <!-- Calculator Input -->
            <div class="lg:col-span-5 bg-white dark:bg-gray-900 rounded-[2.5rem] p-8 border border-slate-200 dark:border-gray-800 shadow-xl">
                <div class="space-y-6">
                    <div>
                        <label class="block text-xs font-black uppercase tracking-widest text-slate-400 dark:text-gray-500 mb-2">Initial Amount</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-slate-400 font-bold">₹</div>
                            <input type="number" id="input-amount" placeholder="0.00" class="w-full pl-10 pr-4 py-4 bg-slate-50 dark:bg-gray-800 border-2 border-transparent focus:border-emerald-500 rounded-2xl text-slate-900 dark:text-white font-bold transition-all outline-none">
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-black uppercase tracking-widest text-slate-400 dark:text-gray-500 mb-3">GST Tax Slab</label>
                        <div class="grid grid-cols-4 gap-2">
                            <?php foreach(['5', '12', '18', '28'] as $slab): ?>
                                <button onclick="setSlab(<?php echo $slab; ?>)" class="slab-btn py-3 rounded-xl border-2 border-slate-100 dark:border-gray-800 text-sm font-black text-slate-600 dark:text-gray-400 hover:border-emerald-500 transition-all <?php echo $slab == '18' ? 'active-slab' : ''; ?>" data-slab="<?php echo $slab; ?>"><?php echo $slab; ?>%</button>
                            <?php endforeach; ?>
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-black uppercase tracking-widest text-slate-400 dark:text-gray-500 mb-3">Action Type</label>
                        <div class="flex p-1 bg-slate-50 dark:bg-gray-800 rounded-2xl border border-slate-200 dark:border-gray-700">
                            <button onclick="setType('add')" id="type-add" class="flex-1 py-3 rounded-xl text-xs font-black uppercase tracking-widest transition-all bg-emerald-500 text-white shadow-lg">Add GST</button>
                            <button onclick="setType('remove')" id="type-remove" class="flex-1 py-3 rounded-xl text-xs font-black uppercase tracking-widest transition-all text-slate-500 dark:text-gray-400">Remove GST</button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Results Display -->
            <div class="lg:col-span-7">
                <div class="bg-emerald-600 rounded-[2.5rem] p-8 md:p-12 text-white shadow-2xl relative overflow-hidden flex flex-col justify-between min-h-[400px]">
                    <div class="absolute top-0 right-0 w-64 h-64 bg-white/10 rounded-full blur-3xl -mt-20 -mr-20"></div>
                    <div class="absolute bottom-0 left-0 w-32 h-32 bg-black/10 rounded-full blur-2xl -mb-10 -ml-10"></div>
                    
                    <div class="relative z-10">
                        <div class="flex items-center justify-between mb-12">
                            <span class="px-4 py-1.5 bg-white/20 rounded-full text-[10px] font-black uppercase tracking-widest">Calculation Result</span>
                            <div class="text-right">
                                <p class="text-xs font-bold text-emerald-100/60 uppercase tracking-tighter">Tax Summary</p>
                                <p id="result-type" class="text-sm font-black uppercase tracking-widest">GST Inclusive</p>
                            </div>
                        </div>

                        <div class="grid grid-cols-2 gap-8 mb-12 border-b border-white/10 pb-12">
                            <div>
                                <p class="text-[10px] font-black uppercase tracking-widest text-emerald-100/60 mb-2">Net Amount</p>
                                <p class="text-3xl font-black">₹<span id="res-net">0.00</span></p>
                            </div>
                            <div>
                                <p class="text-[10px] font-black uppercase tracking-widest text-emerald-100/60 mb-2">GST Amount (<span id="res-slab">18</span>%)</p>
                                <p class="text-3xl font-black text-emerald-200">₹<span id="res-gst">0.00</span></p>
                            </div>
                        </div>

                        <div class="flex flex-col md:flex-row md:items-end justify-between gap-6">
                            <div>
                                <p class="text-xs font-black uppercase tracking-widest text-emerald-100/60 mb-3">Total Amount</p>
                                <p class="text-6xl md:text-7xl font-black tracking-tighter tabular-nums leading-none">₹<span id="res-total">0.00</span></p>
                            </div>
                            <button onclick="copyResults()" class="px-6 py-4 bg-white text-emerald-600 rounded-2xl font-black text-sm uppercase tracking-widest shadow-xl active:scale-95 transition-all flex items-center gap-2">
                                <i data-lucide="copy" class="w-4 h-4"></i> Copy Result
                            </button>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <!-- SEO Content -->
        <div class="mt-20 prose prose-slate dark:prose-invert max-w-none">
            <div class="p-8 md:p-12 rounded-[3rem] bg-white dark:bg-gray-900 border border-slate-200 dark:border-gray-800 shadow-sm relative overflow-hidden">
                <div class="absolute top-0 right-0 w-64 h-64 bg-emerald-500/5 rounded-full blur-3xl -mr-20 -mt-20"></div>
                <div class="relative z-10">
                    <?php echo $tool['seo_text']; ?>
                </div>
            </div>
        </div>
    </div>
</section>

<style>
    .active-slab {
        border-color: #10b981 !important;
        background: rgba(16, 185, 129, 0.05);
        color: #10b981 !important;
    }
</style>

<script>
    let currentSlab = 18;
    let currentType = 'add';

    const inputAmount = document.getElementById('input-amount');
    const slabButtons = document.querySelectorAll('.slab-btn');
    const typeAdd = document.getElementById('type-add');
    const typeRemove = document.getElementById('type-remove');

    const resNet = document.getElementById('res-net');
    const resGst = document.getElementById('res-gst');
    const resTotal = document.getElementById('res-total');
    const resSlab = document.getElementById('res-slab');
    const resType = document.getElementById('result-type');

    function setSlab(val) {
        currentSlab = val;
        slabButtons.forEach(btn => btn.classList.remove('active-slab'));
        document.querySelector(`[data-slab="${val}"]`).classList.add('active-slab');
        calculate();
    }

    function setType(type) {
        currentType = type;
        if (type === 'add') {
            typeAdd.className = "flex-1 py-3 rounded-xl text-xs font-black uppercase tracking-widest transition-all bg-emerald-500 text-white shadow-lg";
            typeRemove.className = "flex-1 py-3 rounded-xl text-xs font-black uppercase tracking-widest transition-all text-slate-500 dark:text-gray-400";
            resType.textContent = "GST Inclusive";
        } else {
            typeRemove.className = "flex-1 py-3 rounded-xl text-xs font-black uppercase tracking-widest transition-all bg-emerald-500 text-white shadow-lg";
            typeAdd.className = "flex-1 py-3 rounded-xl text-xs font-black uppercase tracking-widest transition-all text-slate-500 dark:text-gray-400";
            resType.textContent = "GST Exclusive";
        }
        calculate();
    }

    function calculate() {
        const amount = parseFloat(inputAmount.value) || 0;
        let net, gst, total;

        if (currentType === 'add') {
            net = amount;
            gst = (amount * currentSlab) / 100;
            total = amount + gst;
        } else {
            total = amount;
            net = amount / (1 + (currentSlab / 100));
            gst = amount - net;
        }

        resNet.textContent = net.toLocaleString('en-IN', {minimumFractionDigits: 2, maximumFractionDigits: 2});
        resGst.textContent = gst.toLocaleString('en-IN', {minimumFractionDigits: 2, maximumFractionDigits: 2});
        resTotal.textContent = total.toLocaleString('en-IN', {minimumFractionDigits: 2, maximumFractionDigits: 2});
        resSlab.textContent = currentSlab;
    }

    inputAmount.addEventListener('input', calculate);

    function copyResults() {
        const text = `GST Calculation Result\n------------------\nInitial Amount: ₹${inputAmount.value}\nType: ${currentType === 'add' ? 'Added GST' : 'Removed GST'} (${currentSlab}%)\nNet Amount: ₹${resNet.textContent}\nGST Amount: ₹${resGst.textContent}\nTotal Amount: ₹${resTotal.textContent}\n\nGenerated by BulkTools`;
        navigator.clipboard.writeText(text);
        // Toast logic could go here
    }
</script>

<?php require_once '../../../includes/footer.php'; ?>
